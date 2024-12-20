<?php

class Student extends StudentController
{
    /**
     * Default method for the student dashboard.
     */
    public function index()
    {
        $this->view('Home/Home');
    }

    public function classes(){
        $this->view('Byclasses/classes');
    }

    /**
     * View classes based on subject and grade.
     *
     * @param string $subject - The subject to filter.
     * @param string $grade - The grade to filter.
     */
    public function viewClasses($subject, $grade)
    {
        $model = new StudentModel();
        try {
            $classes = $model->getClassesForStudent($subject,$grade);
            
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

    public function allclasses(){
        $model= new StudentModel();

        
        header('Content-Type: application/json');
    
        // Fetch blogs for the given user ID
        try {
            $classes = $model->findall();
            
            if ($classes) {
                // Return blogs as JSON
                echo json_encode($classes);
            } else {
                // Handle case where no blogs were found
                echo json_encode(['message' => 'No classes found .']);
            }
        } catch (Exception $e) {
            // Error handling in case of an exception
            echo json_encode(['error' => 'An error occurred while fetching classes.', 'details' => $e->getMessage()]);
        }

    }



    /**
     * API for viewing classes (JSON).
     *
     * @param string $subject - The subject to filter.
     * @param string $grade - The grade to filter.
     */
    public function viewClassesApi($subject, $grade)
    {
        $model = new StudentModel();

        // Fetch classes
        $classes = $model->getClassesForStudent($subject, $grade);

        if (empty($classes)) {
            http_response_code(404);
            echo json_encode(['error' => 'No classes found for the specified subject and grade.']);
            return;
        }

        header('Content-Type: application/json');
        echo json_encode($classes, JSON_PRETTY_PRINT);
    }

    /**
     * Enroll the student in a class.
     *
     * @param int $classId - The class ID to enroll in.
     */
    public function enrollInClass($classId)
    {
        // Hardcoded for now, replace with session in real scenario
        $_SESSION['stuId'] = 1; // Example: Hardcoding user ID for testing

        $stuId = $_SESSION['stuId'];
        $model = new StudentModel();

        // Enroll the student
        $isEnrolled = $model->enrollStudent($stuId, $classId);

        if ($isEnrolled) {
            echo json_encode(['status' => 'success', 'message' => 'Enrollment successful!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Enrollment failed. Please try again.']);
        }
    }

    /**
     * Remove the student from a class.
     *
     * @param int $classId - The class ID to leave.
     */
    public function leaveClass($classId)
    {
        // Hardcoded for now, replace with session in real scenario
        $_SESSION['stuId'] = 1; // Example: Hardcoding user ID for testing

        $stuId = $_SESSION['stuId'];
        $model = new StudentModel();

        // Remove the student from the class (delete enrollment)
        $isRemoved = $model->removeEnrollment($stuId, $classId);

        if ($isRemoved) {
            echo json_encode(['status' => 'success', 'message' => 'You have successfully left the class.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to leave the class. Please try again.']);
        }
    }
}
