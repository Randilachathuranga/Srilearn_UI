<?php
 
 class Advertisements extends Controller{

    public function index(){
    
        $this->view('General/Advertisements/advertisements');
    }

    public function form(){
        if($_SESSION['Role'] === 'teacher' || $_SESSION['Role'] === 'institute'){
            
                $this->view('General/Advertisements/adform');
            
        
        }else{
        $this->view('Error');
        }
    }

    public function viewadd(){
        $model = new Advertisment();
        header('Content-Type: application/json');
    
        try {
            // Fetch data from the model
            $ads = $model->findall();
    
            if ($ads) {
                // Return advertisements as JSON
                echo json_encode($ads);
            } else {
                // Handle case where no advertisements were found
                echo json_encode(['message' => 'No advertisements found.']);
            }
        } catch (Exception $e) {
            // Error handling in case of an exception
            echo json_encode(['error' => 'An error occurred while fetching advertisements.', 'details' => $e->getMessage()]);
        }
    }
    
}