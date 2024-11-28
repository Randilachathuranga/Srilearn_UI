<?php

class StudentModel
{
    use Model;

    // Table definitions
    public $classTable = 'class'; // Class table
    public $enrollmentTable = 'enrollment'; // Enrollment table

    // Allowed columns
    public $allowedClassColumns = ['Subject', 'Grade', 'Max_std', 'fee'];
    public $allowedEnrollmentColumns = ['Enrollment_id', 'Stu_id', 'Class_id', 'Date', 'Isdiscountavail'];

    /**
     * Fetch classes based on subject and grade.
     *
     * @param string $subject - The subject to filter classes.
     * @param string $grade - The grade to filter classes.
     * @return array - List of matching classes.
     */
    public function getClassesForStudent($subject, $grade)
    {
        $query = "SELECT * FROM {$this->classTable} WHERE Subject = :Subject AND Grade = :Grade";
        $params = [
            'Subject' => $subject,
            'Grade' => $grade
        ];
        return $this->query($query, $params);
    }

    /**
     * Enroll a student in a class.
     *
     * @param int $stuId - The student ID.
     * @param int $classId - The class ID.
     * @param int $isDiscountAvail - Whether the student has a discount (1 for yes, 0 for no).
     * @return bool - True if the enrollment is successful, false otherwise.
     */
    public function enrollStudent($stuId, $classId, $isDiscountAvail = 0)
    {
        $query = "INSERT INTO {$this->enrollmentTable} (Stu_id, Class_id, Date, Isdiscountavail) VALUES (:Stu_id, :Class_id, :Date, :Isdiscountavail)";
        $params = [
            'Stu_id' => $stuId,
            'Class_id' => $classId,
            'Date' => date('Y-m-d'), // Current date
            'Isdiscountavail' => $isDiscountAvail
        ];
        return $this->query($query, $params);
    }

    /**
     * Remove a student's enrollment from a class.
     *
     * @param int $stuId - The student ID.
     * @param int $classId - The class ID.
     * @return bool - True if the removal is successful, false otherwise.
     */
    public function removeEnrollment($stuId, $classId)
    {
        $query = "DELETE FROM {$this->enrollmentTable} WHERE Stu_id = :Stu_id AND Class_id = :Class_id";
        $params = [
            'Stu_id' => $stuId,
            'Class_id' => $classId
        ];
        return $this->query($query, $params);
    }
}
