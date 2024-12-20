<?php
Class GeneralController extends Controller {

   public function loadinstitute(){
      $this->view('Byinstitute/Institute');
   }
   public function loadteacher(){
    $this->view('/Byteacher/AllTeachers');
   }

}


