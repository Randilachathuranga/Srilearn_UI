<?php

class ClassStudents extends Controller
{
    public function index()
    {
        $this->view('TeacherView/Options/ClassStudents/ClassStudents');
    }

    public function viewstudents($Class_id){
        $model = new Enrollmodel();
        $data = [
            'class.Class_id' => $Class_id
            ];
        $quaryforview = $model->InnerJoinwhereMultiple(['user','enrollment','class'],['user.User_id=enrollment.Stu_id','enrollment.Class_id=class.Class_id'],$data,[]);

        if (empty($quaryforview)) {
            http_response_code(404);
            echo json_encode(['error' => 'No classes found for the given Class_id.']);
            return;
        }
        header('Content-Type: application/json');
        echo json_encode($quaryforview, JSON_PRETTY_PRINT);

    }
}