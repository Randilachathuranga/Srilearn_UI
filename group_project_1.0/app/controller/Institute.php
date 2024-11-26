<?php 
class Institute extends Controller {

    public function index(){
        echo "institute";
        echo $_SESSION['Role'];
    }

    // Method to remove a teacher by N_id
    public function removeTeacher($teacherId) {
        // Instantiate the model
        $instituteModel = new InstituteModel();

        // Call the delete method from the model to remove the teacher
        if ($instituteModel->removeTeacher($teacherId)) {
            // Redirect to the teachers list page after removal
            header("Location: /institute/viewteachers");
            exit();
        } else {
            // Handle the error if the teacher couldn't be deleted
            echo "Error removing teacher.";
        }
    }
}
