<?php
class Signin extends Controller {

public function index() {
    $data = []; // Initialize data array
    $User = new Usermodel; // Instantiate the User model
    $User->errors = []; // Initialize errors array

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        // Check if 'User_id' and 'Password' are set in the POST data
        $arr['Email'] = $_POST['Email'] ?? ''; 
        $password = $_POST['Password'] ?? '';

        // Fetch user by 'User_id'
        $row = $User->first($arr);

        if ($row) {
            // Use password_verify() to check if the entered password matches the hashed password
            if (($password==$row->Password)) {
                $_SESSION['User_id'] = $row->User_id;
                $_SESSION['Role'] = $row->Role;

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
                // Redirect to the appropriate page based on the role
                return; 
            } else {
                $User->errors['password'] = "Wrong password"; // Set password error message
            }
        } else {
            $User->errors['Email'] = "Email not found or incorrect Email"; // Set user ID error message
        }

        // Pass errors to the view
        $data['errors'] = $User->errors;
    }

    // Render the 'signin' view with any errors
    $this->view('General/Signin_Signup/signin', $data); 
}
}
