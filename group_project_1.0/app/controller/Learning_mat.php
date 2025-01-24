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
            $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/group_project_1.0/public/uploads/materials/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            if (isset($_FILES['pdf']) && $_FILES['pdf']['error'] === UPLOAD_ERR_OK) {
                $fileTmpPath = $_FILES['pdf']['tmp_name'];
                $fileName = basename($_FILES['pdf']['name']);
                $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

                if ($fileExt === 'pdf') {
                    $newFileName = uniqid() . '-' . $fileName;
                    $destPath = $uploadDir . $newFileName;

                    if (move_uploaded_file($fileTmpPath, $destPath)) {
                        $data = [
                            'Class_id'   => $classId,
                            'topic'      => $_POST['topic'],
                            'sub_topic'  => $_POST['sub_topic'],
                            'Description' => $_POST['Description'],
                            'Url'        => $destPath, 
                            'Date'       => date('Y-m-d H:i:s') 
                        ];

                        $model = new Learning_matmodel();
                        $model->insert($data);

                        echo json_encode(['message' => 'Learning material uploaded successfully.', 'material' => $data]);
                    } else {
                        echo json_encode(['error' => 'Failed to move uploaded file.']);
                    }
                } else {
                    echo json_encode(['error' => 'Only PDF files are allowed.']);
                }
            } else {
                echo json_encode(['error' => 'No file uploaded or an error occurred during upload.']);
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

}
?>


