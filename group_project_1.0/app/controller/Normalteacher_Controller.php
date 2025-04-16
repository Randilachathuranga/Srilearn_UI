<?php

class Normalteacher_Controller extends Controller
{
    public function index() {
        $model = new Normalteacher();
        checkAccess('teacher');
        $this->View('InstituteView/viewspecificteacher_class/Specificteacherclass'); 
    }

    public function findmyinstitutes($N_id){
        $model = new Normalteacher();

        $t1 = $model->table;
        $t2 = $model->table2;
        $joinCondition = $model->joinCondition;
        
        $class = $model->InnerJoinwhere($t1,$t2,$joinCondition,['N_id' => $N_id]);

        if (empty($class)) {
            http_response_code(404); // Not Found
            echo json_encode(['error' => 'No classes found for the given P_id.']);
            return;
        }

        header('Content-Type: application/json');
        echo json_encode($class, JSON_PRETTY_PRINT);
    }

    public function leaveinstitute($N_id, $Institute_ID) {
        $model = new Normalteacher();
    
        $leave = $model->deleteteacher($N_id,'N_id',$Institute_ID,'Institute_ID');
    
        header('Content-Type: application/json');
    
        if ($leave) {
            echo json_encode(['success' => true, 'message' => 'Successfully left the institute.']);
        } else {
            http_response_code(404); // Not Found
            echo json_encode(['success' => false, 'error' => 'Failed to leave the institute. Record may not exist.']);
        }
    }
    
}  
