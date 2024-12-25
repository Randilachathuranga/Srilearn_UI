<?php
class Profile extends Controller{

       public function index(){
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
       $this->view('General/Myprofile/Myprofile');
    }



       public function myapi($id) {
        
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
    public function myupdateapi($id) {
        // Get JSON input from the request body
        $jsonData = file_get_contents("php://input");
        $data = json_decode($jsonData, true);
    
        // Check for decoding errors
        if (json_last_error() !== JSON_ERROR_NONE) {
            echo json_encode(['error' => 'Invalid JSON input']);
            return;
        }
    
        // Proceed with updating using $id and $data
        $model = new Blogmodel();
        $updated = $model->update($id, $data, 'Blog_id');
        
        if ($updated) {
            echo json_encode(['success' => 'Blog updated successfully']);
        } else {
            echo json_encode(['error' => 'Failed to update blog']);
        }
    }

}


