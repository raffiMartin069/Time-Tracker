<?php

require_once __DIR__ . "/../Core/Controller.php";
require_once __DIR__ . "/../Models/AdminModels/DailyReportModel.php";
require_once __DIR__ . "/../DAO/AdminDAO.php";

class Admin extends Controller
{

    use Model;
    use AdminDAO;


    public function index()
    {
        $_SESSION["UID"] = 7;
        $this->view('Shared/sidenav/Admin');
    }

    protected function ArrangeResults($data)
    {
        $results = [];
        foreach ($data as $row) {
            // Check for each property's existence before accessing it
            $results[] = [
                'ID' => property_exists($row, 'daily_id') ? $row->daily_id : null,
                'DATE' => property_exists($row, 'date') ? $row->date : null,
                'CLOCK_IN' => property_exists($row, 'clock_in') ? $row->clock_in : null,
                'CLOCK_OUT' => property_exists($row, 'clock_out') ? $row->clock_out : null,
                'BREAK_STATUS' => property_exists($row, 'break_status') ? $row->break_status : null,
                'HRS_WORKED' => property_exists($row, 'hrs_worked') ? $row->hrs_worked : null,
                'MEETING_STATUS' => property_exists($row, 'meeting_status') ? $row->meeting_status : null,
                'EMP_ID' => property_exists($row, 'emp_id') ? $row->emp_id : null,
            ];
        }
        return $results;
    }

    public function main()
    {
        // this is the dashboard page of the admin
        try {
            // id should be replaced with id stored in a session.
            // in this way we can identify who the user was.
            $data = $this->Get(7, 'get_daily_report');
            $results = $this->ArrangeResults($data);

            $reportModels = [];
            foreach ($results as $result) {
                $reportModels[] = new DailyReportModel($result);
            }

            $this->view('Admin/Main', [
                'results' => $reportModels
            ]);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }


    public function history()
    {
        $this->view('Admin/History');
    }

    public function management()
    {
        $this->view('Admin/Management');
    }

    public function test()
    {
        $results = $this->GetAll('DAILY_REPORT');
        $del = $this->Delete(212, 'DAILY_REPORT', 'daily_id');
        $meeting_logs = $this->GetAll('MEETING_LOGS');
        $del_meeting_log = $this->Delete(6, 'MEETING_LOGS', 'record_id');

        $this->view('Test', [
            'results' => $results,
            'meeting_logs' => $meeting_logs
        ]);
    }

    private function verifyTimeInDate($date)
    {
        // id number 7 is only for place holder
        $searchDate = $this->findCurrentDate(7);
        // search for the date in the database
        // if the date is found return true
        // else return false
        foreach ($searchDate as $findDate) {
            if ($findDate->date == $date) {
                return true;
            }
        }
        return false;
    }

    private function Action($action, $state)
    {
        $success = true;

        switch ($action) {
            case 0:
                $success = $this->adminClockIn(7);
                $_SESSION["ClockedIn"] = true;
                break;

            case 1:
                $success = $this->adminClockOut(7);
                $_SESSION["ClockedIn"] = false;
                break;
            case 2:
                $success = $this->adminMeetingIn(7);
                $_SESSION["MeetingIn"] = true;
                break;

            case 3:
                $success = $this->adminMeetingOut(7);
                $_SESSION["MeetingIn"] = false;
                break;

            case 4:
                $success = $this->adminBreakIn(7);
                $_SESSION["BreakIn"] = true;
                break;

            case 5:
                $success = $this->adminBreakOut(7);
                $_SESSION["BreakIn"] = false;
                break;

            default:
                echo 'Invalid action';
        }

        return $success;
    }

    // http endpoint
    public function Status()
    {
        // check if the request method is post
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            header("Content-Type: application/json");
            echo json_encode([
                'status' => false,
                'message' => 'Invalid request method'
            ]);
            die();
        }

        // get the data from the request being sent.
        $rawData = file_get_contents('php://input');
        // decode the json data
        $data = json_decode($rawData);

        // check if the data is empty
        if (empty($data)) {
            header("Content-Type: application/json");
            echo json_encode([
                'status' => false,
                'message' => 'Invalid request data'
            ]);
            die();
        }

        $state = $data->state;
        $action = $data->action;

        $isSuccess = $this->Action($state, $action);
        if (!$isSuccess) {
            header("Content-Type: application/json");
            echo json_encode([
                'status' => false,
                'message' => 'Something went wrong. Please try again later.'
            ]);
            die();
        }

        header("Content-Type: application/json");
        $serverResponse = [
            'status' => true,
            'message' => 'Success'
        ];
        echo json_encode($serverResponse);
    }

    private function inputValidation($array)
    {
        foreach ($array as $key => $value) {
            if (empty($value)) {
                return false;
            }
        }
        return true;
    }

    public function AddEmployee()
    {
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
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