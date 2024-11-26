<?php
 
 class Advertisements extends Controller{

    public function index(){
        $this->view('advertisements');
    }

    public function form(){
        $this->view('adform');
    }
 }