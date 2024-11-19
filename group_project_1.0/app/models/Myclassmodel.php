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

    //insert model for two tables
    public function insertclass($data1,$data2){
        $filteredData1 = [];
        $filteredData2 = [];
        if (!empty($this->allowedColumns1)) {
            foreach ($data1 as $key => $value) {
                if (in_array($key, $this->allowedColumns1)) {
                    $filteredData1[$key] = $value; // Keep only allowed columns
                }
            }
        }
        if (!empty($this->allowedColumns2)) {
            foreach ($data2 as $key => $value) {
                if (in_array($key, $this->allowedColumns2)) {
                    $filteredData2[$key] = $value; // Keep only allowed columns
                }
            }
        }
        if (empty($filteredData1) || empty($filteredData2)) {
            error_log("No valid data to insert for tables: class or individual_class");
            return false;
        }
        $keys1 = array_keys($filteredData1);
        $keys2 = array_keys($filteredData2);
        $query1 = "INSERT INTO class (" . implode(", ", $keys1) . ") VALUES (:" . implode(", :", $keys1) . ")";
        $query2 = "INSERT INTO individual_class (" . implode(", ", $keys2) . ") VALUES (:" . implode(", :", $keys2) . ")";
        try {
            $this->duiquery($query1, $filteredData1);
            $this->duiquery($query2, $filteredData2);
            return true;
        } catch (Exception $e) {
            error_log("Error executing insert query for tables: class or individual_class: " . $e->getMessage());
            return false;
        }
    }
        
}