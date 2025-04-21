<?php
class Tempusermodel {
    use Model;
    protected $table = 'temp_users';
    protected $allowedColumns = [
        'F_name', 'L_name', 'Email', 'District',
        'Phone_number', 'Address', 'Password', 'URL'
    ];
    
    public function get_email($data) {
        if($this->first(['Email' => $data])) {
            return false;
        }
        return true;
    }
    
    public function validate($data) {
        $this->errors = [];
        
        if(empty($data['F_name'])) {
            $this->errors['name'] = "At least one name is required";
        }
        
        if(empty($data['Email'])) {
            $this->errors['email'] = "Email is required";
        }
        
        if(!($this->get_email($data["Email"]))) {
            $this->errors["email"] = "Email already exists";
        }
        
        if(!filter_var($data['Email'], FILTER_VALIDATE_EMAIL)) {
            $this->errors['email'] = 'Enter a valid email';
        }
        
        if(empty($data['District'])) {
            $this->errors['district'] = "District required";
        }
        
        if(empty($data['Phone_number'])) {
            $this->errors['pn'] = "Phone number is required";
        }
        
        if(empty($data['Address'])) {
            $this->errors['address'] = "Address is required";
        }
        
        if(empty($data['Password'])) {
            $this->errors['pwd'] = "Password is required";
        }
        
        if(!empty($data['Re-password']) && $data['Password'] != $data['Re-password']) {
            $this->errors['re-pwd'] = 'Passwords do not match';
        }
        
        if(empty($data['URL'])) {
            $this->errors['url'] = "URL is required";
        }
        
        if(!empty($data['URL']) && !filter_var($data['URL'], FILTER_VALIDATE_URL)) {
            $this->errors['url-1'] = 'Enter a valid URL';
        }
        
        if(empty($this->errors)) {
            return true;
        }
        
        return false;
    }
}