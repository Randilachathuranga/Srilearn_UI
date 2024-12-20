<?php 
class Teacher extends Controller{
    public function index(){
        checkAccess('teacher');
        $this->view("General/Home/Home");
    }

}
