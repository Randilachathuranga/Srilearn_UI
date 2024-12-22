<?php
class Enrollmodel{
    
    use Model;

    protected $table='enrollment';
    protected $allowedColumns=[
        'Enrollment_id','Stu_id','Class_id','Date','Isdiscountavail'
    ];

    public function checkisEnrolled($Stu_id, $Class_id)
    {
        $query = "SELECT Stu_id FROM {$this->table} WHERE Stu_id = :Stu_id AND Class_id = :Class_id LIMIT 1";
        $params = ['Stu_id' => $Stu_id, 'Class_id' => $Class_id];
        $result = $this->query($query, $params);
        return !empty($result); // Return true if the student is already enrolled
    }

   


    public function ChangeIsdiscountavail($id, $id2, $data, $id_column = 'Stu_id', $id_column2 = 'Class_id') {
        if (empty($this->table)) {
            throw new Exception("Table name is not set.");
        }
    
        if (!empty($this->allowedColumns)) {
            foreach ($data as $key => $value) {
                if (!in_array($key, $this->allowedColumns)) {
                    unset($data[$key]);
                }
            }
        }
    
        $keys = array_keys($data);
        $query = "UPDATE $this->table SET ";
        foreach ($keys as $key) {
            $query .= "$key = :$key, ";
        }
        $query = rtrim($query, ", ");
        $query .= " WHERE $id_column = :$id_column AND $id_column2 = :$id_column2";
        
        $data[$id_column] = $id;
        $data[$id_column2] = $id2;
    
        try {
            $this->duiquery($query, $data);
            return true;
        } catch (Exception $e) {
            if (defined('DEBUG')) {
                echo "Update failed: " . $e->getMessage();
            }
            return false;
        }
    }

}