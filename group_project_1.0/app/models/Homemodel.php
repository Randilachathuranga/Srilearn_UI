<?php
class Homemodel{
    
    use Model;

    protected $table='users';
    protected $allowedColumns=[
        'name','age','password'
    ];

    public function validate($data){
        $this->errors=[];

        if(empty($data['name'])){
            $this->errors['name']="name is required";
        }
        if(empty($data['password'])){
            $this->errors['password']="password is required";
        }



        if(empty($this->errors)){
            return true;
        }
        return false;
    }
    
}