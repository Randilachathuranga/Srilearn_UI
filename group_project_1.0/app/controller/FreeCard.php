<?php

class FreeCard extends Controller{


    public function index(){
        $model = new Enrollmodel();
        if (
            (isset($_SESSION['User_id']) && $_SESSION['Role'] === "teacher") ||
            (isset($_SESSION['User_id']) && $_SESSION['Role'] === "institute") ||
            (isset($_SESSION['User_id']) && $_SESSION['Role'] === "student")
        ) {
        $this->view('TeacherView/Options/IssueFreecard/Freecard');
        }
    }

    //view api
    public function viewAPI($Class_id){
        $model = new Enrollmodel();

        $quaryforview = $model->InnerJoinwhere('user','enrollment','user.User_id = enrollment.Stu_id',['Class_id' => $Class_id]);

        if (empty($quaryforview)) {
            http_response_code(404);
            echo json_encode(['error' => 'No classes found for the given Class_id.']);
            return;
        }
        header('Content-Type: application/json');
        echo json_encode($quaryforview, JSON_PRETTY_PRINT);

    }

    // delete api
    public function Deletefreecard($Stu_id) {
        $model = new Enrollmodel();  
        $inputData = json_decode(file_get_contents("php://input"), true);
    
        if (!empty($inputData['classId'])) {
            $Class_id = $inputData['classId'];
            $value = 0;
            $updateData = ['Isdiscountavail' => $value];
        
            if ($model->ChangeIsdiscountavail($Stu_id, $Class_id, $updateData, 'Stu_id', 'Class_id')) {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Free card created successfully.',
                    'updated_data' => [
                        'Stu_id' => $Stu_id,
                        'Class_id' => $Class_id,
                        'Isdiscountavail' => $value,
                    ]
                ]);
            } else {
                http_response_code(500);
                echo json_encode(['status' => 'error', 'message' => 'Failed to create free card.']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'classId is required.']);
        }
    }
    
    public function Createfreecard($Stu_id) {
        $model = new Enrollmodel();  
        $inputData = json_decode(file_get_contents("php://input"), true);
    
        if (!empty($inputData['classId'])) {
            $Class_id = $inputData['classId'];
            $value = 1;
            $updateData = ['Isdiscountavail' => $value];
        
            if ($model->ChangeIsdiscountavail($Stu_id, $Class_id, $updateData, 'Stu_id', 'Class_id')) {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Free card created successfully.',
                    'updated_data' => [
                        'Stu_id' => $Stu_id,
                        'Class_id' => $Class_id,
                        'Isdiscountavail' => $value,
                    ]
                ]);
            } else {
                http_response_code(500);
                echo json_encode(['status' => 'error', 'message' => 'Failed to create free card.']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'classId is required.']);
        }
    }
    
   
    

}