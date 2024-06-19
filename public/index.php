<?php
// Start a session cookie.
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

if (!isset($_SESSION['last_regeneration'])) {
    session_regenerate_id(true);
    $_SESSION['last_regeneration'] = time();
} else {
    $interval = 60 * 30;

    if (time() - $_SESSION['last_regeneration'] >= $interval) {
        session_regenerate_id(true);
        $_SESSION['last_regeneration'] = time();
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
