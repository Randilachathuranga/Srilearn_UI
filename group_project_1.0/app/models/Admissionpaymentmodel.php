<?php
class Admissionpaymentmodel{
    
    use Model;

    protected $table='admission';
    protected $allowedColumns=[
        'P_id','Class_id'
    ];
}