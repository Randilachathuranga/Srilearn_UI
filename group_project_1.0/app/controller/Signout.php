<?php
class Signout extends Controller {
    public function index() {
        // Clear session variables
        unset($_SESSION['User_id']);
        unset($_SESSION['Role']);

        // Destroy the session (optional, but clears all session data)
      

        // Redirect to the signin page
        redirect('signin');
    }
}
