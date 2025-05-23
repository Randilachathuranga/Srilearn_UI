<?php

class Ind_Myclass extends Controller{

    public function index() {
    
        $model = new Myclassmodel();
        checkAccess('teacher');
        $this->View('TeacherView/Myclass/Myclass'); 
                

    }

    public function MyclassApi($P_id) {
        $model = new Myclassmodel();

        $t1 = $model->table1;
        $t2 = $model->table2;
        $joinCondition = $model->joinCondition;
        
        $class = $model->InnerJoinwhere($t1,$t2,$joinCondition,['P_id' => $P_id]);

        if (empty($class)) {
            http_response_code(404);
            echo json_encode(['error' => 'No classes found for the given P_id.']);
            return;
        }

        header('Content-Type: application/json');
        echo json_encode($class, JSON_PRETTY_PRINT);
    }

    public function MyinstituteClass($N_id) {
        $model = new Myclassmodel();

        $t1 = $model->table1;
        $t2 = $model->table3;
        $joinCondition = $model->joinCondition3;
        
        $class = $model->InnerJoinwhere($t1,$t2,$joinCondition,['N_id' => $N_id]);

        if (empty($class)) {
            http_response_code(404); 
            echo json_encode(['error' => 'No classes found for the given P_id.']);
            return;
        }

        header('Content-Type: application/json');
        echo json_encode($class, JSON_PRETTY_PRINT);
    }

    public function MoredetailsApi($Class_id) {
        $model = new Myclassmodel();
        $t1 = $model->table1;
        $t2 = $model->table2;
        $joinCondition = $model->joinCondition;
        $class = $model->InnerJoinwhere($t1,$t2,$joinCondition,['class_id' => $Class_id]);
        if (empty($class)) {
            http_response_code(404); 
            echo json_encode(['error' => 'No classes found for the given P_id.']);
            return;
        }
        header('Content-Type: application/json');
        echo json_encode($class, JSON_PRETTY_PRINT);
    }

    public function Moredetailsinstitute($Class_id) {
        $model = new Myclassmodel();
        $t1 = $model->table1;
        $t2 = $model->table3;
        $joinCondition = $model->joinCondition3;
        $class = $model->InnerJoinwhere($t1,$t2,$joinCondition,['InstClass_id' => $Class_id]);
        if (empty($class)) {
            http_response_code(404); 
            echo json_encode(['error' => 'No classes found for the given P_id.']);
            return;
        }
        header('Content-Type: application/json');
        echo json_encode($class, JSON_PRETTY_PRINT);
    }

    public function DeleteclassApi($Class_id) {
        $model = new Myclassmodel();

        try {
            if ($model->deleteclass($Class_id)) {  
                echo json_encode(['status' => 'success', 'message' => 'User deleted successfully']);
                redirect('Ind_Myclass');
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to delete user']);
            }
             
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
            
        }
     }

     public function UpdateclassApi($Class_id) {
        $jsonData = file_get_contents('php://input');
        $data = json_decode($jsonData, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid JSON input']);
            return;
        }
        if (!isset($data['table1']) || !isset($data['table2'])) {
            echo json_encode(['status' => 'error', 'message' => 'Missing table1 or table2 data']);
            return;
        }
        $table1_data = [
            'Subject' => $data['table1']['Subject'] ?? null,
            'Grade' => $data['table1']['Grade'] ?? null,
            'Max_std' => $data['table1']['Max_std'] ?? null,
            'fee' => $data['table1']['fee'] ?? null,
            'Def_Date' => $data['table1']['Date'] ?? null,
            'Def_Time' => $data['table1']['Time'] ?? null,
        ];
        $table2_data = [
            'Location' => $data['table2']['Location'] ?? null,
            'Start_date' => $data['table2']['Start_date'] ?? null,
            'End_date' => $data['table2']['End_date'] ?? null,
        ];
        $table3_data = [
            'Location' => $data['table2']['Location'] ?? null,
            'Start_date' => $data['table2']['Start_date'] ?? null,
            'End_date' => $data['table2']['End_date'] ?? null,
            'Hall_number' => $data['table2']['Hall_number'] ?? null,
        ];
        if (empty(array_filter($table1_data)) || empty(array_filter($table2_data))) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid or incomplete data for table1 or table2']);
            return;
        }
        error_log("Prepared table1 data: " . print_r($table1_data, true));
        error_log("Prepared table2 data: " . print_r($table2_data, true));
        $model = new Myclassmodel();

        $result1 = $model->updateclass($Class_id, $table1_data, 'Class_id', $model->table1);
        $result2 = $model->updateclass($Class_id, $table2_data, 'IndClass_id', $model->table2);
        $result3 = $model->updateclass($Class_id, $table3_data, 'InstClass_id', $model->table3);
            
            if ($result1 || $result2 || $result3) {
                echo json_encode(['status' => 'success', 'message' => 'Class updated successfully']);
            } else {
                $errorMessages = [];
                if (!$result1) $errorMessages[] = 'Failed to update table1';
                if (!$result2) $errorMessages[] = 'Failed to update table2';
                echo json_encode(['status' => 'error', 'message' => implode('. ', $errorMessages)]);
            }
        } 
        
        public function CreateclassApi($P_id) {
            $jsonData = file_get_contents('php://input');
            $data = json_decode($jsonData, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                echo json_encode(['status' => 'error', 'message' => 'Invalid JSON input']);
                return;
            }
            if (!isset($data['table1']) || !isset($data['table2'])) {
                echo json_encode(['status' => 'error', 'message' => 'Missing table1 or table2 data']);
                return;
            }
            $table1_data = [
                'Type' => $data['table1']['Type'] ?? null,
                'Subject' => $data['table1']['Subject'] ?? null,
                'Grade' => $data['table1']['Grade'] ?? null,
                'Max_std' => $data['table1']['Max_std'] ?? null,
                'fee' => $data['table1']['fee'] ?? null,
                'Def_Date' => $data['table1']['Def_Date'] ?? null,
                'Def_Time' => $data['table1']['Def_Time'] ?? null,
                'Stream' => $data['table1']['Stream'] ?? null,
            ];
            $table2_data = [
                'P_id' => $P_id,
                'Location' => $data['table2']['Location'] ?? null,
                'Start_date' => $data['table2']['Start_date'] ?? null,
                'End_date' => $data['table2']['End_date'] ?? null,
            ];
            if (empty(array_filter($table1_data)) || empty(array_filter($table2_data))) {
                echo json_encode(['status' => 'error', 'message' => 'Invalid or incomplete data for table1 or table2']);
                return;
            }
            error_log("Prepared table1 data: " . print_r($table1_data, true));
            error_log("Prepared table2 data: " . print_r($table2_data, true));
            $model = new Myclassmodel();
    
            $result = $model->insertclass($table1_data,$table2_data);
                if ($result) {
                    echo json_encode(['status' => 'Success', 'message' => 'Class created successfully']);
                } else {
                    $errorMessages = [];
                    if (!$result) $errorMessages[] = 'Failed to create table1';
                }
        }


public function CreateinstituteclassApi($N_id) {
    $jsonData = file_get_contents('php://input');
    $data = json_decode($jsonData, true);
    
    if (json_last_error() !== JSON_ERROR_NONE) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid JSON input']);
        return;
    }
    
    if (!isset($data['table1']) || !isset($data['table3'])) {
        echo json_encode(['status' => 'error', 'message' => 'Missing table1 or table3 data']);
        return;
    }
    
    $table1_data = [
        'Type' => $data['table1']['Type'] ?? null,
        'Subject' => $data['table1']['Subject'] ?? null,
        'Grade' => $data['table1']['Grade'] ?? null,
        'Max_std' => $data['table1']['Max_std'] ?? null,
        'fee' => $data['table1']['fee'] ?? null,
        'Def_Date' => $data['table1']['Def_Date'] ?? null,
        'Def_Time' => $data['table1']['Def_Time'] ?? null,
        'Stream' => $data['table1']['Stream'] ?? null,

    ];
    
    $table2_data = [
        'N_id' => $N_id,
        'Location' => $data['table3']['Location'] ?? null,
        'Start_date' => $data['table3']['Start_date'] ?? null,
        'End_date' => $data['table3']['End_date'] ?? null,
        'Hall_number' => $data['table3']['Hall_number'] ?? null,
        'inst_id' => $data['table3']['inst_id'] ?? null,
    ];
    
    if (empty(array_filter($table1_data)) || empty(array_filter($table2_data))) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid or incomplete data for table1 or table3']);
        return;
    }
    
    error_log("Prepared table1 data: " . print_r($table1_data, true));
    error_log("Prepared table2 data: " . print_r($table2_data, true));
    
    $model = new Myclassmodel();
    $result = $model->insertinstituteclass($table1_data,$table2_data);
    
    if ($result) {
        echo json_encode(['status' => 'Success', 'message' => 'Class created successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to create class']);
    }
}


    }