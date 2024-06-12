<?php
require_once "../app/Core/Controller.php";
require_once "../app/DAO/AuthDAO.php";
require_once "Admin.php";
require_once __DIR__ . '/../Models/Login.php';

class Login extends Controller
{

    use AuthDAO;

    public function index()
    {
        $this->view('Login/Login');
    }

    private function initialFilter($id, $pass)
    {
        // for sanitation only and not incorporated to any models.
        try {
            $sanitize = new Sanitation();
            $userId = $sanitize->strSanitation($id);
            $pwd = $sanitize->strSanitation($pass);

            return [$userId, $pwd];
        } catch (Exception $e) {
            header('Content-Type: application/json');
            http_response_code($e->getCode());
            echo json_encode(['error' => $e->getMessage()]);
            exit();
        }
    }

    private function secondaryFilter($data)
    {
        if (!isset($data[0]) || !isset($data[1])) {
            throw new Exception("Invalid input", 400);
        }
        return true;
    }

    private function insertDatabase($array = [])
    {
        // actual model for log in
        $employee = new LoginModel();
        $employee->setUsername($array['idNumber']);
        $employee->setPassword($array['pass']);
        $result = $this->Authenticate($array);
        return $result;
    }

    private function extractData($data)
    {
        if(!isset($data) && empty($data)) {
            throw new Exception("Something went wrong, please try again later", 404);
        }

        foreach($data as $key => $value) {
            $id = $value->employee_id;
            $default_pass = $value->is_default;
            $isAdmin = $value->is_admin;
            $mess = $value->message;
        }
        return [
            'id' => $id,
            'pass' => $default_pass,
            'admin' => $isAdmin,
            'message' => $mess
        ];
    }

    private function passwordVerify($pass)
    {
        $prompt = '';
        if($pass === true) {
            $prompt = 'Please change your password';
        }
        return $prompt;
    }

    public function auth()
    {
        if ($_SERVER["REQUEST_METHOD"] !== 'POST') {
            header('Content-Type: application/json');
            throw new Exception("Invalid request method", 405);
        }

        $data = json_decode(file_get_contents("php://input"), true);

        $sanitized = $this->initialFilter($data['idNumber'], $data['pass']);

        try {
            $secondary = $this->secondaryFilter($sanitized);

            if (!$secondary) {
                throw new Exception("Invalid input", 400);
            }
        } catch (Exception $e) {
            header('Content-Type: application/json');
            http_response_code($e->getCode());
            echo json_encode(['error' => $e->getMessage()]);
            exit();
        }

        $credential = [
            'idNumber' => $sanitized[0],
            'pass' => $sanitized[1]
        ];

        $result = $this->insertDatabase($credential);

        try {
            $extract = $this->extractData($result);
            $_SESSION["userId"] = $extract['id'];

            $keyVerify = $this->passwordVerify($extract['pass']);
            $_SESSION["notification"] = $extract['message'];
            $extract['admin'];
            define('KEY_PROMPT',  $keyVerify);

            if($extract['admin'] === true) {
                header('Content-Type: application/json');
                echo json_encode(['redirect' => '/Time-Tracker/public/admin']);
                exit();
            } else {
                header('Content-Type: application/json');
                echo json_encode(['redirect' => '/Time-Tracker/public']);
                exit();
            }
        } catch(Exception $e) {
            header('Content-Type: application/json');
            http_response_code($e->getCode());
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
}