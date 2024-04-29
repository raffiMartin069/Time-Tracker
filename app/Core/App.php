<?php
class App {
    private $controller = "Login";
    private $method = "index";
    // Redirect user to home page when nothing else is served.
    private function splitURL() {
        $URL = $_GET['url'] ?? 'Login';
        $URL = explode("/", trim($URL,"/"));
        return $URL;
    }
    
    public function loadController() {
        $URL = $this->splitURL();

        // Check if the controller exists.
        // If the controller does not exist, call the default controller.
        $filename = "../app/Controllers/".ucfirst($URL[0]).".php";
        if (file_exists($filename)) {
            require_once $filename;
            $this->controller = ucfirst($URL[0]);
            unset($URL[0]);
        } else {
            $filename = "../app/Controllers/_404.php";
            require_once $filename;
            $this->controller = "PageNotFound";
        }

        require_once "../app/Controllers/Login.php";
        $controller = new $this->controller;

        // Check if the method exists in the controller.
        // If the method does not exist, call the default method.
        if(!empty($URL[1])) {
            if(method_exists($controller, $URL[1])) {
                $this->method = $URL[1];
                unset($URL[1]);
            } else {
                $this->method = "index";
            }
        }

        call_user_func_array([$controller, $this->method], $URL);
    }
}