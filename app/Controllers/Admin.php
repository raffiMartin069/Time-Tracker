<?php

require_once "../app/Core/Controller.php";

class Admin extends Controller {

    public function index() {
    
        $this->view('Shared/sidenav/Admin');
    
    }
}