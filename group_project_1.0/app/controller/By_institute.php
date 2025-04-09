<?php

class By_institute extends Controller{
    public function index(){
        $model=new Usermodel();
       $this->view('General/Byinstitute/Institute');
    }

    public function viewallinstitute(){
        header('Content-Type: application/json'); // Set header for JSON response
        $model=new Usermodel();

        $result = $model->where(["Role" => "institute"]);
        if ($result) {
            // Return blogs as JSON
            echo json_encode($result);
        } else {
            // Handle case where no blogs were found
            echo json_encode(['message' => 'no teachers found']);
        }
    }

    public function specificinstitute($id){
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