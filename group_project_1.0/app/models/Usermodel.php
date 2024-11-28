<?php


class Usermodel{
    
    use Model;

    protected $table='user';
    protected $allowedColumns=[
        'User_id','F_name','L_name','Email','District','Role',
        'Phone_number','Address','Password'
    ];
    public  function get_email($data){
    
        if($this->first(['Email'=>$data])){
            return false;
        }
        return true;
    }

    

    public function validate($data){
        $this->errors=[];
 
        if(empty($data['F_name'])){
            $this->errors['name']="AT least one name is required";
        }
        if(empty($data['Email'])){
            $this->errors['email']=" email is required";
        }
        if(!($this->get_email($data["Email"]))){
            $this->errors["email"]= "email already exists";
        }
        if(!filter_var($data['Email'],FILTER_VALIDATE_EMAIL)){
            $this->errors['email']= 'enter a valid emai;';
        }
        if(empty($data['District'])){
            $this->errors['district']="District required";
        }
        if(empty($data['Role'])){
            $this->errors['role']="role is required";
        }
        if(empty($data['Address'])){
            $this->errors['address']="address is required";
        }
        if(empty($data['Phone_number'])){
            $this->errors['pn']="phone number is required";
        }
        if(empty($data['Password'])){
            $this->errors['pwd']="password is required";
        }
        if(!($data['Password']==$data['Re-password'])){
            $this->errors['re-pwd']= 'passwords do not match';
        }
        if(empty($this->errors)){
            return true;
        }
        
        return false;
    }

    public function getcount(){
       
        $query = "SELECT
        COUNT(CASE WHEN role = 'Student' THEN 1 END) AS stdcount,
        COUNT(CASE WHEN role = 'Teacher' THEN 1 END) AS tchcount,
        COUNT(CASE WHEN role = 'Institute' THEN 1 END) AS instcount
        FROM user;
         ";
          return $this->query($query );

    }
    
}