<?php
 
 class Advertisements extends Controller{

    public function index(){
        $this->view('advertisements');
    }

    public function form(){
        if(checkAccess('teacher')||checkAccess('institute')){
        $this->view('adform');
        }
    }
 }