<?php

class Subscriptionmodel{
    use Model;

    protected $table = 'subscription';
    protected $allowedColumns = [
        'subid','P_id','Type','Start_data','End_data'
    ];

}