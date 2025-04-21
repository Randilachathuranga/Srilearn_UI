<?php 
class Messegemodel{
    use Model;

    protected $table="chat";
    protected $allowedColumns=[
        'sender_id','reciever_id','message','date','time','msg_id'   
    ];

    public function validate($data){    
        $this->errors=[];
        if(empty($data['message'])){
            $this->errors['message']="message cant be empty";
        }
        if(empty($this->errors)){
            return true;
        }
        return false;
    }


}