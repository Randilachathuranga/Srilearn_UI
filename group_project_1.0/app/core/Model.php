<?php

trait Model {
    use Database;

    protected $limit = '1000';
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
    //helping functions raheem
    public function wherein($data, $colname) {
        // Start building the query
        $query = "SELECT * FROM {$this->table} WHERE {$colname} IN (";
    
        // Add placeholders: ?, ?, ?, ... based on number of items
        $placeholders = implode(',', array_fill(0, count($data), '?'));
        $query .= $placeholders . ")";
    
        // Now call the query function with full query and all values
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
    
    public function InnerJoinwhereMultiplewithlike($tables, $joinConditions, $data = [], $data_not = [], $data_like = []) {
        if (count($tables) < 2 || count($joinConditions) < count($tables) - 1) {
            throw new Exception("Insufficient join conditions for given tables.");
        }
    
        $query = "SELECT * FROM {$tables[0]}";
    
        // Add INNER JOINs
        for ($i = 1; $i < count($tables); $i++) {
            $query .= " INNER JOIN {$tables[$i]} ON {$joinConditions[$i - 1]}";
        }
    
        $conditions = [];
    
        // Equal conditions
        foreach ($data as $key => $value) {
            $paramKey = str_replace('.', '_', $key);
            $conditions[] = "$key = :$paramKey";
        }
    
        // NOT equal conditions
        foreach ($data_not as $key => $value) {
            $paramKey = str_replace('.', '_', $key);
            $conditions[] = "$key != :$paramKey";
        }
    
        // LIKE conditions
        foreach ($data_like as $key => $value) {
            $paramKey = str_replace('.', '_', $key);
            $conditions[] = "$key LIKE :$paramKey";
        }
    
        if (!empty($conditions)) {
            $query .= " WHERE " . implode(" AND ", $conditions);
        }
    
        // Limit + Offset
        $query .= " LIMIT $this->limit OFFSET $this->offset";
    
        // Bind parameters
        $params = [];
        foreach ([$data, $data_not, $data_like] as $group) {
            foreach ($group as $key => $value) {
                $paramKey = str_replace('.', '_', $key);
                $params[$paramKey] = $group === $data_like ? "%$value%" : $value;
            }
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

    public function deletewhere($conditions) {
        // Start building the query with the DELETE statement
        $query = "DELETE FROM $this->table WHERE ";
    
        // Prepare the condition strings and data array
        $data = [];
        $conditionStrings = [];
    
        // Loop through the conditions and build the WHERE clause
        foreach ($conditions as $column => $value) {
            $conditionStrings[] = "$column = :$column"; // Add the condition for each column
            $data[$column] = $value; // Add the corresponding value to the data array
        }
    
        // Join the conditions with "AND" and append to the query
        $query .= implode(' AND ', $conditionStrings);
    
        try {
            $this->duiquery($query, $data); // Execute the query
            return true;
        } catch (Exception $e) {
            if (defined('DEBUG')) {
                echo "Delete failed: " . $e->getMessage();
            }
            return false;
        }
    }
    
}
