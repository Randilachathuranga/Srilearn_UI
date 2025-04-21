<?php
trait Database {

    private $connection;

    // Reusable connection setup
    private function connect() {
        if ($this->connection === null) {
            $string = "mysql:hostname=" . DBHOST . ";dbname=" . DBNAME;
            try {
                $this->connection = new PDO($string, DBUSER, DBPASS);
                $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Connection failed: " . $e->getMessage());
            }
        }
        return $this->connection;
    }

    // Execute a query with optional data and return all results
    public function query($query, $data = []) {
        try {
            $con = $this->connect();
            $stm = $con->prepare($query);
            $check = $stm->execute($data);

            if ($check) {
                return $stm->fetchAll(PDO::FETCH_OBJ); // Return results directly
            }
            return false;
        } catch (PDOException $e) {
            if (defined('DEBUG') && DEBUG) {
                echo "Query failed: " . $e->getMessage();
            }
            return 'Error: ' . $e->getMessage(); 
        }
    }

    // Execute a query and return a single row or null if empty
    public function getrow($query, $data = []) {
        try {
            $con = $this->connect();
            $stm = $con->prepare($query);
            $check = $stm->execute($data);

            if ($check) {
                $result = $stm->fetchAll(PDO::FETCH_OBJ);
                return $result[0] ?? null; // Return first row or null if none
            }
            return false;
        } catch (PDOException $e) {
            if (defined('DEBUG') && DEBUG) {
                echo "Query failed: " . $e->getMessage();
            }
            return false;
        }
    }


    // Execute a Data Manipulation query and return affected rows or false if failed
    public function duiquery($query, $data = []) {
        try {
            $con = $this->connect();
            $stm = $con->prepare($query);
            $check = $stm->execute($data);

            if ($check) {
                $affectedRows = $stm->rowCount(); 
                return $affectedRows;             
            }
            return false;
        } catch (PDOException $e) {
            if (defined('DEBUG') && DEBUG) {
                echo "Query failed: " . $e->getMessage();
            }
            return false;
        }
    }

    // Transaction Management
    public function beginTransaction() {
        $this->connect()->beginTransaction();
    }

    public function commit() {
        $this->connect()->commit();
    }

    public function rollback() {
        $this->connect()->rollBack();
    }
}
