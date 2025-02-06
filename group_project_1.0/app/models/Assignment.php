    <?php
    class Assignment {
        use Model;
        
        public $table = 'assignment_marks';
        public $table2 = 'assignment_table';
        
        public function createTrigger() {
            $dropTrigger = "DROP TRIGGER IF EXISTS after_assignment_insert";
            
            $createTrigger = "
                CREATE TRIGGER after_assignment_insert 
                AFTER INSERT ON {$this->table2}
                FOR EACH ROW 
                BEGIN
                    SET @last_ass_id = NEW.Ass_id;
                END;
            ";
            
            try {
                $this->query($dropTrigger);
                return $this->query($createTrigger);
            } catch (Exception $e) {
                return false;
            }
        }
        
        public function insertASS($Class_id) {
            try {
                $this->query("SET @last_ass_id = NULL");
                $query = "INSERT INTO {$this->table2} (Class_id) VALUES (:class_id)";
                $data = ['Class_id' => $Class_id];
                $result = $this->duiquery($query, $data);
                $lastAssId = $this->query("SELECT @last_ass_id as id")->fetch(PDO::FETCH_ASSOC);
                return $lastAssId['id'] ?? false;
            } catch (Exception $e) {
                throw new Exception("Failed to insert into assignment_table: " . $e->getMessage());
            }
        }
        
        public function insertAssignmentMarks($Ass_id, $Stu_id, $Name, $Marks) {
            try {
                $query = "INSERT INTO {$this->table} (Ass_id, Stu_id, Name, Marks) 
                        VALUES (:ass_id, :stu_id, :name, :marks)";
                
                $data = [
                    'Ass_id' => $Ass_id,
                    'Stu_id' => $Stu_id,
                    'Name' => $Name,
                    'Marks' => $Marks
                ];
                
                return $this->query($query, $data);
            } catch (Exception $e) {
                throw new Exception("Failed to insert assignment marks: " . $e->getMessage());
            }
        }
        


        // Delete Assignments
        public function Del_ass($id, $id_column='Ass_id') {
            try {
                $data[$id_column] = $id;
                $query = "DELETE FROM $this->table2 WHERE $id_column = :$id_column";
                $this->query($query, $data);
                return true;
            } catch (Exception $e) {
                return false;
            }
        }

        //All assingments
        public function allassingsments() {
            $query = "SELECT * FROM $this->table2";
            return $this->query($query);
        }

        //update a Spesific student mark
        public function UpdateSTUM($conditions, $data) {

            $setClauses = [];
            foreach ($data as $key => $value) {
                $setClauses[] = "$key = :$key";
            }
            $setQuery = implode(", ", $setClauses);
        
            $whereClauses = [];
            foreach ($conditions as $key => $value) {
                $whereClauses[] = "$key = :where_$key";
            }
            $whereQuery = implode(" AND ", $whereClauses);
        
            foreach ($conditions as $key => $value) {
                $data["where_$key"] = $value;
            }
        
            $query = "UPDATE $this->table SET $setQuery WHERE $whereQuery";
        
            try {
                $this->duiquery($query, $data);
                return true;  // Success
            } catch (Exception $e) {
                if (defined('DEBUG')) {
                    echo "Update failed: " . $e->getMessage();
                }
                return false;  // Failure
            }
        }
        
        
    }