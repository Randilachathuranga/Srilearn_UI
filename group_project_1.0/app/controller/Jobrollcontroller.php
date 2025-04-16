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
    
    public function applyforjobs($Teacher_id) {
        $model = new Institute_applications();
        header('Content-Type: application/json');
        
        $inputData = json_decode(file_get_contents('php://input'), true);
        
        if (isset($inputData['Inst_id']) && isset($inputData['Subject'])) {
            $data = [
                'Inst_id' => $inputData['Inst_id'],
                'Subject' => $inputData['Subject']
            ];
            
            $Jr_id = $this->getJr_id($data);
            if (!$Jr_id) {
                echo json_encode(['error' => 'No matching Jr_id found']);
                return;
            }
            
            $insertion_data = [
                'Jr_id' => $Jr_id,  // Add the Jr_id here
                'Teacher_id' => $Teacher_id,
                'Date' => $inputData['Date'],
                'Full_name' => $inputData['Full_name'],
                'Email' => $inputData['Email'],
                'Subject' => $inputData['Subject'],
                'Phone_number' => $inputData['Phone_number'],
                'Qualifications' => $inputData['Qualifications'],
                'stateis' => '1'
            ];
            
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