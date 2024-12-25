<?php
Class GeneralController extends Controller {

   public function loadinstitute(){
      $this->view('General/Byinstitute/Institute');
   }
   public function loadteacher(){
    $this->view('General/Byteacher/AllTeachers');
   }

}


