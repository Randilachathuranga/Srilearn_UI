 
<?php 
class Removedstdmodel{
use Model;
protected $table = 'removedstudents';
protected $allowedColumns = [
    'id','past_std','Stu_id','Class_id','Rem_date','Reason'
];

}
