<?php
Class Blogmodel{
    use Model;

    protected $table='blogs';
    protected $allowedColumns=[
        'Blog_id','User_id','Title','Content','Likes','Post_date'
    ];

    function get_user($id){
        $user=new Usermodel();
        return $user->first($id);
    }

}