<?php
class Ann extends Controller{
    public function index() {
        $model= new Announcementmodel();
        $this->view('Announcement'); 
    }
   
     public function api() {
        $model = new Announcementmodel();
        header('Content-Type: application/json');
        $ann = $model->findall(); 
        echo json_encode($ann);
    }
    
}
?>