<?php

class Normalteachermodel{

    use Model;

    public $table='normal_teacher';
    public $allowedColumns=[
        'N_ID','InstClass_id'
        ];
}