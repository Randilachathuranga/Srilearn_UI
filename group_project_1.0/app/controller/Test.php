<?php 
class Test extends Controller{
    public function index(){
        $model=new Usermodel();
        $recs=$model->wherein([54,60,62],'User_id');
        echo json_encode($recs);
    }
}
