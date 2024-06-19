<?php

spl_autoload_register(function($class) {
    require $filename = "../app/Models/".ucfirst($class).".php";
});

function requirements() {
    require 'Config.php';
    require 'Functions.php';
    require 'Database.php';
    require 'Model.php';
    require 'Controller.php';
    require 'App.php';
    require 'SQLoader.php';
    require __DIR__.'/../Utilities/ExceptionHandler.php';
    require __DIR__.'/../Utilities/Sanitation.php';
    
}

requirements();
