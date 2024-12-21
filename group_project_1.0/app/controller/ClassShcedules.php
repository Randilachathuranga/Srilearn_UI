<?php

class ClassShcedules extends Controller
{
    public function index()
    {
        $model = new Timetablemodel();
        if (
            (isset($_SESSION['User_id']) && $_SESSION['Role'] === "teacher") ||
            (isset($_SESSION['User_id']) && $_SESSION['Role'] === "institute") ||
            (isset($_SESSION['User_id']) && $_SESSION['Role'] === "student")
        ) {
            $this->view('TeacherView/Options/ViewClassschedule/ViewClassschedule');
        } 
    }

    //view my class schedules API
    public function AllclassShcedule($Class_id){
        $model = new Timetablemodel();
        $t1 = $model->table;
        $t2 = $model->table2;
        $joinCondition = $model->joinCondition;
        $schedule = $model->AllSchedule($t2, $t1, $joinCondition, ['Class_id' => $Class_id]);
        if (empty($schedule)) {
            http_response_code(404);
            echo json_encode(['error' => 'No classes found for the given Class_id.']);
            return;
        }
        header('Content-Type: application/json');
        echo json_encode($schedule, JSON_PRETTY_PRINT);
    }
    

    //delete my shcedule API
    public function deleteSchedule($Sch_id){
        $model = new Timetablemodel();

        try {
            if ($model->delete($Sch_id, 'Sch_id')) {  // Use $userId here, as it's passed from the route
                echo json_encode(['status' => 'success', 'message' => 'Schedule deleted successfully']);
                redirect('Ind_Myclass');
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to delete Schedule']);
            }
             
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
            
        }
    }

    
    //update my class API
    public function UpdateApi($Sch_id) {
        $model = new Timetablemodel();
        $inputData = json_decode(file_get_contents("php://input"), true); // Parse JSON body
    
        if (isset($inputData['Sch_id'], $inputData['Start_time'], $inputData['End_time'], $inputData['Date'])) {
            $scheduleId = $inputData['Sch_id'];
            $startTime = $inputData['Start_time'];
            $endTime = $inputData['End_time'];
            $date = $inputData['Date'];
    
            $updateData = [
                'Start_time' => $startTime,
                'End_time' => $endTime,
                'Date' => $date
            ];
            if ($model->update($Sch_id, $updateData, 'Sch_id')) {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Schedule updated successfully.',
                    'updated_data' => [
                        'Sch_id' => $scheduleId,
                        'Start_time' => $startTime,
                        'End_time' => $endTime,
                        'Date' => $date
                    ]
                ]);
            } else {
                http_response_code(500);
                echo json_encode(['status' => 'error', 'message' => 'Failed to update schedule.']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'Invalid input data.']);
        }
    }
    
    
    // Create class schedule
    public function createScheduleAPI($Class_id) {
            header('Content-Type: application/json');
            $inputData = json_decode(file_get_contents('php://input'), true);
            $Start_time = isset($inputData['Start_time']) ? $inputData['Start_time'] : null;
            $End_time = isset($inputData['End_time']) ? $inputData['End_time'] : null;
            $Date = isset($inputData['Date']) ? $inputData['Date'] : null;
            if (!$Start_time || !$End_time || !$Date) {
                echo json_encode(['status' => 'error', 'message' => 'Missing required fields']);
                return;
            }
            $data = [
                'Class_id' => $Class_id,
                'Start_time' => $Start_time,
                'End_time' => $End_time,
                'Date' => $Date,
            ];
            $model = new Timetablemodel();
            $result = $model->insert($data);
            if ($result) {
                echo json_encode(['status' => 'success', 'message' => 'Class created successfully']);
            } else {
                error_log('Failed to insert data into the database');
                echo json_encode(['status' => 'error', 'message' => 'Failed to create schedule']);
            }

    }
    
    

}