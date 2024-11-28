<?php
class Enrollmodel{
    
    use Model;

    protected $table='enrollment';
    protected $allowedColumns=[
        'Enrollment_id','Stu_id','Date','Class_id','Isdiscountavail'
    ];
}