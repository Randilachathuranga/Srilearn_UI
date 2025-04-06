<?php
class Advertisment{
    
    use Model;

    protected $table='advertisements';
    protected $allowedColumns=[
        'Ad_id','User_id','Title','Content','Post_date','Iseducation','Subject'
    ];

}