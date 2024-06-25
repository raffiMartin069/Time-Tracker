<?php
require_once "../app/Core/Controller.php";
require_once __DIR__."/../Models/Recover/RecoveryModel.php";
class Recovery extends Controller
{
    public function index()
    {
        $this->view('RecoveryView/ForgotPassword');
    }

    public function reconfirm()
    {
        $this->view('RecoveryView/Reconfirm');
    }

    public function changePassword()
    {
        $this->view('RecoveryView/ChangePassword');
    }

    public function postRequestValidation($requestMethod)
    {
        if($_SERVER["REQUEST_METHOD"] !== 'POST') {
            header('Content-Type: application/json');
            throw new Exception("Invalid request method", 405);
        }
    }

    public function initialReset()
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
        $id = $json_decode['idNumber'];
        $bday = $json_decode['bday'];

        $model = new RecoveryModel();

        try {
            $model->setId($id);
            $model->setBday($bday);
        } catch(Exception $e) {
            header('Content-Type: application/json');
            http_response_code($e->getCode());
            echo json_encode(['error' => $e->getMessage()]);
            exit();
        }

        $id_result = $model->getId();
        $bday_result = $model->getBday();
        $model->sendEmail();

        header('Content-Type: application/json');
        echo json_encode(['id' => $id_result, 'bday' => $bday_result]);
    }

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
        $id = $json_decode['idNumber'];
        $bday = $json_decode['bday'];

        $model = new RecoveryModel();

        try {
            $model->setId($id);
            $model->setBday($bday);
        } catch(Exception $e) {
            header('Content-Type: application/json');
            http_response_code($e->getCode());
            echo json_encode(['error' => $e->getMessage()]);
            exit();
        }

        $id_result = $model->getId();
        $bday_result = $model->getBday();
        

        header('Content-Type: application/json');
        echo json_encode(['id' => $id_result, 'bday' => $bday_result]);
    }
}