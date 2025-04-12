<?php

class Advertisements extends Controller {

    // Assuming you have a table named 'advertisements'
    protected $table = 'advertisements';

    // View all advertisements
    public function index() {
        // Fetch all ads using the 'findall' method from the Model trait
        $model = new Advertisment(); // Assuming the model is instantiated here
        $ads = $model->findall();  // Fetch all ads

        // Send the ads data to the view
        $this->view('General/Advertisements/advertisements');
    }

    // Display form for adding new advertisements (for teacher or institute roles)
    public function form() {
        if ($_SESSION['Role'] === 'teacher' || $_SESSION['Role'] === 'institute') {
            // Display form for creating an advertisement
            $this->view('General/Advertisements/adform');
        } else {
            // Unauthorized access, show error page
            $this->view('Error');
        }
    }

    // View advertisements (JSON format)
    public function viewadd() {
        $model = new Advertisment();
        header('Content-Type: application/json');
        
        try {
            // Fetch all ads from the model
            $ads = $model->findall();

            // Return the ads as a JSON response
            echo json_encode($ads ? $ads : ['message' => 'No advertisements found.']);
        } catch (Exception $e) {
            // Handle any errors during fetching
            echo json_encode(['error' => 'An error occurred while fetching advertisements.', 'details' => $e->getMessage()]);
        }
    }

    // Insert a new advertisement
    public function insertadd() {
        if ($_SESSION['Role'] !== 'teacher' && $_SESSION['Role'] !== 'institute') {
            // Unauthorized, show error page
            $this->view('Error');
            return;
        }

        // Get JSON data from the request body
        $jsonData = file_get_contents("php://input");
        $data = json_decode($jsonData, true);

        // Check for decoding errors
        if (json_last_error() !== JSON_ERROR_NONE) {
            echo json_encode(['error' => 'Invalid JSON input']);
            return;
        }

        // Proceed with inserting the new advertisement
        $model = new Advertisment();
        
        // Validate required fields (e.g., 'title' and 'description')
        if (isset($data['title']) && isset($data['description'])) {
            // Use insert method from the Model trait to insert data
            $inserted = $model->insert($data);

            if ($inserted) {
                echo json_encode(['success' => 'Advertisement inserted successfully']);
            } else {
                echo json_encode(['error' => 'Failed to insert advertisement']);
            }
        } else {
            echo json_encode(['error' => 'Missing required fields']);
        }
    }

    // Update an existing advertisement
    public function updateadd($id) {
        checkloginstatus();  // Ensure the user is logged in

        // Get JSON data from the request body
        $jsonData = file_get_contents("php://input");
        $data = json_decode($jsonData, true);

        // Check for decoding errors
        if (json_last_error() !== JSON_ERROR_NONE) {
            echo json_encode(['error' => 'Invalid JSON input']);
            return;
        }

        // Proceed with updating the advertisement
        $model = new Advertisment();
        
        // Use update method from the Model trait to update data
        $updated = $model->update($id, $data, 'add_id');  // Assuming 'add_id' is the primary key column for advertisements

        if ($updated) {
            echo json_encode(['success' => 'Advertisement updated successfully']);
        } else {
            echo json_encode(['error' => 'Failed to update advertisement']);
        }
    }

    // Delete an advertisement (optional)
    public function deleteadd($id) {
        // Ensure the user is authorized to delete
        checkloginstatus();

        $model = new Advertisment();
        
        // Use delete method from the Model trait to remove the ad
        $deleted = $model->delete($id, 'add_id');  // Assuming 'add_id' is the primary key column for advertisements

        if ($deleted) {
            echo json_encode(['success' => 'Advertisement deleted successfully']);
        } else {
            echo json_encode(['error' => 'Failed to delete advertisement']);
        }
    }
}
