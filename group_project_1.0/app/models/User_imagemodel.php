<?php

class User_imagemodel {
    
    use Model;
    
    public $table = 'user_image';
    public $allowedColumns = ['User_id', 'Src'];

    // Check if image exists for a user
    public function check_if_exists($user_id) {
        $query = "SELECT * FROM {$this->table} WHERE User_id = :User_id LIMIT 1";
        $params = ['User_id' => $user_id];
        $result = $this->query($query, $params);
        return !empty($result);
    }

}
