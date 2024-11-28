<?php

class myteachersviewmodel{

    use Model;

    public $table='myteachersview';
    public $allowedColumns=[
        'InstClass_id','Teacher_ID','FirstName','LastName','Email','Role','Subject'
    ];

}