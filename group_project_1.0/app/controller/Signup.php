<?php 

class Signup extends Controller {

    public function index() {
    
        
        $User=new Usermodel;
        if($_SERVER['REQUEST_METHOD']=="POST"){
        if($User->validate($_POST) || !($User->get_email($_POST['Email']))){
            
        $options=['cost'=>12];
        $_POST['password']=password_hash($_POST['password'],PASSWORD_BCRYPT,$options);
        
        $User->insert($_POST);
        redirect('signin');
      
        }
    

        
        // The view file is home.php
       
        }
        
    $data['errors']=$User->errors;
        $this->view('signup',$data); 
    }

    
}
