<?php 

class My_Institute extends Controller{
    public function index() {
    
        $model = new Myclassmodel();
         $this->View('General/Myinstitute/Myinstitute'); 
    }
}

?>