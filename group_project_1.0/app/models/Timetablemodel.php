<?php

class Timetablemodel{

    use Model;

    public $table = 'timetable';
    public $allowedColumns = [
        'Class_id','Start_time','End_time','Date'
    ];

    public $table2='class';
    public $allowedColumns2=[
        'Class_id','Type','Subject','Grade','Max_std','fee'
    ];

    public $joinCondition = "class.Class_id = timetable.Class_id";

    //deleted class shcedule by delete function in core models
    //updated class schedule by update function in core models
    //created class schedule BY insert function in core models

    //viewed class shcedules   
    public function AllSchedule($table1, $table2, $joinCondition, $data, $data_not = []) {
        $keys = array_keys($data);
        $keys_not = array_keys($data_not);
        $query = "SELECT * FROM $table1 INNER JOIN $table2 ON $joinCondition WHERE ";
        foreach ($keys as $key) {
            $query .= "$table1.$key = ? AND ";
        }
        foreach ($keys_not as $key) {
            $query .= "$table1.$key != ? AND ";
        }
        $query = rtrim($query, " AND ");
        $params = array_merge(array_values($data), array_values($data_not));
        $result = $this->query($query, $params);
        return $result;
    }
    
    





}