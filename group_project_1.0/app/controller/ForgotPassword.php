<?php


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

class ForgotPassword extends Controller
{
    public function index()
    {
        $this->view('General/ForgotPword/ForgotPword');
    }

    public function sendotp()
    {   
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
        

        header('Content-Type: application/json');

        $data = json_decode(file_get_contents('php://input'), true);

        // Validate input
       $email= $data['email'];
       $otp= $data['otp'];

        // Store OTP and email in session
        $_SESSION['otp'] = $otp;
        $_SESSION['otp_email'] = $email;

        $subject = "Use this OTP to reset your Password";

        try {
            $mail = new PHPMailer(true);

            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'srilearnofficial@gmail.com';
            $mail->Password   = 'lqpdnlzfauvbvjrd'; // ⚠ Replace with secure method in production
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            $mail->setFrom('srilearnofficial@gmail.com', 'SriLearn');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = htmlspecialchars($subject);
            $mail->Body = "
                <h3>Use the OTP below to reset your password:</h3>
                <div style='font-size: 24px; color: #2E8B57; margin: 10px 0;'>$otp</div>
                <p>This OTP is valid for a short time only. Please do not share it with anyone.</p>
            ";

            if ($mail->send()) {
                echo json_encode(['status' => 'success', 'message' => 'Your message has been sent successfully!']);
            } else {
                http_response_code(500);
                echo json_encode(['status' => 'error', 'message' => 'Failed to send email.']);
            }

        }  catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => 'Mailer Error: ' . $mail->ErrorInfo]);
        }
        
        
    }
    else {
        http_response_code(405);
        echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
    }

} 
public function validateotp($otp){
    {   
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
        

        header('Content-Type: application/json');

        $data = json_decode(file_get_contents('php://input'), true);

        // Validate input
       $email= $data['email'];
        $otp= $data['otp'];

        // Store OTP and email in session
        
        if($_SESSION['otp'] == $otp){
            echo json_encode(['status'=> 'success','message'=> 'goda machan']);
        }
       else{
         echo json_encode(['status'=>'error','message'=> 'boka']);
       }

       
        
        
    }
    else {
        http_response_code(405);
        echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
    }
}
}
public function changepword()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        header('Content-Type: application/json');

        // Get raw POST data and decode JSON
        $data = json_decode(file_get_contents('php://input'), true);

        // Validate inputs
        if (empty($data['password']) || empty($_SESSION['otp_email'])) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Missing password or session email.'
            ]);
            return;
        }
       
        $password = password_hash($data['password'], PASSWORD_DEFAULT);
        $email = $_SESSION['otp_email'];

        // Update password in database
        $user = new Usermodel();
        $updated = $user->update($email, ['Password' => $password], 'Email');

        if ($updated) {
            echo json_encode([
                'status' => 'success',
                'message' => 'Password updated successfully.'
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Failed to update password.'
            ]);
        }
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Invalid request method.'
        ]);
    }
}


    


}
