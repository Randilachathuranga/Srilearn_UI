<?php
    function show($stuff){
        echo"<pre>";
        print_r($stuff);
        echo"</pre>";
    }

    function redirect($path) {
        header("Location: /group_project_1.0/public/" . $path);
        die(); // Ensures termination after redirect
    }
    
    
    
   
