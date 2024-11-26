<?php

class Myclassmodel{

    use Model;

    public $premiumtable = 'premium_teacher';
    public $allowedColumnspre=[
        'P_id','Payment_details','Issubbed'
    ];

    public $table1='class';
    public $allowedColumns1=[
        'Subject','Grade','Max_std','fee'
    ];

    public $table2='individual_class';
    public $allowedColumns2=[
        'Location','Start_Time','End_time'
    ];
    protected $ColumnsforT2 = [
        'IndClass_id', 'P_id', 'Location', 'Start_Time', 'End_time'
    ];

    public $joinCondition = "class.class_id = individual_class.IndClass_id";

    public function checkPremium($id)
    {
        $query = "SELECT P_id FROM {$this->premiumtable} WHERE P_id = :P_id LIMIT 1";
        $params = ['P_id' => $id];
        $result = $this->query($query, $params);
        return !empty($result);
    }

    //delete model
    public function deleteclass($id,$id_column='Class_id'){
        try{
        $data[$id_column]=$id;
        $query="delete from $this->table1 where $id_column = :$id_column ";
        $this->query($query,$data);
        return true;
        }
       catch (Exception $e){
        return false;
    
      }  
    }

    //update model
    public function updateclass($id, $data, $id_column = 'Class_id', $table = '', $allowedColumns = []) {
        $allowedTables = ['class', 'individual_class']; 
        if (!in_array($table, $allowedTables)) {
            error_log("Invalid table name: $table");
            return false;
        }
        $filteredData = [];
        if (!empty($allowedColumns)) {
            foreach ($data as $key => $value) {
                if (in_array($key, $allowedColumns)) {
                    $filteredData[$key] = $value; // Keep only allowed columns
                }
            }
        }
        if (empty($filteredData)) {
            error_log("No valid data to update for table: $table");
            return false;
        }
        $keys = array_keys($filteredData);
        $query = "UPDATE $table SET ";
        foreach ($keys as $key) {
            $query .= "$key = :$key, "; // Add column and placeholder
        }
        $query = rtrim($query, ', '); // Remove the trailing comma
        $query .= " WHERE $id_column = :$id_column"; // Add WHERE clause
        $filteredData[$id_column] = $id;
        try {
            // Execute the query using the duiquery method
            $affectedRows = $this->duiquery($query, $filteredData);
    
            error_log("Rows affected for table $table: $affectedRows");
    
            return $affectedRows > 0; // Return true if rows were updated
        } catch (Exception $e) {
            error_log("Error executing update query for table $table: " . $e->getMessage());
            return false;
        }
    }

    //get class id
    public function getid($data,$data_not=[]){
        $keys=array_keys($data);
        $keys_not=array_keys($data_not);
        $query="select * from $this->table1 where ";
        foreach($keys as $key){
                $query.=$key."=:".$key." && ";
        }
        foreach($keys_not as $key){
            $query.=$key."!=:".$key." && ";
        }
        $query=trim($query," && ");
        $query.=" limit $this->limit offset $this->offset";
        $data=array_merge($data,$data_not);
        return $this->query($query,$data);
    }

    //insert model for two tables
    public function insertclass($data1, $data2, $P_id) {
        $filteredData1 = [];
        if (!empty($this->allowedColumns1)) {
            foreach ($data1 as $key => $value) {
                if (in_array($key, $this->allowedColumns1)) {
                    $filteredData1[$key] = $value;
                }
            }
        }
        if (empty($filteredData1)) {
            error_log("No valid data to insert for table: class");
            return false;
        }
        $keys1 = array_keys($filteredData1);
        $query1 = "INSERT INTO class (" . implode(", ", $keys1) . ") VALUES (:" . implode(", :", $keys1) . ")";
        try {
            $this->duiquery($query1, $filteredData1);
            $class_id_result = $this->getid($filteredData1);
            if (empty($class_id_result) || !isset($class_id_result[0]['Class_id'])) {
                error_log("Failed to retrieve class_id after inserting into class");
                return false;
            }
            $class_id = $class_id_result[0]['Class_id']; 
            $filteredData2 = [];
            if (!empty($this->ColumnsforT2)) {
                foreach ($data2 as $key => $value) {
                    if (in_array($key, $this->ColumnsforT2)) {
                        $filteredData2[$key] = $value;
                    }
                }
            }
            if (empty($filteredData2)) {
                error_log("No valid data to insert for table: individual_class");
                return false;
            }
            $filteredData2['Class_id'] = $class_id;
            $filteredData2['P_id'] = $P_id;
            $keys2 = array_keys($filteredData2);
            $query2 = "INSERT INTO individual_class (" . implode(", ", $keys2) . ") VALUES (:" . implode(", :", $keys2) . ")";
            $this->duiquery($query2, $filteredData2);
            return true;
        } catch (Exception $e) {
            error_log("Error executing insert query for tables: class or individual_class: " . $e->getMessage());
            return false;
        }
    }
    
        
}