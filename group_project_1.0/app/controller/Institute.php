<?php 
class Institute extends Controller{
    public function index(){
        checkAccess('institute');
        $this->view("General/Home/Home");
    }

    public function classes(){
        $this->view("InstituteView/Classes");
    }

    public function classapi($instid){
        $instmodel=new Instteachclassmodel();
        header('Content-Type: application/json');
        $rec=$instmodel->where(['inst_id'=>$instid]);
        echo json_encode($rec);
    }

    public function viewstudents(){
     $this->view("InstituteView/Students");
    }

    public function teacherapi($id) {
        $teachmodel = new Normalteacher();
        header('Content-Type: application/json');
        
        // Fetch all records
        $rec = $teachmodel->findall();
        
        // Filter the results based on the Institute_ID
        $filteredRec = array_filter($rec, function($teacher) use ($id) {
            return $teacher->Institute_ID == $id; // Compare Institute_ID to the provided $id
        });
        
        // Reindex array after filtering (optional but recommended for clean indexing)
        $filteredRec = array_values($filteredRec);
    
        // Return the filtered results as JSON
        echo json_encode($filteredRec);
    }

    public function studentapi($id) {
        
        $studentmodel = new Enrollmodel();
        header('Content-Type: application/json');
        
        // Fetch all records
        $rec = $studentmodel->where(['Class_id'=>$id]);    
        
        
    
        // Return the filtered results as JSON
        echo json_encode($rec);
    }

    public function removestudent($enrollid){
        $model= new Enrollmodel;
        

         if ($_SESSION['Role'] !== 'institute') {
            http_response_code(403); // Forbidden
            echo json_encode(["error" => "Unauthorized"]);
            return;
        }
        try {
            if ($model->delete($enrollid,'Enrollment_id')) {  // Use $userId here, as it's passed from the route
                echo json_encode(['status' => 'success', 'message' => 'aNn deleted successfully']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to delete Ann']);
            }
             
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
            
        }
    }
    public function payfee($id) {
        header('Content-Type: application/json');
    
        try {
            $model = new Payroll_requestmodel();
    
            // Fetch all pending payrolls for the class
            $records = $model->where([
                'InstClass_id' => $id,
                'stateis' => 0
            ]);
    
            $currentMonth = date('m');
            $currentYear = date('Y');
            $targetRecord = null;
    
            if (is_array($records) || is_object($records)) {
                foreach ($records as $record) {
                    $recordMonth = date('m', strtotime($record->currentdate));
                    $recordYear = date('Y', strtotime($record->currentdate));
                    if ($recordMonth === $currentMonth && $recordYear === $currentYear) {
                        $targetRecord = $record;
                        break;
                    }
                }
            }
    
            if ($targetRecord) {
                $updated = $model->update(
                    $targetRecord->Id,
                    [
                        'stateis' => 1,
                        'issue_date' => date('Y-m-d')
                    ],
                    'Id'
                );
    
                if ($updated) {
                    echo json_encode(['status' => 'success', 'message' => 'Monthly payment request sent successfully.']);
                } else {
                    http_response_code(500);
                    echo json_encode(['status' => 'error', 'message' => 'Failed to update the payment request.']);
                }
            } else {
                http_response_code(400);
                echo json_encode(['status' => 'error', 'message' => 'No pending request found for this month.']);
            }
    
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'status' => 'error',
                'message' => 'Server error occurred.',
                'details' => $e->getMessage()
            ]);
        }
    }
    
    
    
}