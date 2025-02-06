<?php
Class AssignmentController extends Controller{

    public function index(){
        $this->view('TeacherView/Options/UploadASS/UploadASS');   
    }

    // create Assingments
    public function createASS() {
        $model = new Assignment();
        header('Content-Type: application/json');
        $inputData = json_decode(file_get_contents('php://input'), true);
        if (isset($inputData['Class_id'], $inputData['Stu_id'], $inputData['Name'], $inputData['Marks'])) {
            try {
                $model->createTrigger();
                $Ass_id = $model->insertASS($inputData['Class_id']);
                if (!$Ass_id) {
                    throw new Exception("Failed to create assignment");
                }
                $result = $model->insertAssignmentMarks(
                    $Ass_id,
                    $inputData['Stu_id'],
                    $inputData['Name'],
                    $inputData['Marks']
                );
                
                if ($result) {
                    echo json_encode([
                        'success' => true,
                        'message' => 'Assignment created successfully',
                        'data' => [
                            'Ass_id' => $Ass_id,
                            'Class_id' => $inputData['Class_id'],
                            'marks_data' => [
                                'Stu_id' => $inputData['Stu_id'],
                                'Name' => $inputData['Name'],
                                'Marks' => $inputData['Marks']
                            ]
                        ]
                    ]);
                } else {
                    echo json_encode([
                        'success' => false,
                        'message' => 'Could not insert the Assignment marks'
                    ]);
                }
            } catch (Exception $e) {
                echo json_encode([
                    'success' => false,
                    'error' => 'An error occurred while creating the Assignment.',
                    'details' => $e->getMessage()
                ]);
            }
        } else {
            echo json_encode([
                'success' => false,
                'error' => 'Missing required fields: Class_id, Stu_id, Name, or Marks'
            ]);
        }
    }  

    //view marks for all students
    public function AllAssingments(){
        $model = new Assignment();

        $ASS = $model->allassingsments();

        if (empty($ASS)) {
            http_response_code(404); // Not Found
            echo json_encode(['error' => 'No Assigment found for the given Ass_id.']);
            return;
        }

        header('Content-Type: application/json');
        echo json_encode($ASS, JSON_PRETTY_PRINT);
    }

    //view marks for all students
    public function ViewAllStudentsMarks($Ass_id){
        $model = new Assignment();

        $ASS = $model->where(['Ass_id' => $Ass_id]);

        if (empty($ASS)) {
            http_response_code(404); // Not Found
            echo json_encode(['error' => 'No Assigment found for the given Ass_id.']);
            return;
        }

        header('Content-Type: application/json');
        echo json_encode($ASS, JSON_PRETTY_PRINT);
    }

    
    public function MyMarks($Stu_id) {
        try {
            if (!is_numeric($Stu_id)) {
                http_response_code(400);
                echo json_encode(['error' => 'Invalid Student ID']);
                return;
            }
            $inputData = json_decode(file_get_contents("php://input"), true);
            if (!$inputData || !isset($inputData['assId'])) {
                http_response_code(400);
                echo json_encode(['error' => 'Assignment ID is required']);
                return;
            }
            $Ass_id = $inputData['assId'];
            $model = new Assignment();
            $marks = $model->where(['Stu_id' => $Stu_id,'Ass_id'=> $Ass_id]
            );
            header('Content-Type: application/json');
            header('Access-Control-Allow-Origin: *');
            header('Access-Control-Allow-Methods: POST, OPTIONS');
            header('Access-Control-Allow-Headers: Content-Type');
    
            if (empty($marks)) {
                http_response_code(404);
                echo json_encode([
                    'error' => 'No marks found for this student and assignment'
                ]);
                return;
            }
            echo json_encode($marks);
    
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'error' => 'Server error: ' . $e->getMessage()
            ]);
        }
    }

    // delete assignment
    public function DeleteAssingment($Ass_id) {
        $model = new Assignment();
        try {
            if ($model->Del_ass($Ass_id)) {  // Use $userId here, as it's passed from the route
                echo json_encode(['status' => 'success', 'message' => 'User deleted successfully']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to delete user']);
            }
             
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
            
        }
     }


     // update students marks
     public function UpdateSTDmarks($Stu_id) {
        $model = new Assignment();
        $inputData = json_decode(file_get_contents("php://input"), true);
    
        if (!isset($inputData['Ass_id'], $inputData['Marks'])) {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'Missing required data: Ass_id and Marks are needed.']);
            return;
        }
        $Ass_id = $inputData['Ass_id'];
        $Marks = $inputData['Marks'];
        $conditions = [
            'Stu_id' => $Stu_id,
            'Ass_id' => $Ass_id
        ];
        $updateData = ['Marks' => $Marks];
    
        $updated = $model->UpdateSTUM($conditions, $updateData);
    
        if ($updated) {
            echo json_encode([
                'status' => 'success',
                'message' => 'Marks updated successfully.',
                'updated_data' => [
                    'Marks' => $Marks
                ]
            ]);
        } else {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => 'Failed to update marks.']);
        }
    }
    
    

}