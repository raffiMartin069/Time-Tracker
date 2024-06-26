<?php
require_once __DIR__ . "/../../public/vendor/autoload.php";
/*
 * This file contains configuration settings for the application. 
 * If there is a necessity to change the configuration, this is the place to do it.
 * Best practice is to create functions that will define the configuration settings.
 * This will make it easier to manage the settings.
 */
function defineRoot() {
    if($_SERVER['SERVER_NAME'] == 'localhost') {
        // database configuration
        // $config = simplexml_load_file('../App.config');
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
        // $dotenv->safeLoad();
        $dotenv->load();
        define('DBNAME', $_ENV['DB_NAME'] ?? null);
        define('DBHOST', $_ENV['DB_HOST'] ?? null);
        define('DBUSER', $_ENV['DB_USER'] ?? null);
        define('DBKEY', $_ENV['DB_KEY'] ?? null);
        define('PORT', $_ENV['DB_PORT'] ?? null);
        define('ROOT', 'http://localhost/Time-Tracker/public/');
        define('APP', 'http://localhost/Time-Tracker/app/');
        define('RECOVERY_REDIRECT', 'http://localhost/Time-Tracker/public/recovery/reconfirm');
        define('FORGOT_PASS', 'http://localhost/Time-Tracker/public/recovery/');
    } else {
        $config = simplexml_load_file('../App.config');
        define('DBNAME', $_ENV['DB_NAME'] ?? null);
        define('DBHOST', $_ENV['DB_HOST'] ?? null);
        define('DBUSER', $_ENV['DB_USER'] ?? null);
        define('DBKEY', $_ENV['DB_KEY'] ?? null);
        define('PORT', $_ENV['DB_PORT'] ?? null);
        define('ROOT', 'https://wheretomed.azurewebsites.net/public/');
        define('APP', 'https://wheretomed.azurewebsites.net/app/');
        define('RECOVERY_REDIRECT', 'https://wheretomed.azurewebsites.net/public/recovery/reconfirm');
        define('FORGOT_PASS', 'https://wheretomed.azurewebsites.net/public/recovery/');
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
