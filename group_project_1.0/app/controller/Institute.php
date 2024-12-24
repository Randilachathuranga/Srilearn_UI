<?php

class Institute extends InstituteController
{
    protected $model;

    // Injecting the InstituteModel into the constructor
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Default method for the institute dashboard.
     */
    public function index()
    {
        $this->InstituteView('Dashboard');
    }

    /**
     * View all courses offered by the institute.
     */
    public function viewCourses()
    {
        $courses = $this->model->getAllCourses();
        $this->InstituteView('ViewCourses', ['courses' => $courses]);
    }

    /**
     * View a specific course based on course ID.
     */
    public function viewCourseDetails($courseId)
    {
        $course = $this->model->getCourseDetails($courseId);
        
        if (!$course) {
            http_response_code(404);
            echo json_encode(['error' => 'Course not found.']);
            return;
        }

        $this->InstituteView('ViewCourseDetails', ['course' => $course]);
    }

    /**
     * API for fetching courses in JSON format.
     */
    public function viewCoursesApi()
    {
        $courses = $this->model->getAllCourses();

        if (empty($courses)) {
            http_response_code(404);
            echo json_encode(['error' => 'No courses found.']);
            return;
        }

        header('Content-Type: application/json');
        echo json_encode($courses, JSON_PRETTY_PRINT);
    }

    /**
     * Enroll a student in a specific course.
     */
    public function enrollStudentInCourse($courseId, $studentId)
    {
        // Check if student is logged in or available in session
        if (!isset($_SESSION['stuId'])) {
            echo json_encode(['status' => 'error', 'message' => 'Student not logged in.']);
            return;
        }

        $stuId = $_SESSION['stuId'];
        $isEnrolled = $this->model->enrollStudentInCourse($stuId, $courseId);

        echo json_encode([
            'status' => $isEnrolled ? 'success' : 'error',
            'message' => $isEnrolled ? 'Enrollment successful!' : 'Enrollment failed. Please try again.'
        ]);
    }

    /**
     * Remove a student from a course.
     */
    public function removeStudentFromCourse($courseId)
    {
        // Check if student is logged in or available in session
        if (!isset($_SESSION['stuId'])) {
            echo json_encode(['status' => 'error', 'message' => 'Student not logged in.']);
            return;
        }

        $stuId = $_SESSION['stuId'];
        $isRemoved = $this->model->removeStudentFromCourse($stuId, $courseId);

        echo json_encode([
            'status' => $isRemoved ? 'success' : 'error',
            'message' => $isRemoved ? 'You have successfully left the course.' : 'Failed to leave the course. Please try again.'
        ]);
    }

    /**
     * Add a new course to the institute.
     */
    public function addCourse($courseData)
    {
        // Validate course data
        if (empty($courseData['name']) || empty($courseData['description'])) {
            echo json_encode(['status' => 'error', 'message' => 'Course name and description are required.']);
            return;
        }

        $isAdded = $this->model->addCourse($courseData);

        echo json_encode([
            'status' => $isAdded ? 'success' : 'error',
            'message' => $isAdded ? 'Course added successfully.' : 'Failed to add the course.'
        ]);
    }

    /**
     * Remove a course from the institute.
     */
    public function removeCourse($courseId)
    {
        $isRemoved = $this->model->removeCourse($courseId);

        echo json_encode([
            'status' => $isRemoved ? 'success' : 'error',
            'message' => $isRemoved ? 'Course removed successfully.' : 'Failed to remove the course.'
        ]);
    }
}
?>
