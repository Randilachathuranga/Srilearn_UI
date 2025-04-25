<?php
class Signup extends Controller {
    public function index() {
        $User = new Usermodel;
        $Tempuser = new Tempusermodel;
        
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            // Handling student and institute registration
            if ($_POST['Role'] == "student" || $_POST['Role'] == "institute") {
                // Validate user data
                if ($User->validate($_POST) && $User->get_email($_POST['Email'])) {
                    // If valid, insert user data into User model
                    $hashedPassword = password_hash($_POST['Password'], PASSWORD_DEFAULT);
                    $_POST['Password'] = $hashedPassword; // Hash the password before storing
                    $User->insert($_POST);
                    // Redirect to signin page
                    redirect('signin');
                }
            }

          
            // Handling teacher registration
            else if ($_POST['Role'] == "teacher") {
                // Get subjects as comma-separated string
                $subjects = isset($_POST['Subject']) ? implode(',', $_POST['Subject']) : '';
            
                // Map form fields to database fields
                $data = [
                    'F_name' => $_POST['F_name'],
                    'L_name' => $_POST['L_name'] ?? '',
                    'Email' => $_POST['Email'],
                    'District' => $_POST['District'],
                    'Phone_number' => $_POST['Phone_number'],
                    'Address' => $_POST['Address'],
                    'Password' =>password_hash($_POST['Password'], PASSWORD_DEFAULT),
                    'URL' => $_POST['Link'], // Map 'Link' to 'URL'
                    'Subject' => $subjects, // Comma-separated subject list
                ];
             
                
                // Validate Tempuser data
               if ($Tempuser->validate($data)) {
                    // If valid, insert teacher data into Tempuser model
                    $Tempuser->insert($data);
                    // Redirect to signin page
                    redirect('signin');
                }
        
            
            }
        }
        
        // If validation fails, pass the errors to the view for display
        $data['errors'] = $User->errors ?? ($Tempuser->errors ?? []);
        // Load the signup view with error data
        $this->view('General/Signin_Signup/signup', $data);
    }
}