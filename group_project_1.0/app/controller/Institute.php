<?php 
class Institute extends Controller{
    public function index(){
        checkAccess('institute');
        $this->view("General/Home/Home");
    }
}