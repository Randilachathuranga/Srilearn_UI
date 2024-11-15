<?php 

class Sysadmin extends Controller {

    function checkAccess($requiredRole) {
        if (!isset($_SESSION['Role']) || $_SESSION['Role'] !== $requiredRole) {
           echo "123";
           redirect('Error404');
           exit();
        }
    }
    
    public function index() {
    
        $model = new Usermodel();
        echo $_SESSION['Role'];
        $this->checkAccess('Sysadmin');
        $this->view('sysadmin'); 
    }

    public function studentapi() {
        $model = new Usermodel();
        header('Content-Type: application/json');
        $users = $model->where(['role'=>'student']); // Fetch users, you can add conditions here
        echo json_encode($users);
    
    }
    
    public function teacherapi() {
        $model = new Usermodel();
        header('Content-Type: application/json');
        $users = $model->where(['role'=>'teacher']); // Fetch users, you can add conditions here
        echo json_encode($users);

    }
    
    public function instituteapi() {
        $model = new Usermodel();
        header('Content-Type: application/json');
        $users = $model->where(['role'=>'institute']); // Fetch users, you can add conditions here
        echo json_encode($users);

    }

    public function deleteapi($userId) {
        $model = new Usermodel();
        try {
            if ($model->delete($userId)) {  // Use $userId here, as it's passed from the route
                echo json_encode(['status' => 'success', 'message' => 'User deleted successfully']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to delete user']);
            }
             
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
            
        }
         
    }

    public function update($userId) {
        // Fetch the user data by ID
        $model = new Usermodel();
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
        $this->view('updateUser', ['user' => $user]);
    }
    

    
}




