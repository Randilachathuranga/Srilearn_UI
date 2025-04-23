<?php

class AdvertisementImageModel{
    use Model;

    Public $table='advertisements_image';
    Public $allowedColumns=[
        'Ad_id','Src'
    ];

     // Check if image exists for a user
     public function check_if_exists($Ad_id) {
        $query = "SELECT * FROM {$this->table} WHERE Ad_id = :Ad_id LIMIT 1";
        $params = ['Ad_id' => $Ad_id];
        $result = $this->query($query, $params);
        return !empty($result);
    }
}