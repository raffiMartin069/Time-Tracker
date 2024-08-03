<?php

class Controller {
    public function View($view, $data = []) {
        
        if(!empty($data)){
            extract($data);
        }
        
        $filename = "../app/Views/".$view.".view.php";
        if (file_exists($filename)) {
            require_once $filename;
        } else {
            $filename = "../app/Views/Shared/404.view.php";
            require_once $filename;
        }
    }

    public function checkAdmin() {
        // Start session if not already started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    
        // Check if the role is set in the session
        if (isset($_SESSION["role"])) {
            // Redirect if the role is not admin
            if ($_SESSION["role"] !== "admin") {
                header('Location: /Time-Tracker/public/employee');
                exit(); // Ensure no further code is executed
            }
        } else {
            // Handle the case where "role" is not set
            header('Location: /Time-Tracker/public/login'); // Redirect to login or appropriate page
            exit();
        }
    }
    

    public function checkEmployee() {

        // Start session if not already started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    
        // Check if the role is set in the session
        if (isset($_SESSION["role"])) {
            // Redirect if the role is not admin
            if ($_SESSION["role"] !== "employee") {
                header('Location: /Time-Tracker/public/admin');
                exit(); // Ensure no further code is executed
            }
        } else {
            // Handle the case where "role" is not set
            header('Location: /Time-Tracker/public/login'); // Redirect to login or appropriate page
            exit();
        }
    }

    public function checkLoggedIn() {
        if (!isset($_SESSION["userId"])) {
            header('Location: /Time-Tracker/public');
            exit();
        }
    }
}