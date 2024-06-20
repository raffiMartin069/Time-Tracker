<?php

/*
 * This file contains configuration settings for the application. 
 * If there is a necessity to change the configuration, this is the place to do it.
 * Best practice is to create functions that will define the configuration settings.
 * This will make it easier to manage the settings.
 */
function defineRoot() {
    if($_SERVER['SERVER_NAME'] == 'localhost') {
        // database configuration
        $config = simplexml_load_file('../App.config');
        define('DBNAME', $config->database->dbname ?? null);
        define('DBHOST', $config->database->host ?? null);
        define('DBUSER', $config->database->username ?? null);
        define('DBKEY', $config->database->password ?? null);
        define('PORT', $config->database->port ?? null);
        define('ROOT', 'http://localhost/public/');
        define('APP', 'http://localhost/app/');
    } else {
        $config = simplexml_load_file('../App.config');
        define('DBNAME', $config->database->dbname ?? null);
        define('DBHOST', $config->database->host ?? null);
        define('DBUSER', $config->database->username ?? null);
        define('DBKEY', $config->database->password ?? null);
        define('PORT', $config->database->port ?? null);
        define('ROOT', 'https://wheretomed.azurewebsites.net/public/');
        define('APP', 'https://wheretomed.azurewebsites.net/app/');
    }
}


function standardErrors() 
{
    define("DEFAULT_ERR", "Something went wrong. Please try again later");
    define("SERVER_MAINTENANCE", "Server is currently under maintenance. Please try again later");
}

/*
 * Define the application settings
 * We can use this for debugging purposes 
 */
function TestingDebugger() {
    define('DEBUG', true);
}

/*
 * Define the application information
 */
function AppInformation() {    
    define('APPNAME', 'PHP-PDO');
    define('APPDESC', 'A simple PHP PDO framework');
    define('APPVERSION', '1.0.0');
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


standardErrors();
TestingDebugger();
AppInformation();
defineRoot();
