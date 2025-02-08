    <?php
    class Assignment {
        use Model;
        
        public $table = 'assignment_marks';
        public $table2 = 'assignment_table';

        public function last_InsertId() {
            $query = "SELECT MAX(Ass_id) AS last_id FROM {$this->table2}";
            
            $result = $this->query($query);  // Execute the query
            
            // Check if result exists and return the last ID
            if ($result && isset($result[0]->last_id)) {
                return $result[0]->last_id;
            }
            
            // Return null if the query fails or no result
            return null;
        }
        
    
        public function insertASS($Class_id) {
            try {
                $query = "INSERT INTO {$this->table2} (Class_id) VALUES (:class_id)";
                $data = ['class_id' => $Class_id];
    
                $this->duiquery($query, $data);
    
            } catch (Exception $e) {
                throw new Exception("Database error: " . $e->getMessage());
            }
        }
    
        public function insertAssignmentMarks($Ass_id, $studentData) {
            try {
                if (!$Ass_id) {
                    throw new Exception("Invalid Assignment ID");
                }
    
                $query = "INSERT INTO {$this->table} (Ass_id, Stu_id, Name, Marks) 
                         VALUES (:ass_id, :stu_id, :name, :marks)";
                
                $successCount = 0;
    
                foreach ($studentData as $student) {
                    $data = [
                        'ass_id' => $Ass_id,
                        'stu_id' => $student['Stu_id'],
                        'name' => $student['Name'],
                        'marks' => $student['Marks']
                    ];
    
                    if ($this->query($query, $data)) {
                        $successCount++;
                    }
                }
    
                return $successCount;
    
            } catch (Exception $e) {
                throw new Exception("Failed to insert marks: " . $e->getMessage());
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
        public function allAssignments($Class_id) {
            $query = "SELECT * FROM $this->table2 AS t 
                      LEFT JOIN $this->table AS m ON t.Ass_id = m.Ass_id 
                      WHERE t.Class_id = :Class_id";
        
            return $this->query($query, ['Class_id' => $Class_id]);
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