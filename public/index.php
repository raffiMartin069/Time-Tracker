<?php
ini_set('session.use_only_cookies', 1);
ini_set('session.use_strict_mode', 1);

session_set_cookie_params([
    'lifetime' => 1800,
    'path' => '/',
    'domain' => $_SERVER['HTTP_HOST'],
    'secure' => true,
    'httponly' => true,
    'samesite' => 'Strict'
]);

session_start();

error_log("Session ID: " . session_id());
error_log("Session Data: " . print_r($_SESSION, true));

if (!isset($_SESSION['last_regeneration'])) {
    session_regenerate_id(true);
    $_SESSION['last_regeneration'] = time();
    error_log("Session regenerated at: " . time());
} else {
    $interval = 60 * 3;

    if (time() - $_SESSION['last_regeneration'] >= $interval - 2.9) {
        session_regenerate_id(true);
        $_SESSION['last_regeneration'] = time();
        error_log("Session regenerated at: " . time());
    }
}


require "../app/Core/init.php";
require __DIR__ . "/vendor/autoload.php";


function Debugger()
{
    return DEBUG ? ini_set('display_errors', 1) : ini_set('display_errors', 0);
}

function EngineStart()
{
    $app = new App;
    return $app->loadController();
}

Debugger();
EngineStart();
