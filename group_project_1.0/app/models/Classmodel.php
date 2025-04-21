<?php 
class Classmodel{
    use Model;

protected $table = "class";
protected $allowedcolumns = [
    'Class_id','Type','Subject','Grade','Max_std','fee'
];
}