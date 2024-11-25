<?php
class Announcementmodel{
    
    use Model;

    protected $table='announcement';
    protected $allowedColumns=[
        'annid','date','title','announcement'
    ];

    public function validate($data){
        $this->errors=[];

        if(empty($data['title'])){
            $this->errors['title']="title is required";
        }
        if(empty($data['announcement'])){
            $this->errors['announcemnt']="announcement is required";
        }
        

        if(empty($this->errors)){
            return true;
        }
        return false;
    }
    
}