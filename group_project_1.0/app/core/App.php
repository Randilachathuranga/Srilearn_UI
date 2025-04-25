<?php

class App {
    private $controller = 'Signin'; // Default controller
    private $method = 'index';     // Default method
    private $params = [];          // Parameters passed to the method

    private function splitURL() {
        // Split the URL into parts
        $URL = $_GET['url'] ?? 'Signin'; // Default to 'Signin' if no URL is provided
        $URL = explode("/", trim($URL, "/")); // Break the URL into an array
        return $URL;
    }

    public function loadController() {
        $URL = $this->splitURL();
    
        // Attempt to load the requested controller
        $filename = "../app/controller/" . ucfirst($URL[0]) . ".php";
        if (file_exists($filename)) {
            require_once $filename;
            $this->controller = ucfirst($URL[0]);
            unset($URL[0]); // Remove the controller part from the URL
        } else {
            // Load an error controller if the requested one doesn't exist
            require_once "../app/controller/Error404.php";
            $this->controller = 'Error404';
        }
    
        // Instantiate the controller
        $controllerInstance = new $this->controller;
    
        // Attempt to load the requested method
        if (isset($URL[1]) && method_exists($controllerInstance, $URL[1])) {
            $this->method = $URL[1];
            unset($URL[1]); // Remove the method part from the URL
        }
    
        // Parameters
        $this->params = array_values($URL); // Use all remaining parts of the URL as parameters
    
        // Check if the controller is ForgotPassword with index method — bypass session check
        if ($this->controller === 'ForgotPassword' && $this->method === 'index') {
            call_user_func_array([$controllerInstance, $this->method], $this->params);
            return;
        }
        else if ($this->controller === 'ForgotPassword' && $this->method === 'sendotp') {
            call_user_func_array([$controllerInstance, $this->method], $this->params);
            return;
        }
        else if ($this->controller === 'ForgotPassword' && $this->method === 'changepword') {
            call_user_func_array([$controllerInstance, $this->method], $this->params);
            return;
        }
        
    
        // Normal access check
       if (isset($_SESSION['User_id'])) {
            call_user_func_array([$controllerInstance, $this->method], $this->params);
        } elseif ($this->controller === 'Guest') {
            call_user_func_array([$controllerInstance, $this->method], []);
        } else {
            // Redirect to Signin controller if not logged in
            require_once "../app/controller/Signin.php";
            $this->controller = 'Signin';
            $signinInstance = new $this->controller;
            $this->method = 'index';
            call_user_func_array([$signinInstance, $this->method], []);
        }
    }
    
}