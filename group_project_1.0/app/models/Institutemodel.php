<?php

class InstituteModel {
    use Model; // Use the Model trait to access its methods

    protected $table = 'instituteteacher_class'; // The name of the table

    // Function to remove a teacher from the instituteteacher_class table
    public function removeTeacher($teacherId) {
        // Assuming teacherId corresponds to the N_id
        // Perform the delete operation using the delete method from the Model trait
        try {
            return $this->delete($teacherId, 'N_id');
        } catch (Exception $e) {
            // Handle error and return false
            return false;
        }
    }
}
