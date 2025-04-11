<?php
class Enrollment extends Controller
{
    public function index()
    {
        $this->view('StudentView/MyEnrollements/Enrollment');
    }

    public function post($classid)
    {
        // Instantiate the model
        $model = new Enrollmodel();
    
        // Set the response type to JSON
        header('Content-Type: application/json');
    
        // Prepare input data
        $inputData = [
            'Date' => date("Y-m-d"),
            'Stu_id' => $_SESSION['User_id'] ?? null, // Safely get the session user ID
            'Class_id' => $classid,
            'Isdiscountavail' => 0
        ];
    
        // Check if the user is logged in
        if (empty($inputData['Stu_id'])) {
            http_response_code(401); // Unauthorized
            echo json_encode(['error' => 'User not logged in. Please log in to enroll.']);
            return;
        }
    
        // Check if the user is already enrolled in the class
        $isEnrolled = $model->checkisEnrolled($inputData['Stu_id'], $inputData['Class_id']);
    
        if ($isEnrolled) {
            http_response_code(403); // Forbidden
            echo json_encode(['error' => 'You are already enrolled in this class.']);
            return;
        }
    
        try {
            // Insert the enrollment data using the model
            $enroll = $model->insert($inputData);
    
            if ($enroll) {
                // Send success response
                http_response_code(200); // OK
                echo json_encode(['message' => 'Enrolled successfully', 'data' => $enroll]);
            } else {
                // Send failure response
                http_response_code(500); // Internal Server Error
                echo json_encode(['message' => 'Could not enroll. Please try again later.']);
            }
        } catch (Exception $e) {
            // Catch and log any errors
            http_response_code(500); // Internal Server Error
            echo json_encode(['error' => 'An error occurred while enrolling.', 'details' => $e->getMessage()]);
        }
    }
    

 public function api(){
    $model = new Enrollmodel();
    try {
        $classes = $model->InnerJoinwhere('enrollment','class','enrollment.Class_id=class.Class_id',['Stu_id' => $_SESSION['User_id']]);
        
        if ($classes) {
            // Return blogs as JSON
            echo json_encode($classes);
        } else {
            // Handle case where no blogs were found
            echo json_encode([]);
        }
    } catch (Exception $e) {
        // Error handling in case of an exception
        echo json_encode(['error' => 'An error occurred while fetching classes.', 'details' => $e->getMessage()]);
    }
 }

 public function allindividual(){
    $model= new StudentModel();
    header('Content-Type: application/json');
    try {
        $tables =['class','individual_class','user','enrollment'];
        $join_conditions = ['class.Class_id = individual_class.IndClass_id', 'individual_class.P_id = user.User_id',
        'enrollment.Class_id=class.Class_id'];

        $data =['enrollment.Stu_id' =>$_SESSION['User_id']];
        $datanot=[];
        $individual = $model->InnerJoinwhereMultiple($tables,$join_conditions,$data,$datanot);
        if ($individual) {
            echo json_encode($individual);
        } else {
            echo json_encode(['message' => 'No classes found .']);
        }
    } catch (Exception $e) {
        echo json_encode(['error' => 'An error occurred while fetching classes.', 'details' => $e->getMessage()]);
    }
}

public function allinstitute(){
    $model= new StudentModel();
    header('Content-Type: application/json');
    try {
        $tables2 =['class','instituteteacher_class','enrollment'];
        $join_conditions2 = ['class.Class_id = instituteteacher_class.InstClass_id','enrollment.Class_id=class.Class_id'];

        $data2 =['enrollment.Stu_id' =>$_SESSION['User_id']];
        $datanot=[];
        $institute = $model->InnerJoinwhereMultiple($tables2,$join_conditions2,$data2,$datanot);
        if ($institute) {
            echo json_encode($institute);
        } else {
            echo json_encode(['message' => 'No classes found .']);
        }
    } catch (Exception $e) {
        echo json_encode(['error' => 'An error occurred while fetching classes.', 'details' => $e->getMessage()]);
    }
}

 public function mydeleteapi($id) {
        
    $model = new Enrollmodel();
    header('Content-Type: application/json');

    // Fetch blogs for the given user ID
    try {
        $enroll = $model->delete($id,'Enrollment_id');
        
        if ($enroll) {
            // Return blogs as JSON
            echo json_encode($enroll);
        } else {
            // Handle case where no blogs were found
            echo json_encode(['message' => 'No blogs found for this user.']);
        }
    } catch (Exception $e) {
        // Error handling in case of an exception
        echo json_encode(['error' => 'An error occurred while fetching blogs.', 'details' => $e->getMessage()]);
    }
}
}