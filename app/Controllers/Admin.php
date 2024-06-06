<?php

require_once "../app/Core/Controller.php";

class Admin extends Controller {

    use Database;

    public function index() {
        $this->view('Shared/sidenav/Admin');
    }

    public function main() {
        $this->view('Admin/Main');
    }

    public function history() {
        $this->view('Admin/History');
    }

    public function management() {
        $this->view('Admin/Management');
    }

    // http endpoint
    public function Status() {

        if($_SERVER["REQUEST_METHOD" ] !== "POST") {
            header("Content-Type: application/json");
            echo json_encode([
                'status' => false,
                'message' => 'Invalid request method'
            ]);
        }

        // Get raw data from request body
        $rawData = file_get_contents('php://input');

        // Decode JSON data into PHP object
        $data = json_decode($rawData);

        $getStatus = isset($data->status) ? $data->status : null;
        $getOperation = isset($data->action) ? $data->action : null;
        
        // Prepare data to send back
        $responseData = [
            'status' => $getStatus,
            'operation' => $getOperation,
        ];

        // Set header to application/json
        header('Content-Type: application/json');

        // Send data back to frontend
        echo json_encode($responseData);
        
    }

    private function inputValidation($array) {
        foreach($array as $key => $value) {
            if(empty($value)) {
                return false;
            }
        }
        return true;
    }

    public function AddEmployee() {
        if($_SERVER["REQUEST_METHOD"] !== "POST") {
            header("Content-Type: application/json");
            echo json_encode([
                'status' => false,
                'message' => 'Invalid request method'
            ]);
        }

        $rawData = file_get_contents('php://input');
        $data = json_decode($rawData);



        header("Content-Type: application/json");
        $serverResponse = [
            'status' => true,
            'message' => 'Employee added successfully'
        ];

        echo json_encode($serverResponse);
    }
}