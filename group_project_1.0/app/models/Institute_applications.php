<?php

class Institute_applications{
    use Model;

    public $table = 'institute_applications';
    public $allowedColumns = ['Jr_id','Teacher_id','Date','Full_name','Email',
                                'Subject','Phone_number','Qualifications','stateis'];

     // get jr id 
    public function getJr_id($data) {
        $model = new Jobroll();
        $keys = array_keys($data);
        $query = "SELECT Jr_id FROM jobroll WHERE ";
        foreach ($keys as $key) {
            $query .= $key . "=:" . $key . " AND ";
        }
        $query = rtrim($query, " AND ");
        $query .= " LIMIT 10 OFFSET 0";
        
        // No need for array_merge with a single array
        $result = $model->query($query, $data);
        
        if ($result && isset($result[0]->Jr_id)) {
            return $result[0]->Jr_id; // Return Jr_id, not Class_id
        }
        return false;
    }

}