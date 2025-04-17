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

    // get jr id 
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
    
    //create applications
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
                'stateis' => '0'
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
            'institute_applications.Subject' => $Subject,
        ];

        $q1 = $model1->InnerJoinwhereMultiple($tables,$join_condition,$data,['stateis' => '2']);
       
        if($q1){
            echo json_encode($q1);
        }else{
            echo json_encode(['message' => 'no subjects found']);
        }
    }


     //create Job roll
     public function createjobroll($Inst_id) {
        $model = new Jobroll();
        header('Content-Type: application/json');
        $inputData = json_decode(file_get_contents('php://input'), true);

        if (isset($inputData['Subject']) && isset($inputData['description'])) {
            try {
                $data = [
                    'Inst_id' => $Inst_id,
                    'Status' => 'Active',
                    'Subject' => $inputData['Subject'],
                    'application_date' =>$inputData['application_date'],
                    'description' => $inputData['description']
                ];
                $Jobroll = $model->insert($data);
                
                if ($Jobroll) {
                    echo json_encode(['success' => 'successfully', 'data' => $Jobroll]);
                } else {
                    echo json_encode(['error' => 'Could not insert the Jobroll']);
                }
            } catch (Exception $e) {
                echo json_encode(['error' => 'An error occurred while creating the Jobroll.', 'details' => $e->getMessage()]);
            }
        } else {
            echo json_encode(['error' => 'Missing required fields']);
        }
    }
    

    public function deleteJobroll($Jr_id) {
        $model = new Jobroll();
        header('Content-Type: application/json');
    
        try {
            $deleted = $model->delete($Jr_id, 'Jr_id');
            
            if ($deleted) {
                echo json_encode(['success' => 'Jobroll deleted']);
            } else {
                echo json_encode(['error' => 'No Jobroll found with this ID.']);
            }
        } catch (Exception $e) {
            echo json_encode(['error' => 'An error occurred while deleting the Jobroll.', 'details' => $e->getMessage()]);
        }
    }
    

    //Activate or diactivate jobroll
    public function Active_inactive($Jr_id) {
        header('Content-Type: application/json'); // Set header for JSON response
        $model = new Jobroll();
        $q1 = $model->where(['Jr_id' => $Jr_id]);
        if($q1){
            echo json_encode($q1[0]->Status);
            if($q1[0]->Status == "Active"){
                $data = ['Status' => 'Inactive'];
                $update = $model->update($Jr_id,$data,'Jr_id');
                if ($update) {
                    echo json_encode(['success' => 'Jobroll Inactivated']);
                } else {
                    echo json_encode(['error' => 'Failed to update blog']);
                }
            }else if ($q1[0]->Status == "Inactive"){
                $data = ['Status' => 'Active'];
                $update = $model->update($Jr_id,$data,'Jr_id');
                if ($update) {
                    echo json_encode(['success' => 'Jobroll Activated']);
                } else {
                    echo json_encode(['error' => 'Failed to update blog']);
                }
            }
        }else{
            echo json_encode(['message' => 'no subjects found']);
        }
    }

    // view applications
    public function viewapplications($Inst_id,$Subject){
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
            'Inst_id'=>$Inst_id,
            'jobroll.Subject'=>$Subject
        ];

        $q1 = $model1->InnerJoinwhereMultiple($tables,$join_condition,$data,[]);
       
        if($q1){
            echo json_encode($q1);
        }else{
            echo json_encode(['message' => 'no subjects found']);
        }
    }

    //reqruit teachers
    public function reqruitteachers($ID,$Teacher_id,$Inst_id){
        header('Content-Type: application/json'); // Set header for JSON response
        $model = new Institute_applications();
        $normalteacher = new Normalteacher();
        $data = [
            'stateis' => '1'
        ];
        $normleacher_data = [
            'N_id' => $Teacher_id,
            'Institute_ID' => $Inst_id
        ];
        $q1 = $model->update($ID,$data,'ID');
        $q2 = $normalteacher->insert($normleacher_data);
        if($q1 && $q2){
            echo json_encode(['message' => 'successfully']);
        }else{
            echo json_encode(['message' => 'no subjects found']);
        }
    }

    //reject teachers
    public function rejectteachers($ID){
        header('Content-Type: application/json'); // Set header for JSON response
        $model = new Institute_applications();
        $data = [
            'stateis' => '2'
        ];
        $q1 = $model->update($ID,$data,'ID');
        if($q1){
            echo json_encode(['message' => 'rejected successfully']);
        }
    }

    
}