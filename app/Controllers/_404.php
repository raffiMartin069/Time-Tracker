<?php

require_once "../app/Core/Controller.php";

class PageNotFound extends Controller {
    public function Index() {
        $this->view("PageNotFound");
    }
}