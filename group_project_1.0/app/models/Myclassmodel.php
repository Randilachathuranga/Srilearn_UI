<?php

class Myclassmodel{

    use Model;


    public $table1='class';

    public $table2='individual_class';

    public $table3 = 'instituteteacher_class';
    public $joinCondition3 = "class.class_id = instituteteacher_class.InstClass_id";

    public $table4 = 'normal_teacher';

    public $ColumnsforT1=[
        'Type','Subject','Grade','Max_std','fee','Def_Date','Def_Time','Stream'
    ];

    protected $ColumnsforT2 = [
        'IndClass_id', 'P_id', 'Location', 'Start_date', 'End_date'
    ];

    protected $ColumnsforT3 = [
        'InstClass_id', 'N_id', 'Location', 'Start_date', 'End_date','Hall_number','inst_id'
    ];

    public $joinCondition = "class.class_id = individual_class.IndClass_id";

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

    public function updateclass($id, $data, $id_column = 'Class_id', $table = '') {
        $allowedTables = ['class', 'individual_class', 'instituteteacher_class', 'normal_teacher']; 
    
        if (!in_array($table, $allowedTables)) {
            error_log("Invalid table name: $table");
            return false;
        }
    
        $filteredData = array_filter($data, function ($value) {
            return $value !== null && $value !== ''; 
        });
    
        if (empty($filteredData)) {
            error_log("No valid data to update for table: $table");
            return false;
        }
    
        $keys = array_keys($filteredData);
        $query = "UPDATE $table SET ";
        foreach ($keys as $key) {
            $query .= "$key = :$key, ";
        }
        $query = rtrim($query, ', ');
        $query .= " WHERE $id_column = :$id_column";
    
        $filteredData[$id_column] = $id;
    
        try {
            $affectedRows = $this->duiquery($query, $filteredData);
            error_log("Rows affected for table $table: $affectedRows");
            return $affectedRows > 0;
        } catch (Exception $e) {
            error_log("Error executing update query for table $table: " . $e->getMessage());
            return false;
        }
    }
    

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
    

public function insertclass($data1, $data2) {
    $filteredData1 = [];

    if (!empty($this->ColumnsforT1)) {
        foreach ($data1 as $key => $value) {
            if (in_array($key, $this->ColumnsforT1)) {
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
    } catch (Exception $e) {
        error_log("Error inserting data into `class`: " . $e->getMessage());
        return false;
    }


    $data_not1 = [];
    $class_id = $this->getLastInsertId($filteredData1,$data_not1);  
    $class_ID = (int)$class_id;
    if (!$class_ID) {
        error_log("Error retrieving `class_id` after insert");
        return false;
    }

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

    if (empty($filteredData2)) {
        error_log("No valid data to insert for table: individual_class");
        return false;
    }

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


public function insertinstituteclass($data1, $data2) {
    $filteredData1 = [];
    if (!empty($this->ColumnsforT1)) {
        foreach ($data1 as $key => $value) {
            if (in_array($key, $this->ColumnsforT1)) {
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
    } catch (Exception $e) {
        error_log("Error inserting data into `class`: " . $e->getMessage());
        return false;
    }

    $class_ID = (int) $this->getLastInsertId($filteredData1, []);
    if (!$class_ID) {
        error_log("Error retrieving `class_id` after insert");
        return false;
    }

    $filteredData2 = [
        'InstClass_id' => $class_ID
    ];

    if (!empty($this->ColumnsforT3)) {
        foreach ($data2 as $key => $value) {
            if (in_array($key, $this->ColumnsforT3)) {
                $filteredData2[$key] = $value;
            }
        }
    }

    if (empty($filteredData2)) {
        error_log("No valid data to insert for table: individual_class");
        return false;
    }

    $instituteClassData = ['InstClass_id' => $class_ID];

    try {
        $this->duiquery("INSERT INTO institute_class (InstClass_id) VALUES (:InstClass_id)", $instituteClassData);
        $query4 = "INSERT INTO instituteteacher_class (" . implode(", ", array_keys($filteredData2)) . ") VALUES (:" . implode(", :", array_keys($filteredData2)) . ")";
        $this->duiquery($query4, $filteredData2);
        return true;
    } catch (Exception $e) {
        error_log("Error inserting into related tables: " . $e->getMessage());
        return false;
    }
}


}