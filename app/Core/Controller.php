<?php

class Controller {
    public function View($view) {
        $filename = "../app/Views/".$view.".view.php";
        if (file_exists($filename)) {
            require_once $filename;
        } else {
            $filename = "../app/Views/Shared/404.view.php";
            require_once $filename;
        }
    }
}