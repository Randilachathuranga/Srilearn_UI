<?php
class Signin extends Controller {

    public function index() {
        $data = []; // Initialize data array
        $User = new Usermodel; // Instantiate the User model
        $Submodel = new Subscriptionmodel();
        $User->errors = []; // Initialize errors array
    
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $arr['Email'] = $_POST['Email'] ?? ''; 
            $password = $_POST['Password'] ?? '';
    
            // Fetch user by email
            $row = $User->first($arr);
    
            $issubbed = 0;
            $activeRecord = null;
            
    
          if ($row) {
                // Join conditions for subscription and subdetails
                $tables = ['subscription', 'subdetails'];
                $joinConditions = ['subscription.Type = subdetails.Type'];
                $filter = ['subscription.P_id' => $row->User_id];
                $notConditions = [];
    
                // Fetch joined data
                $result = $Submodel->InnerJoinwhereMultiple($tables, $joinConditions, $filter, $notConditions);
                echo json_encode($result);
                $instmodel=new Normalteacher();
                $count=$instmodel->where(['N_id'=>$row->User_id]);
                if($count){
                    $_SESSION['hasinst']=1;
                }
                else{
                $_SESSION['hasinst']= 0;
                }
               $currentDate = date('Y-m-d');
    
                // Filter to find a valid subscription
                $validRecords = array_filter($result, function($record) use ($currentDate) {
                    return isset($record->End_data) && $record->End_data > $currentDate;
                });
    
                // Get the first matching record (if available)
                if (!empty($validRecords)) {
                    $activeRecord = reset($validRecords);
                    $issubbed = 1;
                }
    
                // Verify password (replace with password_verify in production)
                if (password_verify($password, $row->Password)) {
                    // Set session variables
                    $_SESSION['User_id'] = $row->User_id;
                    $_SESSION['Role'] = $row->Role;
                    $_SESSION['Issubbed'] = $issubbed;
                    $_SESSION['Subtype'] = $activeRecord->Type ?? null;
                    $_SESSION['Isjobavail'] =$activeRecord->Isjobavail ?? null;
                    $_SESSION['Ispayavail'] = $activeRecord->Ispayavail ?? null;
                    $_SESSION['Isadavail'] = $activeRecord->Isadavail ?? null;
                    $_SESSION['ischatavail'] = $activeRecord->ischatavail ?? null;
    
                  // Redirect based on role
                    switch ($_SESSION['Role']) {
                        case 'student': redirect('Student'); break;
                        case 'teacher': redirect('Teacher'); break;
                        case 'institute': redirect('Institute'); break;
                        case 'sysadmin': redirect('Sysadmin'); break;
                    }
                    return; // Exit after redirection
                } else {
                    $User->errors['Password'] = "Incorrect password.";
                }
            } else {
                $User->errors['Email'] = "Email not found or incorrect.";
            }
    
            // Pass errors to the view
            $data['errors'] = $User->errors;
           
        }
    
        // Render the sign-in view
       
        $this->view('General/Signin_Signup/signin', $data); 
    }
    
}
