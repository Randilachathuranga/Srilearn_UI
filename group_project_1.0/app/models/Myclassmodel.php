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
        // Ensure the table is valid
        $allowedTables = ['class', 'individual_class']; // Define allowed table names
        if (!in_array($table, $allowedTables)) {
            error_log("Invalid table name: $table");
            return false;
        }
    
        // Filter data by allowed columns
        $filteredData = [];
        if (!empty($allowedColumns)) {
            foreach ($data as $key => $value) {
                if (in_array($key, $allowedColumns)) {
                    $filteredData[$key] = $value; // Keep only allowed columns
                }
            }
        }
    
        // If no valid data remains after filtering, return false
        if (empty($filteredData)) {
            error_log("No valid data to update for table: $table");
            return false;
        }
    
        // Prepare the query dynamically
        $keys = array_keys($filteredData);
        $query = "UPDATE $table SET ";
        foreach ($keys as $key) {
            $query .= "$key = :$key, "; // Add column and placeholder
        }
        $query = rtrim($query, ', '); // Remove the trailing comma
        $query .= " WHERE $id_column = :$id_column"; // Add WHERE clause
    
        // Add the ID to the data array for binding
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
        
}