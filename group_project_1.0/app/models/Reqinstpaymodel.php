<?php 
class Reqinstpaymodel{
use Model;
protected $table = 'instpayreq';
protected $allowedColumns = [
    'req_id','inst_id','date','time','amount','status'
];

}