<?php

class Myclassmodel{

    use Model;

    public $premiumtable = 'premium_teacher';
    public $allowedColumnspre=[
        'P_id','Payment_details','Issubbed'
    ];

    public $table1='class';
    public $allowedColumns1=[
        'Class_id','Type','Subject','Grade','Max_std','fee'
    ];

    public $table2='individual_class';
    public $allowedColumns2=[
        'IndClass_id ','P_id','Location','Start_Time','End_time'
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
    

}