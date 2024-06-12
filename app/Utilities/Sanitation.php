<?php
class Sanitation
{
    // This class sanitizes user inputs based on their form submission.
    // Basic validation are done to ensure the integrity of each submission and the data it contains.
    public static function intSanitation($value)
    {
        try{
            $intVal = filter_var($value, FILTER_VALIDATE_INT);
            if ($intVal !== false && $intVal == $value) {
                return $intVal;
            }
            throw new Exception("Invalid input, please check the fields and try again.");
        } catch(Exception $e) {
            http_response_code(500);
            header('Content-Type: application/json');
            echo json_encode(['error' => $e->getMessage()]);
            exit();
        }
    }

    // second filter for special characters
    public function strSanitation($value)
    {
        try {
            $str = filter_var($value, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            if ($str !== false && $str === $value) {
                return $value;
            }
            throw new Exception("Invalid input, please check the fields and try again.");
        } catch(Exception $e) {
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
            exit();
        }
    }

    public function emailSanitation($value)
    {
        try {
            $email = filter_var($value, FILTER_SANITIZE_EMAIL);
            if ($email !== false && $email === $value) {
                return $email;
            }
            throw new Exception("Invalid input, please check the fields and try again.");
        } catch(Exception $e) {
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
            exit();
        }
    }
}