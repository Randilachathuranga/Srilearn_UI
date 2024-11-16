<?php

class Ind_Myclass extends TeacherController{

    // function checkAccess($requiredRole) {
    //     if (!isset($_SESSION['Role']) || $_SESSION['Role'] !== $requiredRole) {
    //        echo "123";
    //        redirect('Error404');
    //        exit();
    //     }
    // }

    public function index() {
    
        $model = new Myclassmodel();
        // echo $_SESSION['Role'];
        $this->Teacherview('Myclass'); 
    }

    public function MyclassApi($P_id) {
        $model = new Myclassmodel();

        $isPremium = $model->checkPremium($P_id);
        if (!$isPremium) {
            http_response_code(403); // Forbidden
            echo json_encode(['error' => 'Access denied. Not a premium teacher.']);
            return;
        }

        $t1 = $model->table1;
        $t2 = $model->table2;
        $joinCondition = $model->joinCondition;
        
        $class = $model->InnerJoinwhere($t1,$t2,$joinCondition,['P_id' => $P_id]);

        if (empty($class)) {
            http_response_code(404); // Not Found
            echo json_encode(['error' => 'No classes found for the given P_id.']);
            return;
        }

        header('Content-Type: application/json');
        echo json_encode($class, JSON_PRETTY_PRINT);
    }

}