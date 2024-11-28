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

    
    function checkAccess($requiredRole) {
        if (!isset($_SESSION['User_id']) || $_SESSION['Role'] !== $requiredRole) {
           redirect('Error404');
           exit();
        }
        else{
        return true;
        }
    }

    function checkloginstatus(){
        if(!isset($_SESSION['User_id'])){
            redirect('Error404');
            exit();
        }
        else{
            return true;
        }

    }
  
    
   
