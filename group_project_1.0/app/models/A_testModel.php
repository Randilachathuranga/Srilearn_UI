<?php

class A_testModel{
    use Model;
    public $table = 'a_test';
    public $allowedColumns = ['U_id','Name','Age','DOB'];

}