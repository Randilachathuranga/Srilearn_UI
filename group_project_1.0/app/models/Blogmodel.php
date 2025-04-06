<?php
class Blogmodel {
    use Model;

    protected $table = 'blogs';
    protected $allowedColumns = [
        'Blog_id','User_id','Title','Content','Likes','Post_date'
    ];

    // Get user by ID
    function get_user($id){
        $user = new Usermodel();
        return $user->first($id);
    }

    // Get total blog count with optional search filter
    public function getTotalBlogCount($search = '') {
        $query = "SELECT COUNT(*) as total FROM {$this->table}";
        
        // Add search condition if search term is provided
        if (!empty($search)) {
            $query .= " WHERE Title LIKE '%$search%'";
        }
        
        $result = $this->query($query);
        return $result[0]->total ?? 0;
    }

    // Find paginated blogs with optional search filter
    public function findPaginatedBlogs($limit, $offset, $search = '') {
        $query = "SELECT * FROM {$this->table}";
        
        // Add search condition if search term is provided
        if (!empty($search)) {
            $query .= " WHERE Title LIKE '%$search%'";
        }
        
        $query .= " ORDER BY Post_date DESC LIMIT $limit OFFSET $offset";
        return $this->query($query);
    }
}