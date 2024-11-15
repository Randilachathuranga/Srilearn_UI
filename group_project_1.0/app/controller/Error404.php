<?php 
class Error404 extends Controller{

    public function index(){
        
        echo "404 contoller not found";
        $this->view('Error');
    }
}