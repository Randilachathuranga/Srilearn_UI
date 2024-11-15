<?php
Trait Database {

private function connect() {
    $string = "mysql:hostname=" . DBHOST . ";dbname=" . DBNAME;
    try{
    $con = new PDO($string, DBUSER, DBPASS);
    $con->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    return $con;
    }
    catch(PDOException $e){
        die("Connection failed: ".$e->getMessage()) ;
    }
}
public function query($query, $data = []) {
    $con = $this->connect();
    $stm = $con->prepare($query);
    $check = $stm->execute($data);

    if ($check) {
        return $stm->fetchAll(PDO::FETCH_OBJ); // Return results directly
    }
    return false; // Return false if the execution failed
}
public function getrow($query, $data = []) {
    $con = $this->connect();
    $stm = $con->prepare($query);
    $check = $stm->execute($data);

    if ($check) {
        $result= $stm->fetchAll(PDO::FETCH_OBJ); // Return results directly
        return $result[0];
    }
    return false; // Return false if the execution failed
}

public function duiquery($query, $data = []) {
    $con = $this->connect();                // Establish a database connection
    $stm = $con->prepare($query);           // Prepare the query
    $check = $stm->execute($data);         // Execute the query with the provided data

    if ($check) {
        $affectedRows = $stm->rowCount();  // Get the number of affected rows
        return $affectedRows;              // Return the affected rows count
    } else {
        return false;                      // Return false if the query fails
    }
}


}