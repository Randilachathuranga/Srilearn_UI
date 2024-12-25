<?php
 
 class Subscriptions extends Controller{

    public function index(){
        if($_SESSION['Role'] === 'teacher' || $_SESSION['Role'] === 'institute'){
            $this->view('General/Subscriptions/Subscriptions');
        }
        $this->view('Error');

    }
}