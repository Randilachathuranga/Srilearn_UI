<?php

class Institute_teacher extends Controller{

        public function index() {
            $model1 = new Usermodel();
            $model2 = new Normalteacher();
            $model3 = new User_subjectmodel();
            $this->View('InstituteView/InstituteTeachers/MyTeachers'); 
        }


        //veiw my all teachers
        public function My_teachers($INST_id) {
            $model = new Normalteacher();
            $tables =['normal_teacher','teacher','user'];
            $join_conditions = ['normal_teacher.N_id = teacher.Teach_id', 'teacher.Teach_id = user.User_id'];
            $data =['normal_teacher.Institute_ID' => $INST_id];
            $datanot=[];
            $result = $model->InnerJoinwhereMultiple($tables,$join_conditions,$data,$datanot);
        
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
            $model = new Normalteacher();
            
            $result = $model->delete($N_ID);

            if(empty($result)) {
                http_response_code(404); echo json_encode(['error'=> '']);}

        }
        
        
}