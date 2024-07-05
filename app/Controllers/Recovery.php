<?php
require_once "../app/Core/Controller.php";
require_once __DIR__ . "/../Models/Recover/RecoveryModel.php";
require_once __DIR__ . "/../Models/Recover/TokenModel.php";
require_once __DIR__ . "/../Models/Recover/ResetPasswordModel.php";
require_once __DIR__ . "/../Controllers/_404.php";
class Recovery extends Controller
{
    public function index()
    {
        $this->view('RecoveryView/ForgotPassword');
    }

    public function reconfirm()
    {
        // if (isset($_GET['expires'])) {
        //     $expires = filter_input(INPUT_GET, 'expires', FILTER_VALIDATE_INT);
        //     if ($expires === false) {
        //         echo "Invalid expiration time.";
        //         return;
        //     }
        //     $recoveryModel = new RecoveryModel();

        //     if ($recoveryModel->isLinkExpired($expires)) {
        //         $error = new PageNotFound();
        //         $error->Index();
        //         return;
        //     }
        // } else {
        //     echo "Invalid request.";
        //     return;
        // }
        $this->view('RecoveryView/Reconfirm');
    }

    public function changePassword()
    {
        $this->view('RecoveryView/ChangePassword');
    }

    public function postRequestValidation($requestMethod)
    {
        if ($_SERVER["REQUEST_METHOD"] !== 'POST') {
            header('Content-Type: application/json');
            throw new Exception("Invalid request method", 405);
        }
    }

    private function checkResult($result)
    {
        if ($result === '') {
            throw new Exception('Invalid input', 400);
        }
    }

    /**
     * @method initialReset
     * This endpoint is used when user clicks the forgot password in the log in UI.
     * The data that will be sent is the email and the birthday of the user.
     */
    public function initialReset()
    {
        //! No Query yet, this is just a placeholder
        //! Waiting for the database query to be finalized.
        try {
            $this->postRequestValidation($_SERVER["REQUEST_METHOD"]);
        } catch (Exception $e) {
            header('Content-Type: application/json');
            http_response_code($e->getCode());
            echo json_encode(['error' => $e->getMessage()]);
            exit();
        }
        $json_decode = json_decode(file_get_contents('php://input'), true);
        $email = $json_decode['email'];
        $model = new RecoveryModel();
        try {
            $model->setEmail($email);
            $email_result = $model->fetchRecord();
            $this->checkResult($email_result);
            if (empty($email_result)) {
                if (!$email_result) {
                    header('Content-Type: application/json');
                    http_response_code(200);
                    echo json_encode(['result' => false]);
                    exit();
                }
            }
            $result = $model->sendEmail();
        } catch (Exception $e) {
            header('Content-Type: application/json');
            http_response_code($e->getCode());
            echo json_encode(['error' => $e->getMessage()]);
            exit();
        }
        if ($result !== true) {
            header('Content-Type: application/json');
            echo json_encode(['result' => false]);
            exit();
        }
        header('Content-Type: application/json');
        http_response_code(200);
        echo json_encode(['result' => true]);
        exit();
    }

    /**
     * @method secondaryReset
     * This method will verify if the access token is valid.
     * The access token has a duration of 5 minutes only before it expires.
     * After the expiration, the token is no longer usable.
     */
    public function secondaryReset()
    {
        try {
            $this->postRequestValidation($_SERVER["REQUEST_METHOD"]);
        } catch (Exception $e) {
            header('Content-Type: application/json');
            http_response_code($e->getCode());
            echo json_encode(['error' => $e->getMessage()]);
            exit();
        }
        $json_decode = json_decode(file_get_contents('php://input'), true);
        $token = $json_decode['token'];
        $model = new Token();
        try {
            $model->setToken($token);
            $isTokenValid = $model->confirmToken();
        } catch (Exception $e) {
            header('Content-Type: application/json');
            http_response_code($e->getCode());
            echo json_encode(['error' => $e->getMessage()]);
            exit();
        }

        if (!$isTokenValid) {
            header('Content-Type: application/json');
            echo json_encode(['result' => false]);
            exit();
        }

        header('Content-Type: application/json');
        echo json_encode(['result' => true]);
        exit();
    }

    /**
     * This is the actual resetting of password.
     * If previous operations are successful then this will be the last step.
     */
    public function resetPassword()
    {
        try {
            $this->postRequestValidation($_SERVER["REQUEST_METHOD"]);
        } catch (Exception $e) {
            header('Content-Type: application/json');
            http_response_code($e->getCode());
            echo json_encode(['error' => $e->getMessage()]);
            exit();
        }
        $json_decode = json_decode(file_get_contents('php://input'), true);
        $new_pw = $json_decode['new_pw'];
        $confirm_pw = $json_decode['confirm_pw'];
        $id = $json_decode['id'];
        $dob = $json_decode['dob'];
        $model = new ResetPasswordModel();
        try {
            $model->setNewPass($new_pw);
            $model->setConfirmPass($confirm_pw);
            $model->setID($id);
            $model->setDOB($dob);
            $result = $model->fetchResetPasswordResult();
        } catch(Exception $e) {
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
            exit();
        }
        if(!isset($result)) {
            header('Content-Type: application/json');
            http_response_code(200);
            echo json_encode(['result' => false]);
            exit();
        }
        header('Content-Type: application/json');
        http_response_code(200);
        echo json_encode(['result' => true, 'redirect' => ROOT]);
        exit();
    }
}