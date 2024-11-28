<?php
class Enrollment extends Controller
{
    public function index()
    {
        if (checkAccess('student')) {
            $this->view('Enrollment');
        }
    }

    public function post($classid)
    {
        if (checkAccess('student')) {
            // Start output buffering to prevent unexpected output
            ob_start();

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
                ob_end_flush();
                return;
            }

            try {
                // Insert the enrollment data using the model
                $enroll = $model->insert($inputData);

                if ($enroll) {
                    // Send success response
                    echo json_encode(['message' => 'Enrolled successfully', 'data' => $enroll]);
                } else {
                    // Send failure response
                    echo json_encode(['message' => 'Could not enroll. Please try again later.']);
                }
            } catch (Exception $e) {
                // Catch and log any errors
                echo json_encode(['error' => 'An error occurred while enrolling.', 'details' => $e->getMessage()]);
            }

            // Clean the output buffer and send JSON response
            ob_end_flush();
            return;
        }
    }

    public function api()
    {
        if (checkAccess('student')) {
            $model = new Enrollmodel();
            header('Content-Type: application/json'); // Set JSON header
            try {
                $classes = $model->InnerJoinwhere(
                    'enrollment',
                    'class',
                    'enrollment.Class_id=class.Class_id',
                    ['Stu_id' => $_SESSION['User_id']]
                );

                // Return data as JSON
                echo json_encode($classes ?: []);
            } catch (Exception $e) {
                // Handle errors
                echo json_encode(['error' => 'An error occurred while fetching classes.', 'details' => $e->getMessage()]);
            }
        }
    }

    public function mydeleteapi($id)
    {
        if (checkAccess('student')) {
            // Start output buffering to prevent unexpected output
            ob_start();

            $model = new Enrollmodel();
            header('Content-Type: application/json');

            try {
                $enroll = $model->delete($id, 'Enrollment_id');

                if ($enroll) {
                    // Send success response
                    echo json_encode(['message' => 'Enrollment deleted successfully']);
                } else {
                    // Send failure response
                    echo json_encode(['message' => 'Failed to delete the enrollment.']);
                }
            } catch (Exception $e) {
                // Handle errors
                echo json_encode(['error' => 'An error occurred while deleting enrollment.', 'details' => $e->getMessage()]);
            }

            // Clean the output buffer and send JSON response
            ob_end_flush();
            return;
        }
    }
}
