<?php

class Normalteacher{

    use Model;

    public $table = 'normal_teacher';
    public $allowColumns = [
        'id','N_id','Institute_ID'
    ];
    
}