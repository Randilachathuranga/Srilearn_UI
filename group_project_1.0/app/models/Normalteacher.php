<?php

class Normalteacher{

    use Model;

    public $table = 'normal_teacher';
    public $allowColumns = [
        'N_id','Institute_ID'
    ];
    public $table2 = 'user';
    public $joinCondition = "user.User_id = normal_teacher.Institute_ID";


    public function deleteteacher($id1, $N_id = 'N_id', $id2 ,$Institute_ID = 'Institute_ID') {
        $query = "DELETE FROM $this->table WHERE $N_id = :$N_id AND $Institute_ID = :$Institute_ID";
        $data = [$N_id => $id1, $Institute_ID => $id2];

        try {
            $this->duiquery($query, $data);
            return true;
        } catch (Exception $e) {
            if (defined('DEBUG')) {
                echo "Delete failed: " . $e->getMessage();
            }
            return false;
        }
    }
}