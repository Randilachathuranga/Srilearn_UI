<?php

class Institute_teacher extends Controller{

        public function index() {
            $model1 = new Usermodel();
            $model2 = new Normalteachermodel();
            $model3 = new User_subjectmodel();
            $this->View('InstituteView/InstituteTeachers/MyTeachers'); 
        }


        //veiw my all teachers
        public function My_teachers($INST_id) {
            $model = new myteachersviewmodel();
        
            $result = $model->where(['InstClass_id' => $INST_id]);
        
            if (empty($result)) {
                http_response_code(404); // Not Found
                echo json_encode(['error' => 'No teachers found for the given InstClass_id.']);
                return;
            }
        
            header('Content-Type: application/json');
            echo json_encode($result, JSON_PRETTY_PRINT);
        }

        //delete my teachers
        public function deleteTeacher($N_ID) {
            $model = new Normalteachermodel();
            
            $result = $model->delete($N_ID);

            if(empty($result)) {
                http_response_code(404); echo json_encode(['error'=> '']);}

        }
        
        
}