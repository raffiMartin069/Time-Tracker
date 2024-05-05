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
        define('DBNAME', $_SERVER['DB_NAME']);
        define('DBHOST', $_SERVER['DB_HOST']);
        define('DBUSER', $_SERVER['DB_USERNAME']);
        define('DBKEY', $_SERVER['DB_PASSWORD']);
        define('ROOT', 'http://localhost/Time-Tracker/public/');
    } else {
        define('DBNAME', 'test');
        define('DBHOST', 'localhost');
        define('DBUSER', 'root');
        define('DBKEY', '');
        define('ROOT', 'http://www.website.com/');
    }
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


TestingDebugger();
AppInformation();
defineRoot();
