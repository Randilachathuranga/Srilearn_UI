<?php
class Paymentmodel{
    
    use Model;

    protected $table='all_payments';
    protected $allowedColumns=[
        'P_id','User_id','Amount','Date','Type','classID','Sub_id'
    ];
}