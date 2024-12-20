<?php 

class Sysadmin extends Controller {

    
    public function index() {
    
        $model = new Usermodel();
        
        checkAccess('sysadmin');
        $this->view('Sysadmin/sysadmin'); 
    }

    public function studentapi() {
        $model = new Usermodel();
        checkAccess('sysadmin');
        header('Content-Type: application/json');
        $users = $model->where(['role'=>'student']); // Fetch users, you can add conditions here
        echo json_encode($users);
    
    }
    public function count() {
        $model=new Usermodel();
        checkAccess('sysadmin');
        header('Content-Type: application/json');
        $users = $model->getcount(); 
        echo json_encode($users);
    }
    
    public function teacherapi() {
        $model = new Usermodel();
        checkAccess('sysadmin');
        header('Content-Type: application/json');
        $users = $model->where(['role'=>'teacher']); // Fetch users, you can add conditions here
        echo json_encode($users);

    }
    
    public function instituteapi() {
        $model = new Usermodel();
        checkAccess('sysadmin');
        header('Content-Type: application/json');
        $users = $model->where(['role'=>'institute']); // Fetch users, you can add conditions here
        echo json_encode($users);

    }

    public function deleteapi($userId) {
        // Ensure models are loaded properly
        $userModel = new Usermodel();
        $delModel = new Delmodel(); 
    
        // Ensure user has the right access
        checkAccess('sysadmin');
    
        try {
            // Fetch user data for the given ID
            $userData = $userModel->where(['User_id'=>$userId]); 
            $assocArray = get_object_vars($userData[0]);
            
            // Ensure user exists before proceeding
            if (!$userData) {
                echo json_encode(['status' => 'error', 'message' => 'User not found']);
                return;
            }
    
            // Insert the user data into the DelModel
            if (!$delModel->insert($assocArray)) {
                echo json_encode(['status' => 'error', 'message' => 'Failed to move user data to the deleted table']);
                return;
            }
    
            // Delete the user from the UserModel
            if (!$userModel->delete($userId)) {
                echo json_encode(['status' => 'error', 'message' => 'Failed to delete user from original table']);
                return;
            }
    
            echo json_encode(['status' => 'success', 'message' => 'User deleted successfully']);
        } catch (Exception $e) {
            // Handle any exceptions
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function update($userId) {
        // Fetch the user data by ID
        $model = new Usermodel();
        checkAccess('sysadmin');
        $user = $model->first(['User_id' => $userId]);
    
        // Check if the request is a POST request
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($model->update($userId, $_POST)) {
                
                // Redirect to the Sysadmin dashboard on successful update
                redirect('Sysadmin');
                // Ensure path is correct
            } else {
                // Output an error message if the update fails
                echo "Failed to update user.";
            }
        }
    
        // Display the updateUser view with user data only if not POST
        $this->view('Sysadmin/updateUser', ['user' => $user]);
    }
    

    
}




