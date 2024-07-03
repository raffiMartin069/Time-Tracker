<?php
require_once "../app/Core/Controller.php";
require_once __DIR__ . "/../Models/Recover/RecoveryModel.php";
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

        // The data that was passed was initially an id number but then changed into a email.
        // Though there is a mismatch but the HTML markup field type was changed into "email" front "text".
        // The models are also updated, instead of the ID number it was changed into email.
        $email = $json_decode['email'];
        // $bday = $json_decode['bday'];

        $model = new RecoveryModel();

        try {
            $model->setEmail($email);
            // $model->setBday($bday);
        } catch (Exception $e) {
            header('Content-Type: application/json');
            http_response_code($e->getCode());
            echo json_encode(['error' => $e->getMessage()]);
            exit();
        }

        // ! Needs refactoring, instead of getting the Email and Birthday, it should be fetching the record.
        // ! The record will be then used to send an email to the user.
        $email_result = $model->getEmail();
        // $bday_result = $model->getBday();

        try {
            $this->checkResult($email_result);
            // $this->checkResult($bday_result);
        } catch (Exception $e) {
            header('Content-Type: application/json');
            http_response_code($e->getCode());
            echo json_encode(['error' => $e->getMessage()]);
            exit();
        }

        $result = $model->sendEmail();

        if ($result !== true) {
            header('Content-Type: application/json');
            echo json_encode(['result' => false]);
            exit();
        }
        header('Content-Type: application/json');
        echo json_encode(['result' => true]);
        exit();
    }

    public function secondaryReset()
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
        $email = $json_decode['idNumber'];
        $bday = $json_decode['bday'];

        $model = new RecoveryModel();

        try {
            $model->setEmail($email);
            $model->setBday($bday);
        } catch (Exception $e) {
            header('Content-Type: application/json');
            http_response_code($e->getCode());
            echo json_encode(['error' => $e->getMessage()]);
            exit();
        }

        header('Content-Type: application/json');
        echo json_encode(['result' => true]);
        exit();
    }
}