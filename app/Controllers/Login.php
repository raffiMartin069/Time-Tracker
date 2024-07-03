<?php
require_once "../app/Core/Controller.php";
require_once "../app/DAO/AuthDAO.php";
require_once "Admin.php";
require_once __DIR__ . '/../Models/Login.php';

class Login extends Controller
{

    use AuthDAO;

    public function logout()
    {
        if ($_SERVER["REQUEST_METHOD"] !== 'POST') {
            header('Content-Type: application/json');
            throw new Exception("Invalid request method", 405);
        }
        $_SESSION = array();
        session_unset();
        session_destroy();
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }
        header('Location: /Time-Tracker/public');
        exit();
    }

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
        if (!isset($data) && empty($data)) {
            throw new Exception("Something went wrong, please try again later", 404);
        }

        foreach ($data as $key => $value) {
            $id = $value->employee_id;
            $default_pass = $value->is_default;
            $isAdmin = $value->is_admin;
            $mess = $value->message;
            $name = $value->employee_name;
            $email = $value->email;
            $popup_notif = $value->notification ?? "N/A";
        }
        return [
            'id' => $id,
            'pass' => $default_pass,
            'admin' => $isAdmin,
            'message' => $mess,
            'employee_name' => $name,
            'email' => $email,
            'notification' => $popup_notif
        ];
    }

    private function passwordVerify($pass)
    {
        $prompt = '';
        if ($pass === true) {
            $prompt = 'Please change your password';
        }
        return $prompt;
    }

    /**
     * * This method authenticates user and sets session variables.
     */
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
            $extract['admin'];
            $keyVerify = $this->passwordVerify($extract['pass']);

            $_SESSION["userId"] = $extract['id'];
            $_SESSION["notification"] = $extract['message'];
            $_SESSION['name'] = $extract['employee_name'];
            $_SESSION['email'] = $extract['email'];
            $_SESSION['role'] = $extract['admin'] === true ? 'admin' : 'employee';
            $_SESSION['popup_notif'] = $extract['notification'];

            define('KEY_PROMPT', $keyVerify);

            if ($extract['admin'] === true) {
                header('Content-Type: application/json');
                echo json_encode(['redirect' => '/Time-Tracker/public/admin']);
                exit();
            } else {
                header('Content-Type: application/json');
                echo json_encode(['redirect' => '/Time-Tracker/public/employee']);
                exit();
            }
        } catch (Exception $e) {
            header('Content-Type: application/json');
            http_response_code($e->getCode());
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
}