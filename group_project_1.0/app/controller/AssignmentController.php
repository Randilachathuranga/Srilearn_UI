<?php
Class AssignmentController extends Controller{

    public function index(){
        $this->view('TeacherView/Options/UploadASS/UploadASS');   
    }

    // create Assingments
    public function createASS($Class_id) {
        ob_clean();
        header('Content-Type: application/json');

        try {
            $model = new Assignment();

            $requestData = json_decode(file_get_contents('php://input'), true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new Exception("Invalid JSON input: " . json_last_error_msg());
            }

            if (!isset($requestData['Marks']) || !is_array($requestData['Marks'])) {
                throw new Exception("Invalid data format: Marks array is required");
            }

            // Step 1: Insert into Assignment Table
            $model->insertASS($Class_id);    
            $Ass_id = $model->last_InsertId();

            // Step 2: Insert Assignment Marks
            $marksInserted = $model->insertAssignmentMarks($Ass_id, $requestData['Marks']);

            $response = [
                'success' => true,
                'message' => 'Assignment created successfully',
                'data' => [
                    'Ass_id' => $Ass_id,
                    'Class_id' => $Class_id,
                    'students_processed' => $marksInserted
                ]
            ];

            echo json_encode($response);

        } catch (Exception $e) {
            $errorResponse = [
                'success' => false,
                'error' => $e->getMessage()
            ];

            echo json_encode($errorResponse);
        }
        exit();
    }
       

    //view marks for all students
    public function AllAssignments($Class_id) {
        $model = new Assignment();
        $ASS = $model->allAssignments($Class_id);
    
        // Debugging: Check the SQL query output
        if ($ASS === false) {
            http_response_code(500);
            echo json_encode(['error' => 'Database query failed']);
            return;
        }
    
        if (empty($ASS)) {
            http_response_code(404);
            echo json_encode(['error' => 'No assignments found for the given Class_id.']);
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