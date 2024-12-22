<?php
class Enrollmodel{
    
    use Model;

    protected $table='enrollment';
    protected $allowedColumns=[
        'Enrollment_id','Stu_id','Date','Class_id','Isdiscountavail'
    ];

    public function checkisEnrolled($Stu_id, $Class_id)
    {
        $query = "SELECT Stu_id FROM {$this->table} WHERE Stu_id = :Stu_id AND Class_id = :Class_id LIMIT 1";
        $params = ['Stu_id' => $Stu_id, 'Class_id' => $Class_id];
        $result = $this->query($query, $params);
        return !empty($result); // Return true if the student is already enrolled
    }
}