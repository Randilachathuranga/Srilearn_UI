<?php

class Learning_mat extends Controller
{
    public function index()
    {
        $model = new Learning_matmodel();
        $this->view('TeacherView/Options/UploadMat/UploadMat');
    }

    // View Materials for a Class
    public function viewMat($Class_id)
    {
        $model = new Learning_matmodel();

        header('Content-Type: application/json');
        try {
            $materials = $model->where(['Class_id' => $Class_id]);

            if ($materials) {
                echo json_encode($materials);
            } else {
                echo json_encode(['message' => 'No materials found for this class ID.']);
            }
        } catch (Exception $e) {
            echo json_encode(['error' => 'An error occurred while fetching materials.', 'details' => $e->getMessage()]);
        }
    }
    

    // Insert Learning Material with PDF upload
    public function insertLearningMat($classId)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Directory to save the uploaded materials
            $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/group_project_1.0/public/uploads/materials/';
            
            // Ensure the directory exists
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
    
            if (isset($_FILES['pdf']) && $_FILES['pdf']['error'] === UPLOAD_ERR_OK) {
                $fileTmpPath = $_FILES['pdf']['tmp_name'];
                $fileName = basename($_FILES['pdf']['name']);
                $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    
                // Check if the uploaded file is a PDF
                if ($fileExt === 'pdf') {
                    // Create a unique file name
                    $newFileName = uniqid() . '-' . $fileName;
                    $destPath = $uploadDir . $newFileName; // File system path for saving
                    $fileUrl = 'http://localhost/group_project_1.0/public/uploads/materials/' . $newFileName; // URL for accessing the file
    
                    // Move the uploaded file to the destination directory
                    if (move_uploaded_file($fileTmpPath, $destPath)) {
                        // Prepare data for insertion
                        $data = [
                            'Class_id'   => $classId,
                            'topic'      => $_POST['topic'],
                            'sub_topic'  => $_POST['sub_topic'],
                            'Description' => $_POST['Description'],
                            'Url'        => $fileUrl, // Use URL to access the file
                            'Date'       => date('Y-m-d H:i:s') 
                        ];
    
                        // Insert data into the database using the model
                        $model = new Learning_matmodel();
                        $model->insert($data);
    
                        // Respond with success message and data
                        echo json_encode(['message' => 'Learning material uploaded successfully.', 'material' => $data]);
                    } else {
                        echo json_encode(['error' => 'Failed to move the uploaded file.']);
                    }
                } else {
                    echo json_encode(['error' => 'Only PDF files are allowed.']);
                }
            } else {
                echo json_encode(['error' => 'No file uploaded or an error occurred during the upload.']);
            }
        } else {
            echo json_encode(['error' => 'Invalid request method.']);
        }
    }
    

    //delete mat
    public function deleteMat($Mat_id) {
        $model = new Learning_matmodel();
        $model->delete($Mat_id, 'Mat_id');
        echo json_encode(['message' => 'Mat deleted successfully']);
    }

    // Update Learning Material
    public function updateMat($Mat_id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/group_project_1.0/public/uploads/materials/';
            
            // Ensure the directory exists
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
    
            $model = new Learning_matmodel();
            $existingMat = $model->where(['Mat_id' => $Mat_id]);
    
            if (!$existingMat) {
                echo json_encode(['error' => 'Material not found.']);
                return;
            }
    
            // Prepare update data with existing values as defaults
            $updateData = [
                'topic'       => $_POST['topic'] ?? $existingMat['topic'],
                'sub_topic'   => $_POST['sub_topic'] ?? $existingMat['sub_topic'],
                'Description' => $_POST['Description'] ?? $existingMat['Description'],
                'Date'        => date('Y-m-d H:i:s'),
            ];
    
            // Handle PDF upload if a new file is provided
            if (isset($_FILES['pdf']) && $_FILES['pdf']['error'] === UPLOAD_ERR_OK) {
                $fileTmpPath = $_FILES['pdf']['tmp_name'];
                $fileName = basename($_FILES['pdf']['name']);
                $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    
                // Validate file type
                if ($fileExt !== 'pdf') {
                    echo json_encode(['error' => 'Only PDF files are allowed.']);
                    return;
                }
    
                // Create a unique filename
                $newFileName = uniqid() . '-' . $fileName;
                $destPath = $uploadDir . $newFileName;
                $fileUrl = 'http://localhost/group_project_1.0/public/uploads/materials/' . $newFileName;
    
                // Attempt to move the uploaded file
                if (!move_uploaded_file($fileTmpPath, $destPath)) {
                    echo json_encode(['error' => 'Failed to upload the new file.']);
                    return;
                }
    
                // Remove the old file if it exists
                if (!empty($existingMat['Url'])) {
                    $oldFilePath = $_SERVER['DOCUMENT_ROOT'] . parse_url($existingMat['Url'], PHP_URL_PATH);
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath);
                    }
                }
    
                // Update URL with the new file
                $updateData['Url'] = $fileUrl;
            }
    
            // Perform the update
            if ($model->update($Mat_id, $updateData, 'Mat_id')) {
                echo json_encode([
                    'message' => 'Material updated successfully.', 
                    'material' => $updateData
                ]);
            } else {
                echo json_encode(['error' => 'Failed to update the material.']);
            }
        } else {
            echo json_encode(['error' => 'Invalid request method.']);
        }
    }

public function checkenrolldate($User_id, $Class_id) {
    $model = new Enrollmodel();
    header('Content-Type: application/json');
    $tables = [
        'user','enrollment'
    ];
    $joincondition = [
        'user.User_id = enrollment.Stu_id'
    ];
    $data = [
        'user.User_id' => $User_id,
        'enrollment.Class_id' => $Class_id
    ];
    $result = $model->InnerJoinwhereMultiple($tables, $joincondition, $data, []);
    if ($result) {
        echo json_encode($result);
    } else {
        echo json_encode(['message' => 'No materials found for this class ID.']);
    }
}

public function requestOldMat($User_id,$Class_id) {
    $model = new Request_oldmat();
    header('Content-Type: application/json');
    $data = [
        'Stu_id' => $User_id,
        'Class_id' => $Class_id,
        'Status' => '0'
    ];
    $result = $model->insert($data);
    if ($result) {
        echo json_encode($result);
    } else {
        echo json_encode(['message' => 'No materials found for this class ID.']);
    }
}

public function viewrequest($User_id,$Class_id){
    $model = new Request_oldmat();
    header('Content-Type: application/json');
    $result = $model->where(['Stu_id' => $User_id, 'Class_id' => $Class_id]);
    if ($result) {
        echo json_encode($result);
    } else {
        echo json_encode(['message' => 'No materials found for this class ID.']);
    }
}

public function allrequests($Class_id)
    {
        $model = new Request_oldmat();
        header('Content-Type: application/json');
        try {

            $tables = [
                'user', 'request_oldmat'
            ];

            $joincondition = [
                'user.User_id = request_oldmat.Stu_id'
            ];
            $data = [
                'request_oldmat.Class_id' => $Class_id,
            ];

            $materials = $model->InnerJoinwhereMultiple($tables, $joincondition, $data, []);

            if ($materials) {
                echo json_encode($materials);
            } else {
                echo json_encode(['message' => 'No materials found for this class ID.']);
            }
        } catch (Exception $e) {
            echo json_encode(['error' => 'An error occurred while fetching materials.', 'details' => $e->getMessage()]);
        }
    }

public function acceptrequest($request_id) {
    $model = new Request_oldmat();
    header('Content-Type: application/json');
    $data = [
        'Status' => '1'
    ];
    $result = $model->update($request_id, $data, 'ID');
    if ($result) {
        echo json_encode(['success' => 'Request accepted successfully.']);
    } else {
        echo json_encode(['message' => 'Failed to accept the request.']);
    }
}

}
?>


