<?php

class ClassStudents extends Controller
{
    public function index()
    {
        $this->view('TeacherView/Options/ClassStudents/ClassStudents');
    }

    public function viewstudents($Class_id){
        $model = new Enrollmodel();

        $quaryforview = $model->InnerJoinwhere('user','enrollment','user.User_id = enrollment.Stu_id',['Class_id' => $Class_id]);

        if (empty($quaryforview)) {
            http_response_code(404);
            echo json_encode(['error' => 'No classes found for the given Class_id.']);
            return;
        }
        header('Content-Type: application/json');
        echo json_encode($quaryforview, JSON_PRETTY_PRINT);

    }
}