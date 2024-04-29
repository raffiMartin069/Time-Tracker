<?php
// Start a session cookie.
session_start();

require "../app/Core/init.php";

function Debugger() {
    return DEBUG ? ini_set('display_errors', 1) : ini_set('display_errors', 0);
}

function EngineStart() {
    $app = new App;
    return $app->loadController();
}

Debugger();
EngineStart();
