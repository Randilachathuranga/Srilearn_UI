<?php

class Student extends StudentController
{
    /**
     * Default method for the student dashboard.
     */
    public function index()
    {
        $this->Studentview('Dashboard');
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

        // Fetch classes
        $classes = $model->getClassesForStudent($subject, $grade);

        // Pass classes to the view
        $this->Studentview('ViewClasses', ['subject' => $subject, 'grade' => $grade, 'classes' => $classes]);
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
