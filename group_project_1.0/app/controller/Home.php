<?php 

class Home extends Controller {

    public function index($a = '', $b = '', $c = '') {
    
        $model = new Homemodel();
       
        
        // Render the view
        $this->view('home'); // The view file is home.php
    }

    public function api() {
        $model = new Homemodel();
        header('Content-Type: application/json');
        $users = $model->where(['age'=>22]); // Fetch users, you can add conditions here
        echo json_encode($users);
    }
}
?>

