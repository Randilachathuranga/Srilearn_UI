<?php

class By_teacher extends Controller{
    public function index(){
        $model=new Usermodel();
       $this->view('General/Byteacher/AllTeachers');
    }

    public function viewallteachers(){
        header('Content-Type: application/json'); // Set header for JSON response
        $model=new Usermodel();

        $tables = ['user','teacher'];

        $join_condition =['user.User_id = teacher.Teach_id'];

        $data = ['user.Role' => 'teacher'];

        $data_not = [];
        $result = $model->InnerJoinwhereMultiple($tables,$join_condition,$data,$data_not);
        if ($result) {
            echo json_encode($result);
        } else {
            echo json_encode(['message' => 'no teachers found']);
        }
    }

    public function specificteacher($id){
        header('Content-Type: application/json'); // Set header for JSON response
        $model=new Usermodel();

        $tables = ['user','teacher'];

        $join_condition =['user.User_id = teacher.Teach_id'];

        $data = ['user.Role' => 'teacher' , "User_id"=>$id];

        $data_not = [];
        $result = $model->InnerJoinwhereMultiple($tables,$join_condition,$data,$data_not);
        if ($result) {
            echo json_encode($result);
        } else {
            // Handle case where no blogs were found
            echo json_encode(['message' => 'no teachers found']);
        }
    }

    
    public function teachers_by_subject($Subject){
        header('Content-Type: application/json'); // Set header for JSON response
        $model=new Usermodel();

        $tables = ['user','teacher'];

        $join_condition =['user.User_id = teacher.Teach_id'];

        $data = ['user.Role' => 'teacher' , "teacher.Subject"=>$Subject];

        $data_not = [];
        $result = $model->InnerJoinwhereMultiple($tables,$join_condition,$data,$data_not);
        if ($result) {
            echo json_encode($result);
        } else {
            // Handle case where no blogs were found
            echo json_encode(['message' => 'no teachers found']);
        }
    }
}