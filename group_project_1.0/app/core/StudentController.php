<?php

class StudentController
{
    /**
     * Load a student view with optional data.
     *
     * @param string $name - The name of the view.
     * @param array $data - Data to pass to the view.
     */
    public function Studentview($name, $data = [])
    {
        if (!empty($data)) {
            extract($data); // Extract data to variables
        }

        // Define the directory for student views
        $filename = "../app/views/StudentView/$name/$name.view.php";

        // Check if the view file exists
        if (file_exists($filename)) {
            require $filename; // Load the view if it exists
        } else {
            // Load an error view if the file doesn't exist
            $filename = "../app/views/Error404.view.php";
            require $filename;
        }
    }

    public function view($name,$data=[])
    {
        if(!empty($data))
        extract($data);
        $filename="../app/views/".$name.".view.php";
        if(file_exists($filename)){
            require $filename;
        }
        else{
            $filename="../app/views/Error404.view.php";
            require $filename;
        }

    }
}

