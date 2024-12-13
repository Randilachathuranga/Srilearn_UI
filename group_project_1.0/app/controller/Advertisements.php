<?php
 
 class Advertisements extends Controller{

    public function index(){
    
        $this->view('advertisements');
    }

    public function form(){
        if($_SESSION['Role'] === 'teacher' || $_SESSION['Role'] === 'institute'){
            
                $this->view('adform');
            
        
        }else{
        $this->view('Error');
        }
    }
}