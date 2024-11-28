<?php
class Profile extends Controller{

       public function index(){
        if(checkloginstatus()){
        $model=new Usermodel();
        if($_SERVER['REQUEST_METHOD']=="POST"){
           
            $model->update($_SESSION['User_id'],$_POST);
            switch ($_SESSION['Role']) {
                case 'student':
                    redirect('Student');
                    break;
                case 'teacher':
                    redirect('Teacher');
                    break;
                case 'institute':
                    redirect('Institute');
                    break;
                case 'sysadmin':
                    redirect('Sysadmin');
                    break;
            }
        
       }
       $this->view('Myprofile');
    }
    }



       public function myapi($id) {
        if(checkloginstatus()){
        $model = new Usermodel();

        header('Content-Type: application/json');
    
        // Fetch blogs for the given user ID
        try {
            $user = $model->where(['User_id' => $id]);
            
            if ($user) {
                // Return blogs as JSON
                echo json_encode($user);
            } else {
                // Handle case where no blogs were found
                echo json_encode(['message' => 'No user found for this id.']);
            }
        } catch (Exception $e) {
            // Error handling in case of an exception
            echo json_encode(['error' => 'An error occurred while fetching user.', 'details' => $e->getMessage()]);
        }
    }
}
   
}


