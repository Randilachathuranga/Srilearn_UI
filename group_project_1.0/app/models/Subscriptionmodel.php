<?php

class Subscriptionmodel{
    use Model;

    protected $table = 'subscription';
    protected $allowedColumns = [
        'ID','P_id','Type','Start_data','End_data'
    ];

}