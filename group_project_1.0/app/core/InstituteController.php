<?php
class InstituteController {
    /**
     * Load an institute-related view with optional data.
     *
     * @param string $name - The name of the view.
     * @param array $data - Data to pass to the view.
     */
    public function InstituteView($name, $data = []) {
        // Sanitize the name to prevent directory traversal attacks
        $name = basename($name);  // Prevent directory traversal
        
        if (!empty($data)) {
            extract($data); // Extract data to variables
        }

        // Define the directory for institute views
        $filename = "../app/views/InstituteView/$name/$name.view.php";

        // Check if the view file exists
        if (file_exists($filename)) {
            require $filename; // Load the view if it exists
        } else {
            // Log the error (optional)
            error_log("View file not found: $filename");

            // Load an error view if the file doesn't exist
            $filename = "../app/views/Error404.view.php";
            require $filename;
        }
    }
}
?>
