<?php 
class Teachermodel{
    use Model;
    protected $table = "teacher";
    protected $allowedColumn=['Teach_id','Ratings','Subject','Ispremium'];
}