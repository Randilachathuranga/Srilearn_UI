<?php

Class Blog extends Controller{
    public function index(){
        $this->view('/Blogs/Blogs');   
    }

    public function api() {
        $model = new Blogmodel();
        header('Content-Type: application/json');
        
        // Fetch all blogs
        $blogs = $model->findall();
        
        // Loop through each blog post to fetch the associated user
        foreach ($blogs as $blog) {
            $user = $model->get_user(['User_id'=>$blog->User_id]); // Fetch user data based on user_id
            $blog->user = $user; // Add the user data to the blog post
        }
        
        // Return the blogs with user data as a JSON response
        echo json_encode($blogs);
    }
    public function myapi($id) {
        
        $model = new Blogmodel();

        header('Content-Type: application/json');
    
        // Fetch blogs for the given user ID
        try {
            $blogs = $model->where(['User_id' => $id]);
            
            if ($blogs) {
                // Return blogs as JSON
                echo json_encode($blogs);
            } else {
                // Handle case where no blogs were found
                echo json_encode(['message' => 'No blogs found for this user.']);
            }
        } catch (Exception $e) {
            // Error handling in case of an exception
            echo json_encode(['error' => 'An error occurred while fetching blogs.', 'details' => $e->getMessage()]);
        }
    }

    public function mydeleteapi($id) {
        
        $model = new Blogmodel();
        header('Content-Type: application/json');
    
        // Fetch blogs for the given user ID
        try {
            $blogs = $model->delete($id,'Blog_id');
            
            if ($blogs) {
                // Return blogs as JSON
                echo json_encode($blogs);
            } else {
                // Handle case where no blogs were found
                echo json_encode(['message' => 'No blogs found for this user.']);
            }
        } catch (Exception $e) {
            // Error handling in case of an exception
            echo json_encode(['error' => 'An error occurred while fetching blogs.', 'details' => $e->getMessage()]);
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
    
    
    
    public function post() {
        $model = new Blogmodel();
        header('Content-Type: application/json');
        
        // Get the raw POST data from the request body (JSON)
        $inputData = json_decode(file_get_contents('php://input'), true); // Decode the incoming JSON
        $inputData['User_id']=$_SESSION['User_id'];
        // Check if the required fields are present in the data
        if (isset($inputData['Title'], $inputData['Content'], $inputData['Post_date'],  $inputData['User_id'])) {
            try {
                // Call the model's insert method with the decoded data
                $blogs = $model->insert($inputData);
    
                if ($blogs) {
                    // Return the inserted blog data as JSON
                    echo json_encode(['message' => 'Blog created successfully', 'data' => $blogs]);
                } else {
                    // If no data was inserted, return an error message
                    echo json_encode(['message' => 'Could not insert the blog']);
                }
            } catch (Exception $e) {
                // Handle error and return an error response
                echo json_encode(['error' => 'An error occurred while creating the blog.', 'details' => $e->getMessage()]);
            }
        } else {
            // If required fields are missing, return an error message
            echo json_encode(['error' => 'Missing required fields: Title, Content, or Post_date']);
        }
    }
    

    public function myblogs(){
        checkloginstatus();
        $this->view('Myblogs');
    }




}
