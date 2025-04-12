<?php
class AdvertisementModel{
    
    use Model;

    protected $table='advertisements';
    protected $allowedColumns=[
        'Ad_id','User_id','Title','Content','Post_date','Iseducation','Subject'
    ];
    
    public function validate($data){
        $this->errors=[];

        if(empty($data['title'])){
            $this->errors['title']="title is required";
        }
        if(empty($data['Advertisment'])){
            $this->errors['Advertisment']="Advertisment is required";
        }
        

        if(empty($this->errors)){
            return true;
        }
        return false;
    }
}