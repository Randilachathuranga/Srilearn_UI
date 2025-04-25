<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
class Sysadmin extends Controller {


    
    public function index() {
    
        $model = new Usermodel();
        
        checkAccess('sysadmin');
        $this->view('AdminView/Sysadmin/sysadmin'); 
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
        $this->view('AdminView/Sysadmin/updateUser', ['user' => $user]);
    }

    public function paymentreq(){
        $this->view('AdminView/Sysadmin/paymentreq');
    }
    public function payreqapi() {
        $model = new Reqinstpaymodel();
        checkAccess('sysadmin');
        header('Content-Type: application/json');
        
        $tables = ['instpayreq', 'user'];
        $join_conditions = ['instpayreq.inst_id = user.User_id'];
        $datanot = [];
    
        // First query for Enrollment
        $data = [
            'instpayreq.status' => 0,
            'user.role' => 'institute',
        ];
        $instreq = $model->InnerJoinwhereMultiple($tables, $join_conditions, $data, $datanot);
    
        // Second query for Classfee
        $dataClassFee = [
          'instpayreq.status' => 0,
            'user.role' => 'teacher',
        ];
        $teachreq = $model->InnerJoinwhereMultiple($tables, $join_conditions, $dataClassFee, $datanot);
        // Fetch records
        $allResults = array_merge($instreq ?: [], $teachreq ?: []);
    
        echo json_encode($allResults);   // ✅ Echo the encoded result
    }

    public function signupre(){
        $this->view('AdminView/Sysadmin/signupreq');
    }
    public function signupreq() {
        $model = new Tempusermodel();
        checkAccess('sysadmin');
        header('Content-Type: application/json');
        
      
        $req = $model->findall();
    
        echo json_encode($req);   // ✅ Echo the encoded result
    }
  

    public function approve($reqId) {
        $model = new Reqinstpaymodel();
        checkAccess('sysadmin');
        header('Content-Type: application/json');
        
        // Update the status to 1 (approved)
        if ($model->update($reqId, ['status' => 1],'req_id')) {
            echo json_encode(['status' => 'success', 'message' => 'Payment request approved successfully!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to approve payment request.']);
        }
    }

   // At top of file (with other includes)


   public function approvessu($reqId) {
    $tempUserModel = new Tempusermodel();
    $userModel = new Usermodel();
    $teacherModel = new Teachermodel();

    checkAccess('sysadmin');
    header('Content-Type: application/json');

    try {
        // Fetch the request record
        $tempUser = $tempUserModel->first(['req_id' => $reqId]);

        if (!$tempUser) {
            http_response_code(404);
            echo json_encode(['status' => 'error', 'message' => 'Signup request not found.']);
            return;
        }

        // Get subjects and split into array
        $subjectString = $tempUser->Subject ?? '';
        $subjects = array_filter(array_map('trim', explode(',', $subjectString))); // Clean array

        // Prepare user data for insertion
        $userData = (array) $tempUser;
        $userData['Role'] = 'teacher';
        unset($userData['req_id'], $userData['URL']);

        // Insert new teacher user
        $inserted = $userModel->insert($userData);
        $newUser = $userModel->first(['Email' => $userData['Email']]);

        if (!$inserted || !$newUser) {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => 'Failed to insert new user record.']);
            return;
        }

        // Insert subjects into teacher table
        foreach ($subjects as $sub) {
            $teacherModel->insert([
                'Teach_id' => $newUser->User_id,
                'Ratings' => 5,
                'Subject' => $sub,
                'Ispremium' => 0
            ]);
        }

        // Delete the temp request
        $deleted = $tempUserModel->delete($reqId, 'req_id');

        if (!$deleted) {
            http_response_code(500);
            echo json_encode([
                'status' => 'warning',
                'message' => 'User approved, but failed to remove the signup request.'
            ]);
            return;
        }

        // Attempt to send confirmation email
        $emailSent = false;
        $mailError = '';

        try {
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'srilearnofficial@gmail.com';
            $mail->Password   = 'lqpdnlzfauvbvjrd';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            $mail->setFrom('srilearnofficial@gmail.com', 'SriLearn Admin');
            $mail->addAddress($newUser->Email, $newUser->F_name); // Use actual email and name

            $mail->isHTML(true);
            $mail->Subject = 'Your SriLearn Account Has Been Approved';
            $mail->Body    = '<h3>Your account has been approved!</h3><p>You can now login to SriLearn using your credentials.</p>';

            $emailSent = $mail->send();
        } catch (Exception $e) {
            $mailError = $e->getMessage();
        }

        // Build success response
        $response = [
            'status' => 'success',
            'message' => 'Signup request approved and user added.',
            'email_status' => $emailSent ? 'sent' : 'failed'
        ];

        if (!$emailSent) {
            $response['email_error'] = $mailError;
        }

        echo json_encode($response);

    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode([
            'status' => 'error',
            'message' => 'An unexpected error occurred.',
            'details' => $e->getMessage()
        ]);
    }
}

    

    public function reject($reqId) {        
        $model = new Reqinstpaymodel();
        checkAccess('sysadmin');
        header('Content-Type: application/json');
        if ($model->delete($reqId,'req_id')) {  // Use $userId here, as it's passed from the route
            echo json_encode(['status' => 'success', 'message' => 'Payment request rejected successfully!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to reject payment request.']);
        }
    }

    public function rejectssu($reqId) {        
        $model = new Tempusermodel();
        checkAccess('sysadmin');
        header('Content-Type: application/json');
        if ($model->delete($reqId,'req_id')) {  // Use $userId here, as it's passed from the route
            echo json_encode(['status' => 'success', 'message' => 'Signup request rejected successfully!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to reject signup request.']);
        }
    }

    public function paymentreview(){
        $this->view('AdminView/Sysadmin/paymentreview');
    }
    public function analatics() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Read raw JSON input
            $input = json_decode(file_get_contents("php://input"), true);
            $year = $input['year'];
            $month = $input['month'];
    
            // Input validation
            if (!$year || !$month) {
                echo json_encode(['status' => 'error', 'message' => 'Year and month are required.']);
                http_response_code(400);
                return;
            }
    
            //checkAccess('sysadmin');
            header('Content-Type: application/json');
    
            $model = new Reqinstpaymodel();
    
            // Get all joined records with status = 1
            $rec = $model->InnerJoinwhereMultiple(
                ['instpayreq', 'user'],
                ['instpayreq.inst_id = user.User_id'],
                ['instpayreq.status' => 1],
                [] // optional additional filters
            );
    
            if (!$rec || !is_array($rec)) {
                echo json_encode(['status' => 'error', 'message' => 'No records found.']);
                return;
            }
    
            // Filter records by month and year from date column
            $filtered = array_filter($rec, function($record) use ($year, $month) {
                $recordDate = isset($record->date) ? strtotime($record->date) : null;
                return $recordDate &&
                       date('Y', $recordDate) == $year &&
                       date('m', $recordDate) == str_pad($month, 2, '0', STR_PAD_LEFT);
            });
    
            // Re-index array and return it as object
            $filtered = array_values($filtered);
    
            if (!empty($filtered)) {
                echo json_encode(['status'=>'success','records'=>$filtered]); // or (object)$filtered if you must force an object
            } else {
                echo json_encode(['status' => 'error', 'message' => 'No payments found for selected date.']);
            }
    
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
            http_response_code(405);
        }
    }
    
}




