<?php

trait Model {
    use Database;

    protected $limit = '10';
    protected $offset = '0';
    protected $order_type = "desc";
    protected $order_column = "id";
    public $errors = [];

    // Filter records with matching or non-matching conditions
    public function where($data, $data_not = []) {
        $keys = array_keys($data);
        $keys_not = array_keys($data_not);
        $query = "SELECT * FROM $this->table WHERE ";

        foreach ($keys as $key) {
            $query .= "$key = :$key AND ";
        }
        foreach ($keys_not as $key) {
            $query .= "$key != :$key AND ";
        }
        $query = rtrim($query, " AND ");
        $query .= " LIMIT $this->limit OFFSET $this->offset";
        
        $data = array_merge($data, $data_not);
        return $this->query($query, $data);
    }

    public function InnerJoinwhere($table1, $table2, $joinCondition, $data, $data_not = []){
        $keys = array_keys($data);
        $keys_not = array_keys($data_not);
        $query = "select * from $table1 INNER JOIN $table2 ON $joinCondition where ";
       foreach($keys as $key){
                $query.=$key."=:".$key." && ";
        }
        foreach($keys_not as $key){
            $query.=$key."!=:".$key." && ";
        }
        $query = trim($query, " && ");
        $query .= " limit $this->limit offset $this->offset";
        $data = array_merge($data, $data_not);
        return $this->query($query, $data);
    }

    public function InnerJoinwhereMultiple($tables, $joinConditions, $data = [], $data_not = []) {
        if (count($tables) < 2 || count($joinConditions) < count($tables) - 1) {
            throw new Exception("Insufficient join conditions for given tables.");
        }
    
        $query = "SELECT * FROM {$tables[0]}";
    
        // Add INNER JOINs
        for ($i = 1; $i < count($tables); $i++) {
            $query .= " INNER JOIN {$tables[$i]} ON {$joinConditions[$i - 1]}";
        }
    
        $conditions = [];
    
        // Add equal conditions
        foreach ($data as $key => $value) {
            $paramKey = str_replace('.', '_', $key); // Convert table.column to table_column
            $conditions[] = "$key = :$paramKey";
        }
    
        // Add NOT equal conditions
        foreach ($data_not as $key => $value) {
            $paramKey = str_replace('.', '_', $key);
            $conditions[] = "$key != :$paramKey";
        }
    
        if (!empty($conditions)) {
            $query .= " WHERE " . implode(" AND ", $conditions);
        }
    
        // Limit + Offset
        $query .= " LIMIT $this->limit OFFSET $this->offset";
    
        // Merge params with keys adjusted
        $params = [];
        foreach ($data as $key => $value) {
            $paramKey = str_replace('.', '_', $key);
            $params[$paramKey] = $value;
        }
        foreach ($data_not as $key => $value) {
            $paramKey = str_replace('.', '_', $key);
            $params[$paramKey] = $value;
        }
    
        return $this->query($query, $params);
    }
    
    
    
    // Find all records from the table
    public function findall() {
        $query = "SELECT * FROM $this->table";
        return $this->query($query);
    }

    // Find the first matching record based on conditions
    public function first($data, $data_not = []) {
        $keys = array_keys($data);
        $keys_not = array_keys($data_not);
        $query = "SELECT * FROM $this->table WHERE ";

        foreach ($keys as $key) {
         
         
            $query .= "$key = :$key AND ";
        }
        foreach ($keys_not as $key) {
            $query .= "$key != :$key AND ";
        }
        $query = rtrim($query, " AND ");
        $query .= " LIMIT 1";
        
        $data = array_merge($data, $data_not);
        $result = $this->query($query, $data);
        return $result ? $result[0] : false;
    }

    // Insert a new record
    public function insert($data) {
        // Filter out unallowed columns
        if (!empty($this->allowedColumns)) {
            foreach ($data as $key => $value) {
                if (!in_array($key, $this->allowedColumns)) {
                    unset($data[$key]);
                }
            }
        }

        $keys = array_keys($data);
        $query = "INSERT INTO $this->table (" . implode(",", $keys) . ") VALUES (:" . implode(",:", $keys) . ")";
        return $this->duiquery($query, $data) ? true : false;
    }

    // Update a record by ID with optional custom ID column
    public function update($id, $data, $id_column = 'User_id') {
        // Filter out unallowed columns
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
        $query .= " WHERE $id_column = :$id_column";
        
        $data[$id_column] = $id;
        
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
    
    // Delete a record by ID with optional custom ID column
    public function delete($id, $id_column = 'User_id') {
        $query = "DELETE FROM $this->table WHERE $id_column = :$id_column";
        $data = [$id_column => $id];
        
        try {
            $this->duiquery($query, $data);
            return true;
        } catch (Exception $e) {
            if (defined('DEBUG')) {
                echo "Delete failed: " . $e->getMessage();
            }
            return false;
        }
    }
}
