<?php

class App {
    private $controller = 'signin';
    private $method = 'index';
    private $params = [];

    private function splitURL() {
        // Split the URL into parts
        $URL = $_GET['url'] ?? 'signin';
        $URL = explode("/", trim($URL, "/"));
        return $URL;
    }

    public function loadController() {
        $URL = $this->splitURL();

        // Controller
        $filename = "../app/controller/" . ucfirst($URL[0]) . ".php";
        if (file_exists($filename)) {
            require $filename;
            $this->controller = ucfirst($URL[0]);
            unset($URL[0]); // Remove the controller part from the URL
        } else {
            // Load the error controller if the requested one doesn't exist
            require "../app/controller/Error404.php";
            $this->controller = 'Error404';
        }

        // Create an instance of the controller
        $controllerInstance = new $this->controller;

        // Method
        if (isset($URL[1])) {
            if (method_exists($controllerInstance, $URL[1])) {
                $this->method = $URL[1];
                unset($URL[1]); // Remove the method part from the URL
            }
        }

        // Parameters
        $this->params = array_values($URL); // Use all remaining parts of the URL as parameters

        // Call the method with the parameters
        call_user_func_array([$controllerInstance, $this->method], $this->params);
    }
}


