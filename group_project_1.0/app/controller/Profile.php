<?php
class Profile extends Controller{

       public function index(){
        $model=new Usermodel();
        if($_SERVER['REQUEST_METHOD']=="POST"){
           
            $model->update($_SESSION['User_id'],$_POST);
            switch ($_SESSION['Role']) {
                case 'student':
                    redirect('Student');
                    break;
                case 'teacher':
                    redirect('Teacher');
                    break;
                case 'institute':
                    redirect('Institute');
                    break;
                case 'sysadmin':
                    redirect('Sysadmin');
                    break;
            }
        
       }
       $this->view('General/Myprofile/Myprofile');
    }



       public function myapi($id) {
        
        $model = new Usermodel();

        header('Content-Type: application/json');
    
        // Fetch blogs for the given user ID
        try {
            $user = $model->where(['User_id' => $id]);
            
            if ($user) {
                // Return blogs as JSON
                echo json_encode($user);
            } else {
                // Handle case where no blogs were found
                echo json_encode(['message' => 'No user found for this id.']);
            }
        } catch (Exception $e) {
            // Error handling in case of an exception
            echo json_encode(['error' => 'An error occurred while fetching user.', 'details' => $e->getMessage()]);
        }
    }
    public function myupdateapi($id) {
        // Get JSON input from the request body
        $jsonData = file_get_contents("php://input");
        $data = json_decode($jsonData, true);
    
        // Check for decoding errors
        if (json_last_error() !== JSON_ERROR_NONE) {
            echo json_encode(['error' => 'Invalid JSON input']);
            return;
        }
    
        // Proceed with updating using $id and $data
        $model = new Blogmodel();
        $updated = $model->update($id, $data, 'Blog_id');
        
        if ($updated) {
            echo json_encode(['success' => 'Blog updated successfully']);
        } else {
            echo json_encode(['error' => 'Failed to update blog']);
        }
    }

    // Upload and save image
    public function upload_image($user_id) {
        $model = new User_imagemodel();
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
            $file = $_FILES['image'];
            $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/group_project_1.0/public/uploads/img/';
            $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
            $maxFileSize = 2 * 1024 * 1024; // 2 MB
    
            if (!in_array($fileExtension, $allowedExtensions)) {
                echo json_encode(['success' => false, 'message' => 'Invalid file type.']);
                return;
            }
            if ($file['size'] > $maxFileSize) {
                echo json_encode(['success' => false, 'message' => 'File size exceeds the limit.']);
                return;
            }
            $newFileName = hash('sha256', uniqid() . microtime()) . '.' . $fileExtension;
            $uploadPath = $uploadDir . $newFileName;
            if (!file_exists($uploadDir) && !mkdir($uploadDir, 0777, true) && !is_dir($uploadDir)) {
                echo json_encode(['success' => false, 'message' => 'Failed to create directory.']);
                return;
            }
            if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
                $imagePath = '/group_project_1.0/public/uploads/img/' . $newFileName;
                if ($model->check_if_exists($user_id)) {
                    $result = $model->update($user_id, ['Src' => $imagePath]);
                } else {
                    $result = $model->insert(['User_id' => $user_id, 'Src' => $imagePath]);
                }
                if ($result) {
                    echo json_encode(['success' => true, 'newSrc' => $imagePath]);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Database operation failed.']);
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to upload image.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid request.']);
        }
    }
    

    // Fetch user image to display on profile
    public function view_image($user_id) {
        $model = new User_imagemodel();


        $image = $model->where(['User_id' => $user_id]);

        if (empty($image)) {
            http_response_code(404); // Not Found
            echo json_encode(['error' => 'No classes found for the given P_id.']);
            return;
        }

        header('Content-Type: application/json');
        echo json_encode($image, JSON_PRETTY_PRINT);
    }




}


