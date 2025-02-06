<?php
class ContactUS extends Controller {
    
    // Load the contact form view
    public function index() {
        $this->view('General/Contactform/Contactform');
    }

    // Handle form submission
    public function send($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Get form data
            $name = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $message = trim($_POST['message'] ?? '');

            // Validate input
            if (empty($name) || empty($email) || empty($message)) {
                echo json_encode(['status' => 'error', 'message' => 'All fields are required.']);
                http_response_code(400);
                exit;
            }

            // Email details
            $to = "randilachathuranga100@gmail.com";
            $subject = "New Contact Form Submission from $name";
            $headers = "From: $email\r\n";
            $headers .= "Reply-To: $email\r\n";
            $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

            $emailBody = "You have received a new contact form message:\n\n";
            $emailBody .= "Name: $name\n";
            $emailBody .= "Email: $email\n";
            $emailBody .= "Message:\n$message\n";

            // Send email
            if (mail($to, $subject, $emailBody, $headers)) {
                echo json_encode(['status' => 'success', 'message' => 'Message sent successfully!']);
                http_response_code(200);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to send email.']);
                http_response_code(500);
            }
            exit;
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
            http_response_code(405);
            exit;
        }
    }
}
