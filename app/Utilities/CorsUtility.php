<?php
// Time-Tracker/app/Utilities/CorsUtil.php

class CorsUtil {
    public static function setCorsHeaders() {
        header('Access-Control-Allow-Origin: *'); // Adjust the value as per your requirements
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
        header('Access-Control-Max-Age: 86400'); // Cache preflight request for 24 hours
    }
}