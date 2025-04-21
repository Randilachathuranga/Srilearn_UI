<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

class ContactUS extends Controller {

    public function index() {
        $this->view('General/Contactform/Contactform');
    }

    public function send() {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Get form data safely
            $email   = trim($_POST['email'] ?? '');
            $subject = trim($_POST['subject'] ?? '');
            $message = trim($_POST['message'] ?? '');

            // Basic validation
            if (empty($subject) || empty($email) || empty($message)) {
                http_response_code(400);
                echo json_encode(['status' => 'error', 'message' => 'All fields are required.']);
                return;
            }

            try {
                $mail = new PHPMailer(true);
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'srilearnofficial@gmail.com';
                $mail->Password   = 'lqpdnlzfauvbvjrd'; // Store in .env in production
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port       = 587;

                // FROM your system
                $mail->setFrom('srilearnofficial@gmail.com', 'SriLearn Contact Form');

                // REPLY-TO user who submitted the form
                $mail->addReplyTo($email);

                // TO admin
                $mail->addAddress('srilearnofficial@gmail.com', 'SriLearn Admin');

                $mail->isHTML(true);
                $mail->Subject = htmlspecialchars($subject);
                $mail->Body    = "<h4>New Message from Contact Form</h4>
                                  <p><strong>From:</strong> {$email}</p>
                                  <p><strong>Subject:</strong> " . htmlspecialchars($subject) . "</p>
                                  <p><strong>Message:</strong><br>" . nl2br(htmlspecialchars($message)) . "</p>";

                if ($mail->send()) {
                    echo json_encode(['status' => 'success', 'message' => 'Your message has been sent successfully!']);
                } else {
                    http_response_code(500);
                    echo json_encode(['status' => 'error', 'message' => 'Failed to send email.']);
                }

            } catch (Exception $e) {
                http_response_code(500);
                echo json_encode(['status' => 'error', 'message' => 'Mailer Error: ' . $mail->ErrorInfo]);
            }

        } else {
            http_response_code(405);
            echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
        }
    }
}
