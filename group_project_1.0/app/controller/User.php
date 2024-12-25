<?php

class User extends Controller
{
    public function __construct()
    {
        // Start the session if it's not already started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function editprofile()
    {
        // Hardcoded user_id for now
        $user_id = 1; // Replace this with $_SESSION['user_id'] when login is implemented

        // Load UserModel to fetch user data
        $userModel = new UserModel();
        $userData = $userModel->first(['User_id' => $user_id]);

        if (!$userData) {
            // If the user is not found, redirect or show an error
            echo "User not found.";
            return;
        }

        // If it's a POST request, handle the update
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $formData = $_POST; // Get submitted form data

            // Validate data using UserModel's validate method
            if ($userModel->validate($formData)) {
                // If valid, update the user's information
                if ($userModel->update($user_id, $formData)) {
                    $successMessage = "Profile updated successfully.";
                    $userData = $userModel->first(['User_id' => $user_id]); // Refresh data after update
                } else {
                    $errorMessage = "Failed to update profile. Please try again.";
                }
            } else {
                $errors = $userModel->errors; // Get validation errors
            }
        }

        // Load the EditProfile view and pass necessary data
        $this->view('user/EditProfile', [
            'userData' => $userData,
            'errors' => $errors ?? [],
            'successMessage' => $successMessage ?? '',
            'errorMessage' => $errorMessage ?? ''
        ]);
    }
}
