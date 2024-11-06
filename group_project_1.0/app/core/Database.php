<?php
Trait Database {

private function connect() {
    $string = "mysql:hostname=" . DBHOST . ";dbname=" . DBNAME;
    $con = new PDO($string, DBUSER, DBPASS);
    return $con;
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

}
