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
        'Location','Start_date','End_date'
    ];

    public $table3 = 'instituteteacher_class';
    public $joinCondition3 = "class.class_id = instituteteacher_class.InstClass_id";
    // public $allowedColumns3=[
    //     'Location','Start_date','End_date'
    // ];

    //columns for insert into class table and individual class table
    public $ColumnsforT1=[
        'Type','Subject','Grade','Max_std','fee'
    ];

    protected $ColumnsforT2 = [
        'IndClass_id', 'P_id', 'Location', 'Start_date', 'End_date'
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

    // Get the Class_id
    public function getLastInsertId($data, $data_not = []) {
        $keys = array_keys($data);
        $keys_not = array_keys($data_not);
        $query = "SELECT Class_id FROM class WHERE ";
        foreach ($keys as $key) {
            $query .= $key . "=:" . $key . " AND ";
        }
        foreach ($keys_not as $key) {
            $query .= $key . "!=:" . $key . " AND ";
        }
        $query = rtrim($query, " AND ");
        $query .= " LIMIT $this->limit OFFSET $this->offset";
        $data = array_merge($data, $data_not);
        $result = $this->query($query, $data);
        if ($result && isset($result[0]->Class_id)) {
            return $result[0]->Class_id;
        }
        return false;
    }
    

// Insert a class and associated individual_class data
public function insertclass($data1, $data2) {
    $filteredData1 = [];

    // Filter data for the `class` table
    if (!empty($this->ColumnsforT1)) {
        foreach ($data1 as $key => $value) {
            if (in_array($key, $this->ColumnsforT1)) {
                $filteredData1[$key] = $value;
            }
        }
    }

    // If no valid data for `class` table, log and exit
    if (empty($filteredData1)) {
        error_log("No valid data to insert for table: class");
        return false;
    }

    // Build and execute the query for the `class` table
    $keys1 = array_keys($filteredData1);
    $query1 = "INSERT INTO class (" . implode(", ", $keys1) . ") VALUES (:" . implode(", :", $keys1) . ")";
    try {
        $this->duiquery($query1, $filteredData1);
    } catch (Exception $e) {
        error_log("Error inserting data into `class`: " . $e->getMessage());
        return false;
    }

    // Get the `class_id` of the newly inserted record using MySQL's LAST_INSERT_ID()

    $data_not1 = [];
    $class_id = $this->getLastInsertId($filteredData1,$data_not1);  // Method to fetch last inserted ID
    $class_ID = (int)$class_id;
    if (!$class_ID) {
        error_log("Error retrieving `class_id` after insert");
        return false;
    }

    // Prepare data for the `individual_class` table
    $filteredData2 = [
        'IndClass_id' => $class_ID,
    ];

    if (!empty($this->ColumnsforT2)) {
        foreach ($data2 as $key => $value) {
            if (in_array($key, $this->ColumnsforT2)) {
                $filteredData2[$key] = $value;
            }
        }
    }

    // If no valid data for `individual_class` table, log and exit
    if (empty($filteredData2)) {
        error_log("No valid data to insert for table: individual_class");
        return false;
    }

    // Build and execute the query for the `individual_class` table
    $keys2 = array_keys($filteredData2);
    $query2 = "INSERT INTO individual_class (" . implode(", ", $keys2) . ") VALUES (:" . implode(", :", $keys2) . ")";
    try {
        $this->duiquery($query2, $filteredData2);
        return true;
    } catch (Exception $e) {
        error_log("Error inserting data into `individual_class`: " . $e->getMessage());
        return false;
    }
}


}