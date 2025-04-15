<?php

class Advertisements extends Controller {

  
    public function index(){
        $this->view('General/Advertisements/advertisements');
    }

    public function viewall() {
        header('Content-Type: application/json');

        $model = new AdvertisementModel();
        $allads = $model->findall();

        echo json_encode($allads);
    }



    // API: Delete specific ad
    public function deleteapi($id) {
        // $this->requireTeacherOrInstitute();

        $model = new AdvertisementModel;

        $deleteadd = $model->delete($id,'Ad_id');
        echo json_encode($deleteadd);
    }

  

    public function post() {
        $model = new AdvertisementModel();
        header('Content-Type: application/json');
    
        $inputData = json_decode(file_get_contents('php://input'), true); // Decode incoming JSON
    
    
    
        if ($model->validate($inputData)) {
            try {
                $add = $model->insert($inputData);
                if ($add) {
                    echo json_encode(['message' => 'Advertisement created successfully', 'data' => $add]);
                    header("Location:http://localhost/group_project_1.0/public/Advertisements");
                } else {
                    echo json_encode(['message' => 'Could not insert the advertisement']);
                }
            } catch (Exception $e) {
                echo json_encode(['error' => 'An error occurred while creating the advertisement.', 'details' => $e->getMessage()]);
            }
        } else {
            echo json_encode(['error' => 'Missing required fields: Title, Content, or Post_date']);
        }
    }
    
    public function myupdateapi($id) {
        checkloginstatus();
        // Get JSON input from the request body
        $jsonData = file_get_contents("php://input");
        $data = json_decode($jsonData, true);
    
        // Check for decoding errors
        if (json_last_error() !== JSON_ERROR_NONE) {
            echo json_encode(['error' => 'Invalid JSON input']);
            return;
        }
    
        // Proceed with updating using $id and $data
        $model = new AdvertisementModel();
        $updated = $model->update($id, $data, '_id');
        
        if ($updated) {
            echo json_encode(['success' => 'Advertistment updated successfully']);
        } else {
            echo json_encode(['error' => 'Failed to update blog']);
        }
    } 
  
}
