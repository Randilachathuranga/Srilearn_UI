<?php

class Jobrollcontroller extends Controller{
    //navigation path
    public function index(){
       $this->view('InstituteView/Jobroll/Jobroll');
    }

    //view all subjects for specific institute
    public function viewallsubjects($Inst_id){
        header('Content-Type: application/json'); // Set header for JSON response
        $model = new Jobroll();

        $q1 = $model->where(['Inst_id' => $Inst_id]);

        if($q1){
            echo json_encode($q1);
        }else{
            echo json_encode(['message' => 'no subjects found']);
        }
    }

    //view specific id
    public function viewjobrollid($Inst_id,$Subject){
        header('Content-Type: application/json'); // Set header for JSON response
        $model = new Jobroll();

        $q1 = $model->where(['Inst_id' => $Inst_id ,'Subject' => $Subject ]);

        if($q1){
            echo json_encode($q1[0]->Jr_id);
        }else{
            echo json_encode(['message' => 'no subjects found']);
        }
    }


    public function applyforjobs($Teacher_id) {
        $model = new Institute_applications();
        header('Content-Type: application/json');
        
        $inputData = json_decode(file_get_contents('php://input'), true); // Decode the incoming JSON

        $insertion_data = [
            'Jr_id' => $inputData['Jr_id'],
            'Teacher_id' => $Teacher_id,
            'Date' => $inputData['Date'],
            'Full_name' => $inputData['Full_name'],
            'Email' => $inputData['Email'],
            'Subject' => $inputData['Subject'],
            'Phone_number' => $inputData['Phone_number'],
            'Qualifications' => $inputData['Qualifications'],
            'stateis' => '1'
        ];

        if (isset($insertion_data)) {
            try {
                $application = $model->insert($insertion_data);
    
                if ($application) {
                    echo json_encode(['message' => 'successfully', 'data' => $application]);
                } else {
                    echo json_encode(['message' => 'Could not insert the application']);
                }
            } catch (Exception $e) {
                echo json_encode(['error' => 'An error occurred while creating the application.', 'details' => $e->getMessage()]);
            }
        } else {
            echo json_encode(['error' => 'Missing required fields']);
        }
    }

    // check applied
    public function checkapplied($Teacher_id,$Inst_id,$Subject){
        header('Content-Type: application/json'); // Set header for JSON response
        $model1 = new Institute_applications();
        $model2 = new Jobroll();

        $tables = [
            $model2->table,$model1->table
        ];

        $join_condition = [
            'jobroll.Jr_id = institute_applications.Jr_id'
        ];

        $data = [
            'Teacher_id' => $Teacher_id,
            'Inst_id'=>$Inst_id,
            'institute_applications.Subject' => $Subject
        ];

        $q1 = $model1->InnerJoinwhereMultiple($tables,$join_condition,$data,[]);
       
        if($q1){
            echo json_encode($q1);
        }else{
            echo json_encode(['message' => 'no subjects found']);
        }
    }
    
}