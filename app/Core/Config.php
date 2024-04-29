<?php

// This only checks if the server is localhost or not.
// If it is localhost, the ROOT constant is set to the localhost URL.
// If it is not localhost, the ROOT constant is set to the website URL.
// This is useful for setting the ROOT constant in the config file.
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
        define('ROOT', 'http://www.website.com');
    }
}

// NOTE: DISABLE DEBUG IN PRODUCTION
define('APPNAME', 'PHP-PDO');
define('APPDESC', 'A simple PHP PDO framework');
define('APPVERSION', '1.0.0');
define('DEBUG', true);



defineRoot();
