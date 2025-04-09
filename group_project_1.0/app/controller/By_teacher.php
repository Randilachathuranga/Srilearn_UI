<?php

class By_teacher extends Controller{
    public function index(){
        $model=new Usermodel();
       $this->view('General/Byteacher/AllTeachers');
    }

    public function viewallteachers(){
        header('Content-Type: application/json'); // Set header for JSON response
        $model=new Usermodel();

        $result = $model->where(["Role" => "teacher"]);
        if ($result) {
            // Return blogs as JSON
            echo json_encode($result);
        } else {
            // Handle case where no blogs were found
            echo json_encode(['message' => 'no teachers found']);
        }
    }

    public function specificteacher($id){
        header('Content-Type: application/json'); // Set header for JSON response
        $model=new Usermodel();

        $result = $model->where(["Role" => "teacher" , "User_id"=>$id]);
        if ($result) {
            // Return blogs as JSON
            echo json_encode($result);
        } else {
            // Handle case where no blogs were found
            echo json_encode(['message' => 'no teachers found']);
        }
    }
}