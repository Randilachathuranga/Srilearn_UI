<?php
 
 class Subscriptions extends Controller{

    public function index(){
        if($_SESSION['Role'] === 'taecher' || $_SESSION['Role'] === 'institute'){
            $this->view('Subscriptions/Subscription');
        }
        $this->view('Error');

    }
}