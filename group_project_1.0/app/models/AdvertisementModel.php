<?php
class AdvertisementModel{
    
    use Model;

    protected $table='advertisements';
    protected $allowedColumns=[
        'Ad_id','User_id','Title','Content','Post_date','Iseducation','Subject'
    ];
    

    public function last_InsertId() {
        $query = "SELECT MAX(Ad_id) AS Ad_id FROM {$this->table}";
        $result = $this->query($query);  // Execute the query
        if ($result && isset($result[0]->Ad_id)) {
            return $result[0]->Ad_id;
        }
        
        // Return null if the query fails or no result
        return null;
    }
}