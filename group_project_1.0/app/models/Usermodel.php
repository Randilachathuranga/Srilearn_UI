<?php

class UserModel
{
    use Model; // Includes the Model trait

    protected $table = 'user'; // Define the database table
    protected $allowedColumns = [
        'F_name',
        'L_name',
        'Email',
        'District',
        'Phone_number',
        'Address',
        'Password', // Add password for updating it
    ];

    public $errors = [];

    // Validation logic for profile updates
    public function validate($data)
    {
        $this->errors = []; // Clear previous errors

        // Validate first name
        if (empty($data['F_name']) || strlen($data['F_name']) < 2) {
            $this->errors['F_name'] = 'First name must be at least 2 characters long.';
        }

        // Validate last name
        if (empty($data['L_name']) || strlen($data['L_name']) < 2) {
            $this->errors['L_name'] = 'Last name must be at least 2 characters long.';
        }

        // Validate email
        if (empty($data['Email']) || !filter_var($data['Email'], FILTER_VALIDATE_EMAIL)) {
            $this->errors['Email'] = 'Invalid email format.';
        }

        // Validate phone number
        if (empty($data['Phone_number']) || !preg_match('/^\d{10}$/', $data['Phone_number'])) {
            $this->errors['Phone_number'] = 'Phone number must be 10 digits.';
        }

        // Validate district
        if (empty($data['District'])) {
            $this->errors['District'] = 'District is required.';
        }

        // Validate address
        if (empty($data['Address'])) {
            $this->errors['Address'] = 'Address is required.';
        }

        // Validate password (optional)
        if (!empty($data['Password']) && strlen($data['Password']) < 8) {
            $this->errors['Password'] = 'Password must be at least 8 characters long.';
        }

        return empty($this->errors); // Return true if no errors
    }
}
