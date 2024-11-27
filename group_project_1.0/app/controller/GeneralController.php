<?php
Class GeneralController extends Controller {

   public function loadinstitute(){
      $this->view('TeacherView/Institute/Institute');
   }
   public function loadteacher(){
    $this->view('TeacherView/AllTeachers/AllTeachers');
   }

}


