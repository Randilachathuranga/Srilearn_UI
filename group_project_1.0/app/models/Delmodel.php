<?php


class Delmodel{
    
    use Model;

    protected $table='del_user';
    protected $allowedColumns=[
        'User_id','F_name','L_name','Email','District','Role',
        'Phone_number','Address','Password'
    ];
}