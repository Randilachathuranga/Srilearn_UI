<?php

class Advertisements extends Controller {

  
    public function index(){
        $this->view('General/Advertisements/advertisements');
    }

    //view all adds
    public function viewall() {
        header('Content-Type: application/json');
        $model = new AdvertisementModel();
        $allads = $model->findall();
        echo json_encode($allads);
    }

    //view my all adds
    public function myads() {
        header('Content-Type: application/json');
        $id=$_SESSION['User_id'];
        $model = new AdvertisementModel();
        $allads = $model->where(['User_id'=>$id]);
        echo json_encode($allads);
    }

    //my adds page
    public function viewmyads(){
        $this->view('General/Advertisements/myadvertisements');
    }


    // API: Delete specific ad
    public function deleteapi($id) {
        $model = new AdvertisementModel;
        $deleteadd = $model->delete($id,'Ad_id');
        echo json_encode($deleteadd);
    }

  //create a add
    public function post() {
        $model = new AdvertisementModel();
        header('Content-Type: application/json');
        $inputData = json_decode(file_get_contents('php://input'), true); // Decode incoming JSON
        $data = [
            'User_id' => $inputData['User_id'],
            'Title' => $inputData['Title'],
            'Content' => $inputData['Content'],
            'Post_date' => $inputData['Post_date'],
            'Iseducation' => $inputData['Iseducation'],
            'Subject' => $inputData['Subject']
        ];
            try {
                $add = $model->insert($data);
                if (!($add)) {
                    echo json_encode(['success' => 'Advertisement created successfully', 'data' => $add]);
                    header("Location:http://localhost/group_project_1.0/public/Advertisements");
                } else {
                    echo json_encode(['success' => 'Could not insert the advertisement']);
                }
            } catch (Exception $e) {
                echo json_encode(['error' => 'An error occurred while creating the advertisement.', 'details' => $e->getMessage()]);
            }
    }
    
    // API: Update specific ad
    public function myupdateapi($id) {
        checkloginstatus();
    
        // Get JSON input from the request body
        $jsonData = file_get_contents("php://input");
        $data = json_decode($jsonData, true); // decode as associative array
    
        // Check for decoding errors
        if (json_last_error() !== JSON_ERROR_NONE) {
            echo json_encode(['error' => 'Invalid JSON input']);
            return;
        }
    
        // Prepare data for update
        $pass_data = [
            'Title'       => $data['Title'] ?? null,
            'Content'     => $data['Content'] ?? null,
            'Post_date'   => $data['Post_date'] ?? null,
            'Iseducation' => $data['Iseducation'] ?? '0',
            'Subject'     => $data['Subject'] ?? null
        ];
    
        // Proceed with updating
        $model = new AdvertisementModel();
        $updated = $model->update($id, $pass_data, 'Ad_id');
    
        if ($updated) {
            echo json_encode(['success' => 'Advertisement updated successfully']);
        } else {
            echo json_encode(['error' => 'Failed to update advertisement']);
        }
    }

    
    

    
  
}
