<?php
Class Guest extends Controller{
    
    public function index(){
        $_SESSION['User_id']='Guest';
        $_SESSION['Role']='Guest';

        $this->view('Home/Guest');
    }

}
