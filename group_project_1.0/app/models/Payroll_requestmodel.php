<?php
class Payroll_requestmodel{
    
    use Model;

    protected $table='payroll_request';
    protected $allowedColumns=[
        'Id','Institute_ID','N_id','InstClass_id','currentdate','bankdetails','Amount','stateis','issue_date'
    ];
}

