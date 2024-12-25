<?php
 
 class Advertisements extends Controller{

    public function index(){
    
        $this->view('General/Advertisements/advertisements');
    }

    public function form(){
        if($_SESSION['Role'] === 'teacher' || $_SESSION['Role'] === 'institute'){
            
                $this->view('General/Advertisements/adform');
            
        
        }else{
        $this->view('Error');
        }
    }
}