<?php 
class Institute extends Controller{
    public function index(){
        checkAccess('Institute');
        $this->view("General/Home/Home");
    }

}
