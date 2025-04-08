<?php

class Normalteacher{

    use Model;

    public $table = 'normal_teacher';
    public $allowColumns = [
        'N_id','Institute_ID'
    ];
    public $table2 = 'user';
    public $joinCondition = "user.User_id = normal_teacher.Institute_ID";
}