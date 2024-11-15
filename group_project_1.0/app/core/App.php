<?php

class App {
    private $controller = 'Home';
    private $method = 'index';
    private $params = [];

    private function splitURL() {
        $URL = $_GET['url'] ?? 'home';
        $URL = explode("/", trim($URL,"/"));
        return $URL;
    }

    public function loadController() {
        $URL = $this->splitURL();
        
        // Controller
        $filename = "../app/controller/" . ucfirst($URL[0]) . ".php";
        if (file_exists($filename)) {
            require $filename;
            $this->controller = ucfirst($URL[0]);
            unset($URL[0]);
        } else {
            require "../app/controller/Error404.php";
            $this->controller = 'Error404';
        }
    
        // Method
        if (isset($URL[1])) {
            if (method_exists($this->controller, $URL[1])) {
                $this->method = $URL[1];
                unset($URL[1]);
            }
        }
    
        // Parameters
        $this->params = array_values($URL);  // Changed to ensure all params are passed correctly
    
        // Create controller instance and call the method with parameters
        $controllerInstance = new $this->controller;
        call_user_func_array([$controllerInstance, $this->method], $this->params);
    }
    
}

