<?php 

class Signup extends Controller {

    public function index() {
    
        
    
        $User=new Usermodel;
        if($_SERVER['REQUEST_METHOD']=="POST"){
        if($User->validate($_POST) && ($User->get_email($_POST['Email']))){
            
       // $options=['cost'=>12];
        //$_POST['Password']=password_hash($_POST['Password'],PASSWORD_BCRYPT,$options);
        
        $User->insert($_POST);
        redirect('signin');
      
        }
    

        
        
       
        }
        
        $data['errors']=$User->errors;
        $this->view('signup',$data); 
    }

    
}
