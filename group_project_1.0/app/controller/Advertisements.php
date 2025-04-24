<?php

class Advertisements extends Controller {

  
    public function index(){
        $this->view('General/Advertisements/advertisements');
    }

    //view all adds
    public function viewall() {
        header('Content-Type: application/json');
        $model = new AdvertisementModel();
        $allads = $model->findall();
        echo json_encode($allads);
    }

    //view my all adds
    public function myads() {
        header('Content-Type: application/json');
        $id=$_SESSION['User_id'];
        $model = new AdvertisementModel();
        $allads = $model->where(['User_id'=>$id]);
        echo json_encode($allads);
    }

    //my adds page
    public function viewmyads(){
        $this->view('General/Advertisements/myadvertisements');
    }


    // API: Delete specific ad
    public function deleteapi($id) {
        $model = new AdvertisementModel;
        $deleteadd = $model->delete($id,'Ad_id');
        echo json_encode($deleteadd);
    }

  //create a add
  public function post() {
    $model = new AdvertisementModel();
    $imagemodel = new AdvertisementImageModel(); // Fixed model reference
    
    // Handle both JSON and form data
    if ($_SERVER['CONTENT_TYPE'] === 'application/json') {
        // Handle JSON data (fallback)
        $inputData = json_decode(file_get_contents('php://input'), true);
    } else {
        // Handle form data (with file uploads)
        $inputData = $_POST;
    }
    
    $data = [
        'User_id' => $inputData['User_id'],
        'Title' => $inputData['Title'],
        'Content' => $inputData['Content'],
        'Post_date' => $inputData['Post_date'],
        'Iseducation' => $inputData['Iseducation'],
        'Subject' => $inputData['Subject']
    ];
    
    try {
        // Insert ad data
        $insertResult = $model->insert($data);
        
        if (!$insertResult) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Failed to insert advertisement data']);
            return;
        }

        // Get the newly inserted Ad_id
        $Ad_id = $model->last_InsertId();
        
        // Check if image file is uploaded
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $file = $_FILES['image'];
            $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/group_project_1.0/public/uploads/Adimg/';
            $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
            $maxFileSize = 2 * 1024 * 1024; // 2 MB
    
            if (!in_array($fileExtension, $allowedExtensions)) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Invalid file type.']);
                return;
            }
            
            if ($file['size'] > $maxFileSize) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'File size exceeds the limit.']);
                return;
            }
            
            $newFileName = hash('sha256', uniqid() . microtime()) . '.' . $fileExtension;
            $uploadPath = $uploadDir . $newFileName;
            
            // Create directory if it doesn't exist
            if (!file_exists($uploadDir) && !mkdir($uploadDir, 0777, true) && !is_dir($uploadDir)) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Failed to create directory.']);
                return;
            }
            
            if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
                $imagePath = '/group_project_1.0/public/uploads/Adimg/' . $newFileName;

                // Insert image information into advertisement_image table
                $imageResult = $imagemodel->insert(['Ad_id' => $Ad_id, 'Src' => $imagePath]);

                if (!$imageResult) {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => false, 'message' => 'Failed to save image information.']);
                    return;
                }
            } else {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Failed to upload image.']);
                return;
            }
        }

        // Return success response
        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'message' => 'Advertisement created successfully', 'Ad_id' => $Ad_id]);
        
    } catch (Exception $e) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'An error occurred while creating the advertisement.', 'details' => $e->getMessage()]);
    }
}
    
    // API: Update specific ad
    public function myupdateapi($id) {
        checkloginstatus();
    
        // Get JSON input from the request body
        $jsonData = file_get_contents("php://input");
        $data = json_decode($jsonData, true); // decode as associative array
    
        // Check for decoding errors
        if (json_last_error() !== JSON_ERROR_NONE) {
            echo json_encode(['error' => 'Invalid JSON input']);
            return;
        }
    
        // Prepare data for update
        $pass_data = [
            'Title'       => $data['Title'] ?? null,
            'Content'     => $data['Content'] ?? null,
            'Post_date'   => $data['Post_date'] ?? null,
            'Iseducation' => $data['Iseducation'] ?? '0',
            'Subject'     => $data['Subject'] ?? null
        ];
    
        // Proceed with updating
        $model = new AdvertisementModel();
        $updated = $model->update($id, $pass_data, 'Ad_id');
    
        if ($updated) {
            echo json_encode(['success' => 'Advertisement updated successfully']);
        } else {
            echo json_encode(['error' => 'Failed to update advertisement']);
        }
    }

    
    // Fetch user image to display on profile
    public function view_image($Ad_id) {
        $model = new AdvertisementImageModel();
        $image = $model->where(['Ad_id' => $Ad_id]);
        if (empty($image)) {
            http_response_code(404); // Not Found
            echo json_encode(['error' => 'No classes found for the given P_id.']);
            return;
        }
        header('Content-Type: application/json');
        echo json_encode($image, JSON_PRETTY_PRINT);
    }

   

//update image
    public function update_image($Ad_id) {
        $model = new AdvertisementImageModel();
        $file = $_FILES['image'];
    
        $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/group_project_1.0/public/uploads/Adimg/';
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        $maxFileSize = 2 * 1024 * 1024; // 2 MB
        // Validate file upload
        if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK) {
            $this->jsonResponse(false, 'No image uploaded or upload error occurred.');
            return;
        }
        $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    
        if (!in_array($fileExtension, $allowedExtensions)) {
            $this->jsonResponse(false, 'Invalid file type. Only JPG, PNG, and GIF are allowed.');
            return;
        }
    
        if ($file['size'] > $maxFileSize) {
            $this->jsonResponse(false, 'File size exceeds the 2MB limit.');
            return;
        }
    
        // Generate a new unique filename
        $newFileName = hash('sha256', uniqid() . microtime()) . '.' . $fileExtension;
        $uploadPath = $uploadDir . $newFileName;
        $imagePath = '/group_project_1.0/public/uploads/Adimg/' . $newFileName;
    
        // Create directory if it doesn't exist
        if (!file_exists($uploadDir)) {
            if (!mkdir($uploadDir, 0777, true)) {
                $this->jsonResponse(false, 'Failed to create directory for uploads.');
                return;
            }
        }
    
        // Move uploaded file to the target directory
        if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
            // Update DB with new image path
            $imageResult = $model->update($Ad_id, ['Src' => $imagePath], 'Ad_id');
    
            if ($imageResult) {
                $this->jsonResponse(true, 'Image updated successfully.');
            } else {
                $this->jsonResponse(false, 'Failed to update image information in the database.');
            }
        } else {
            $this->jsonResponse(false, 'Failed to move uploaded file.');
        }
    }
    
    // Helper method for consistent JSON responses
    private function jsonResponse($success, $message) {
        header('Content-Type: application/json');
        echo json_encode(['success' => $success, 'message' => $message]);
    }
    
}