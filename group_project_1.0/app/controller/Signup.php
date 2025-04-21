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
                    $User->insert($_POST);
                    // Redirect to signin page
                    redirect('signin');
                }
            }
            // Handling teacher registration
            else if ($_POST['Role'] == "teacher") {
                // Map form fields to database fields
                $data = [
                    'F_name' => $_POST['F_name'],
                    'L_name' => $_POST['L_name'] ?? '',
                    'Email' => $_POST['Email'],
                    'District' => $_POST['District'],
                    'Phone_number' => $_POST['Phone_number'],
                    'Address' => $_POST['Address'],
                    'Password' => $_POST['Password'],
                    'URL' => $_POST['Link'] // Map 'Link' to 'URL'
                ];
                
                // Validate Tempuser data
                if ($Tempuser->validate($data) && $Tempuser->get_email($_POST['Email'])) {
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