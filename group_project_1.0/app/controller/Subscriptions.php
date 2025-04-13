<?php
 
 class Subscriptions extends Controller{

    public function index(){
        if($_SESSION['Role'] === 'teacher' || $_SESSION['Role'] === 'institute'){
            $this->view('General/Subscriptions/Subscriptions');
        }
        $this->view('Error');

    }

    public function viewallsubdetails(){
        header('Content-Type: application/json'); // Set header for JSON response
        $model=new Subdetailsmodel();
 
        $result = $model->findAll();
        if ($result) {
            // Return blogs as JSON
            echo json_encode($result);
        } else {
            // Handle case where no blogs were found
            echo json_encode(['message' => 'no teachers found']);
        }
    }
}