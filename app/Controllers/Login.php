<?php

require_once "../app/Core/Controller.php";

class Login extends Controller {

    public function index() {
    
        $this->view('Login/Login');
    
    }
}