<?php 
class Institute extends Controller{
    public function index(){
        checkAccess('Institute');
        $this->view("Home/Home");
    }
}