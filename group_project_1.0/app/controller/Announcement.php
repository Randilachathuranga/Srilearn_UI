<?php
class Announcement extends Controller {
     
    
    public function index() {
        $Ann = new Announcementmodel;

        // Check if form is submitted
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            if ($Ann->validate($_POST)) {
                $Ann->insert($_POST);
                redirect('Announcement/viewann');  // Redirect to the 'view' page after successful insertion
            } else {
                // If validation fails, store errors in $data['errors']
                $data['errors'] = $Ann->errors;
                $this->view('Announcementform', $data); // Show form with errors
                return;
            }
        }

        // Load the form view without errors (initial form load)
        $data['errors'] = [];
        $this->view('Announcementform', $data);
    }

    public function viewann() {
        // Load the view for displaying announcements
        
        $this->view('Announcement', []);
    }
    public function api() {
        $model = new Announcementmodel;
        header('Content-Type: application/json');
        $ann = $model->findall(); 
        echo json_encode($ann);
    }

    public function deleteapi($id){
        $model= new Announcementmodel;
        

         if ($_SESSION['Role'] !== 'Sysadmin') {
            http_response_code(403); // Forbidden
            echo json_encode(["error" => "Unauthorized"]);
            return;
        }
        try {
            if ($model->delete($id,'annid')) {  // Use $userId here, as it's passed from the route
                echo json_encode(['status' => 'success', 'message' => 'aNn deleted successfully']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to delete Ann']);
            }
             
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
            
        }
         
    }

    
    public function updateapi($id) {
        
        $model = new Announcementmodel();
        $user = $model->first(['annid' => $id]);
    
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($model->update($id, $_POST,'annid')) {
                
                
                redirect('Announcement/viewann');
                
            } else {
                
                echo "Failed to update ann.";
            }
        }
    
        
        $this->view('Announcementupdateform', ['ann' => $user]);
    }
         
}


    

        
    

  

