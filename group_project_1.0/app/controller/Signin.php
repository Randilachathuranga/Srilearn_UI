<?php 

class Signin extends Controller {

    public function index() {
        $data = []; // Initialize data array
        
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $User = new Homemodel;
            $arr['name'] = $_POST['name'];
            $row = $User->first($arr);

            if ($row) {
                // Assuming passwords are hashed, use password_verify
                if ($_POST['password']===$row->password) {
                    $_SESSION['USER'] = $row;
                    redirect('home');
                    return; // Exit after redirect to avoid further processing
                } else {
                    $User->errors['password'] = "Wrong password";
                }
            } else {
                $User->errors['name'] = "User not found or incorrect name";
            }

            $data['errors'] = $User->errors;
        }

        $this->view('signin', $data); 
    }
}
?>
