<?php 

class Signup extends Controller {

    public function index($a = '', $b = '', $c = '') {
    
        show($_POST);
    
        $User=new Homemodel;
        if($_SERVER['REQUEST_METHOD']=="POST"){
        if($User->validate($_POST)){
        $User->insert($_POST);
        redirect('signin');
      
        }
        // The view file is home.php
       
    }
    $data['errors']=$User->errors;
        $this->view('signup',$data); 
    }

    
}
?>