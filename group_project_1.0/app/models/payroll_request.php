<?php

class payroll_request{
    use Model;

    public $table = 'payroll_request';
    public $allowedColumns = [
        'Institute_ID ', 'N_id', 'InstClass_id', 'currentdate', 'bankdetails','stateis'
    ];


   
    
}