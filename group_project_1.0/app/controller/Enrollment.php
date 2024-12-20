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

        // Check if the necessary session data exists
        if (empty($inputData['Stu_id'])) {
            echo json_encode(['error' => 'User not logged in. Please log in to enroll.']);
            return;
        }

        try {
            // Insert the enrollment data using the model
            $enroll = $model->insert($inputData);

            if ($enroll) {
                // Send success response
                echo json_encode(['message' => 'Enrolled successfully', 'data' => $enroll]);
                return;
            } else {
                // Send failure response
                echo json_encode(['message' => 'Could not enroll. Please try again later.']);
                return;
            }
        } catch (Exception $e) {
            // Catch and log any errors
            echo json_encode(['error' => 'An error occurred while enrolling.', 'details' => $e->getMessage()]);
            return;
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