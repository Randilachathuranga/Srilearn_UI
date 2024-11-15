<?php 

class Signin extends Controller {

    public function index() {
        $data = []; // Initialize data array
        $User = new Usermodel; // Instantiate the User model
        $User->errors = []; // Initialize errors array

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            // Check if 'User_id' and 'Password' are set in the POST data
            $arr['User_id'] = $_POST['User_id'] ?? ''; 
            $password = $_POST['Password'] ?? '';

            // Fetch user by 'User_id'
            $row = $User->first($arr);

            if ($row) {
                // Check if the provided password matches the stored password
                if ($password === $row->Password) {
                    $_SESSION['User_id'] = $row->User_id;
                    $_SESSION['Role'] = $row->Role;

                    switch($_SESSION['Role']){
                        case 'Student':
                            redirect('Student');
                        case 'Teacher':
                            redirect('Teacher');
                        case 'Institute':
                            redirect('Institute');
                        case 'Sysadmin':
                            redirect('Sysadmin');
                    }
                     // Redirect to sysadmin page if login is successful
                    return; 
                } else {
                    $User->errors['password'] = "Wrong password"; // Set password error message
                }
            } else {
                $User->errors['User_id'] = "User not found or incorrect name"; // Set user ID error message
            }

            // Pass errors to the view
            $data['errors'] = $User->errors;
        }
      

        // Render the 'signin' view with any errors
        $this->view('signin', $data); 
    }
}
