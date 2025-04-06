<?php

Class Blog extends Controller{
    public function index(){
        $this->view('General/Blogs/Blogs');   
    }

    public function api() {
        $model = new Blogmodel();
        header('Content-Type: application/json');
        
        // Pagination and search parameters
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';
        $blogsPerPage = 6;
        $offset = ($page - 1) * $blogsPerPage;
    
        // Fetch total blog count with search filter
        $totalBlogs = $model->getTotalBlogCount($search);
        $totalPages = ceil($totalBlogs / $blogsPerPage);
    
        // Fetch paginated blogs with search filter
        $blogs = $model->findPaginatedBlogs($blogsPerPage, $offset, $search);
        
        // Loop through each blog post to fetch the associated user
        foreach ($blogs as $blog) {
            $user = $model->get_user(['User_id' => $blog->User_id]); 
            $blog->user = $user;
        }
        
        // Prepare response with pagination info
        $response = [
            'blogs' => $blogs,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'totalBlogs' => $totalBlogs,
            'searchTerm' => $search
        ];
        
        // Return the blogs with user data as a JSON response
        echo json_encode($response);
    }


    public function myapi($id) {
        checkloginstatus();
        
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
        checkloginstatus();
        
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
        checkloginstatus();
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
        checkloginstatus();
        $model = new Blogmodel();
        header('Content-Type: application/json');
        
        $inputData = json_decode(file_get_contents('php://input'), true); // Decode the incoming JSON
        $inputData['User_id']=$_SESSION['User_id'];
        if (isset($inputData['Title'], $inputData['Content'], $inputData['Post_date'],  $inputData['User_id'])) {
            try {
                $blogs = $model->insert($inputData);
    
                if ($blogs) {
                    echo json_encode(['message' => 'Blog created successfully', 'data' => $blogs]);
                } else {
                    echo json_encode(['message' => 'Could not insert the blog']);
                }
            } catch (Exception $e) {
                echo json_encode(['error' => 'An error occurred while creating the blog.', 'details' => $e->getMessage()]);
            }
        } else {
            echo json_encode(['error' => 'Missing required fields: Title, Content, or Post_date']);
        }
    }
    

    public function myblogs(){
        checkloginstatus();
        $this->view('General/Blogs/Myblogs');
    }




}
