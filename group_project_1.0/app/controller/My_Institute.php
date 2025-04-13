<?php 

class My_Institute extends Controller{
    public function index() {
    
        $model = new Myclassmodel();
         $this->view('TeacherView/Myinstitute/Myinstitute'); 
    }
}

?>