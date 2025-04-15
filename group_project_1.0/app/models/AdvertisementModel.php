<?php
class AdvertisementModel{
    
    use Model;

    protected $table='advertisements';
    protected $allowedColumns=[
        'Ad_id','User_id','Title','Content','Post_date','Iseducation','Subject'
    ];
    
    public function validate($data){
        $this->errors=[];

        if(empty($data['Title'])){
            $this->errors['Title']="title is required";
        }
        if(empty($data['Advertisment'])){
            $this->errors['Advertisment']="Advertisment is required";
        }
        

        if(empty($this->errors)){
            return true;
        }
        return false;
    }
     // Get user by ID
     function get_user($id){
        $user = new Usermodel();
        return $user->first($id);
    }

    // Get total blog count with optional search filter
    public function getTotalAddCount($search = '') {
        $query = "SELECT COUNT(*) as total FROM {$this->table}";
        
        // Add search condition if search term is provided
        if (!empty($search)) {
            $query .= " WHERE Title LIKE '%$search%'";
        }
        
        $result = $this->query($query);
        return $result[0]->total ?? 0;
    }

    // Find paginated blogs with optional search filter
    public function findPaginatedAdds($limit, $offset, $search = '') {
        $query = "SELECT * FROM {$this->table}";
        
        // Add search condition if search term is provided
        if (!empty($search)) {
            $query .= " WHERE Title LIKE '%$search%'";
        }
        
        $query .= " ORDER BY Post_date DESC LIMIT $limit OFFSET $offset";
        return $this->query($query);
    }
}
