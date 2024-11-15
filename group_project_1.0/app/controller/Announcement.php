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
        echo $_SESSION['Role'];
        $this->view('Announcement', []);
    }
    public function api() {
        $model = new Announcementmodel;
        header('Content-Type: application/json');
        $ann = $model->findall(); 
        echo json_encode($ann);
    }
  
}
