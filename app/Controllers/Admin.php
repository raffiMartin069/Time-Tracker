<?php
require_once __DIR__ . "/../Core/Controller.php";
require_once __DIR__ . "/../Models/AdminModels/DailyReportModel.php";
require_once __DIR__ . "/../Models/AdminModels/AdminOperationModel.php";
require_once __DIR__ . "/../Models/AdminModels/MeetingLogsModel.php";
require_once __DIR__ . "/../Models/AdminModels/BreakLogsModel.php";
require_once __DIR__ . "/../Models/EmployeeModel.php";
require_once __DIR__ . "/../Models/PlatformModel.php";
require_once __DIR__ . "/../Models/ShiftModel.php";
require_once __DIR__ . "/../DAO/AdminDAO.php";
require_once __DIR__ . '/../Utilities/PDFUtility.php';
require_once __DIR__ . '/../Utilities/ExceptionHandler.php';

class Admin extends Controller
{

    use Model;
    use AdminDAO;

    /**
     * @var ExceptionHandler
     * This is a global scope variable that will be used to handle exceptions.
     * This is a utility class that will be used clean handled exceptions before sending to the client side.
     */
    private $sweep;

    public function __construct()
    {
        $this->sweep = new ExceptionHandler();
    }

    private function validHttpMethod($method)
    {
        if ($_SERVER["REQUEST_METHOD"] !== $method) {
            throw new Exception("Invalid request method");
        }
        return true;
    }

    /**
     * @param $this->checkMethod($method) will check if the request method is valid.
     * If the result passes it will do nothing and continue executing the program, otherwise
     * an error message will be sent to the client side.
     */
    private function checkMethod($method)
    {
        try {
            $this->validHttpMethod($method);
        } catch (Exception $e) {
            header('Content-Type: application/json');
            http_response_code(400);
            echo json_encode(['error' => $e->getMessage()]);
            exit;
        }
    }

    // private function decodeJsonArray($arr) 
    // {

    //         $new_arr = json_decode($arr, TRUE);
    //         return $new_arr;            

    // } 

    private function sanitizeMeetingInputs($data)
    {
        try {
            $sanitize = new Sanitation();
            // $arr = $this->decodeJsonArray($data['participants']);
            
            $participantsArray = json_decode($data['participants'], true);

            $sanitized_data = [
                $sanitize->strSanitation($data['meet_date']),
                $sanitize->strSanitation($data['meet_title']),
                $sanitize->strSanitation($data['mess_desc']),
                $sanitize->strSanitation($data['meet_start']),
                $sanitize->strSanitation($data['meet_end']),
                $sanitize->strSanitation($data['meet_link']),
                $sanitize->strSanitation($data['platform']),
                $sanitize->arraySanitation($participantsArray)
            ];

            $this->insertMeeting($sanitized_data);

        } catch (Exception $e) {
            header('Content-Type: application/json');
            http_response_code(400);
            echo json_encode(['error' => $e->getMessage()]);
            exit;
        }
    }

    public function createMeeting()
    {
        $method = $_SERVER["REQUEST_METHOD"];
        $this->checkMethod($method);

        // get the data from the request being sent.
        $rawData = file_get_contents('php://input');

        try {
            // decode the json data
            $data = json_decode($rawData);

            $this->checkNullIncomingData($data);

            $arr = $this->StrNormalize($data);

            $this->sanitizeMeetingInputs($arr);

            header('Content-Type: application/json');
            echo json_encode(['status' => true, 'message' => 'Meeting created successfully']);
            exit;
        } catch (Exception $e) {
            header('Content-Type: application/json');
            http_response_code(400);
            echo json_encode(['error' => $e->getMessage()]);
            exit;
        }

    }

    public function index()
    {
        $startMeeting = new EmployeeModel();
        $tableView = $startMeeting->getAllEmployee();
        $platforms = $this->fetchAllPlatform();
        $this->view('Shared/sidenav/Admin', [
            'tableView' => $tableView,
            'platforms' => $platforms
        ]);
    }

    public function breakLog()
    {
        $logs = new BreakLogModel();
        $tableView = $logs->getBreakLog();
        $this->view(
            'Admin/BreakLog',
            [
                'tableView' => $tableView
            ]
        );
    }

    public function meeting()
    {
        $this->view('Admin/Meeting');
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

    private function state()
    {
        $uid = $_SESSION["userId"];
        $current_date = date('Y-m-d');
        $results = $this->adminButtonState($uid, $current_date);
        return $results;
    }

    private function buttonState($clock_in, $clock_out)
    {
        if ($clock_in && is_null($clock_out)) {
            return $_SESSION["ClockedIn"] = true;
        } else if ($clock_in && !is_null($clock_out)) {
            return $_SESSION["ClockedIn"] = false;
        }
    }

    private function breakState($breakStatus)
    {
        return $breakStatus ? $_SESSION["BreakIn"] = true : $_SESSION["BreakIn"] = false;
    }

    private function meetingState($meetingStatus)
    {
        return $meetingStatus ? $_SESSION["MeetingIn"] = true : $_SESSION["MeetingIn"] = false;
    }

    private function extractStates($data)
    {
        foreach ($data as $row) {
            $clockIn = $row->clock_in;
            $clockOut = $row->clock_out;
            $breakStatus = $row->break_status;
            $meetingStatus = $row->meeting_status;
        }
        $this->buttonState($clockIn, $clockOut);
        $this->breakState($breakStatus);
        $this->meetingState($meetingStatus);
    }

    // endpoint for quick notification.
    public function notification()
    {
        $mess = $_SESSION["notification"];
        if (!empty($mess)) {
            header("Content-Type: application/json");
            echo json_encode(['mess' => $mess]);
            exit;
        }
    }

    public function main()
    {
        ob_start();
        // this is the dashboard page of the admin
        try {
            // id should be replaced with id stored in a session.
            // in this way we can identify who the user was.
            $id = $_SESSION["userId"];
            $data = $this->Get($id, 'get_daily_report');
            $results = $this->ArrangeResults($data);

            $reportModels = [];
            foreach ($results as $result) {
                $reportModels[] = new DailyReportModel($result);
            }

            // button states, preserve state even when browser closes.
            $state = $this->state();

            if (!empty($state)) {
                $this->extractStates($state);
            }


            ob_end_flush();

            $this->view('Admin/Main', [
                'results' => $reportModels
            ]);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function meetingLog()
    {
        $logs = new MeetingLogModel();
        $tableView = $logs->getMeetingLogs();
        $this->view('Admin/MeetingLog', [
            'tableView' => $tableView,
        ]);
    }

    private function shifts()
    {
        $results = [];
        try {
            $shifts = $this->GetAll('SHIFT');
            foreach ($shifts as $shift) {
                $model = new ShiftModel();
                $model->setShiftID($shift->shift_id);
                $model->setShiftName($shift->shift_name);
                $results[] = $model;
            }
            return $results;
        } catch (Throwable $e) {
            echo $e->getMessage();
            return [];
        }
    }

    private function positions()
    {
        $results = [];

        try {
            $position = $this->GetAll('POSITION');

            foreach ($position as $positions) {
                $model = new PositionModel();
                $model->setPositionID($positions->position_id);
                $model->setPositionName($positions->position_name);
                $results[] = $model;
            }
            return $results;
        } catch (Throwable $e) {
            echo $e->getMessage();
            return [];
        }

    }

    private function managementTable()
    {
        $results = [];
        try {
            $management = $this->manageEmployeeTable();

            foreach ($management as $manage) {
                $model = new EmployeeModel();
                $model->setID($manage->emp_id);
                $model->setFirstName($manage->fname);
                $model->setLastName($manage->lname);
                $model->setMiddleName($manage->mname);
                $model->setEmail($manage->email);
                $model->setDOB($manage->birth_date);
                $model->setPosition($manage->position_name);
                $model->setHireDate($manage->hired_date);
                $model->setWorkingHours($manage->req_hrs);
                $results[] = $model;
            }
            return $results;
        } catch (Throwable $e) {
            echo $e->getMessage();
            return [];
        }
    }

    private function employmentType()
    {
        $results = [];

        try {
            $employment = $this->GetAll('EMPLOYMENT_STATUS');
            foreach ($employment as $employ) {
                $model = new EmploymentModel();
                $model->setEmploymentID($employ->emp_stat_id);
                $model->setEmploymentType($employ->emp_stat_name);
                $model->setWorkHours($employ->req_hrs);
                $results[] = $model;
            }
            return $results;
        } catch (Throwable $e) {
            echo $e->getMessage();
            return [];
        }
    }

    public function management()
    {
        $management = $this->managementTable();
        $positions = $this->positions();
        $shifts = $this->shifts();
        $employment = $this->employmentType();
        $this->view('Admin/Management', [
            'management' => $management,
            'positions' => $positions,
            'shift' => $shifts,
            'employment' => $employment,
        ]);
    }

    public function test()
    {
        $results = $this->GetAll('credentials');

        $this->Delete(261, 'DAILY_REPORT', 'daily_id');

        $this->view('Test', [
            'results' => $results,
        ]);
    }

    private function operations($action)
    {
        try {
            $admin_ops = new DailyOperationModel();
            $admin_ops->setOperation($action);
            $admin_ops->setEmp_id($_SESSION["userId"]);
            return $admin_ops->Action();
        } catch (Exception $e) {
            header('Content-Type: application/json');
            http_response_code(400);
            echo json_encode(['error' => $e->getMessage()]);
            exit;
        }
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

        $this->checkNullIncomingData($data);

        $operation = $this->operations($data->state);

        header("Content-Type: application/json");
        $serverResponse = [
            'status' => $operation,
            'message' => 'Success'
        ];
        echo json_encode($serverResponse);
    }

    private function inputValidation($array)
    {
        try {
            foreach ($array as $key => $value) {
                // skip mname
                // middle name is optional
                if ($key === 'mname') {
                    continue;
                }
                if ($value === "" || $value === null) { // Use type-strict comparison
                    throw new Exception('Please fill out all fields');
                }
            }
            return $array;
        } catch (Exception $e) {
            http_response_code(400);
            header("Content-Type: application/json");
            echo json_encode(['error' => $e->getMessage()]);
            exit;
        }
    }

    private function assignEmployee($arr = [])
    {
        $emp = new EmployeeModel();
        $emp->setFirstName($arr['fname']);
        $emp->setMiddleName($arr['mname']);
        $emp->setLastName($arr['lname']);
        $emp->setDOB($arr['dob']);
        $emp->setHireDate($arr['hireDate']);
        $emp->setEmail($arr['email']);
        $emp->setContact($arr['contact']);
        $emp->setRole($arr['role']);
        $emp->setShift($arr['shift']);
        $emp->setType($arr['type']);
        return $emp->addNewEmployee();
    }

    private function StrNormalize($arr)
    {
        $result = [];
        foreach ($arr as $key => $value) {
            // initially if there is a null value in the array we set it to temp.
            // the reason is we need to normalize the string.
            // passing a null value to the ucwords function will result in an error.
            // null value is not supported by ucwords and is already deprecated.
            // this however is only applicable to middle name.
            if ($key === 'checkbox') {
                continue;
            }

            if (is_array($value)) {
                $result[$key] = $value;
                continue;
            }

            if (!is_string($value)) {
                throw new Exception('Invalid input, please check the fields and try again.');
            }

            if ($key === 'mname' && $value === "") {
                $value = 'G4hT9Zr3';
            }
            if ($key === 'email') {
                $result[$key] = $value;
                continue;
            }
            $result[$key] = ucwords(strtolower($value));

            if ($key === 'mname' && $value === "G4hT9Zr3") {
                $value = null;
            }
        }

        return $result;
    }


    private function pdf($arr = [])
    {
        $pdf = new PDFUtility();
        $data = [];

        foreach ($arr as $item) {
            // Check if $item is an object or an array and contains required properties
            if (
                (is_object($item) && isset($item->emp_id, $item->login_id, $item->password)) ||
                (is_array($item) && isset($item['emp_id'], $item['login_id'], $item['password']))
            ) {
                $data[] = $item; // Add the valid item to $data
            }
        }

        $content = $pdf->createPDF($data);
        return $content;
    }

    private function checkIndividualData($data = [])
    {
        foreach ($data as $key => $value) {
            if ($key === 'mname') {
                continue;
            }

            if ($value === "" || $value === null) {
                throw new Exception('Please fill out all fields');
            }
        }
    }

    private function checkBulkData($data)
    {
        $exception = new Exception('Please fill out all fields');

        if (empty($data)) {
            throw new $exception;
        }

        if (is_null($data)) {
            throw new $exception;
        }
    }

    /**
     * @param $data
     * This method checks incoming data for null values.
     * No need to do anything this will handle the operations in checking data for null values.
     */
    private function checkNullIncomingData($data)
    {
        try {
            $this->checkBulkData($data);
            $this->checkIndividualData($data);
        } catch (Exception $e) {
            http_response_code(400);
            header("Content-Type: application/json");
            $this->sweep->setMessage($e->getMessage());
            echo json_encode(['error' => $e->getMessage()]);
            exit;
        }
    }

    private function checkDbResult($db_res)
    {
        try {
            if (empty($db_res)) {
                throw new Exception("Employee not added. Please try again.");
            }
        } catch (Exception $e) {
            http_response_code(400);
            header("Content-Type: application/json");
            echo json_encode(['error' => $e->getMessage()]);
            exit;
        }
    }

    private function prepareSanitation($data)
    {
        $sanitize = new Sanitation();
        // planning to revert back to normal state.
        // this should be return [ someParams ];
        try {
            $sanitized = [
                'fname' => $sanitize->strSanitation($data['fname']),
                'lname' => $sanitize->strSanitation($data['lname']),
                'mname' => $sanitize->strSanitation($data['mname']),
                'dob' => $sanitize->strSanitation($data['dob']),
                'hireDate' => $sanitize->strSanitation($data['hireDate']),
                'email' => $sanitize->emailSanitation($data['email']),
                'contact' => $sanitize->strSanitation($data['contact']),
                'role' => $sanitize->strSanitation($data['role']),
                'shift' => $sanitize->intSanitation($data['shift']),
                'type' => $sanitize->intSanitation($data['type'])
            ];

            return $sanitized;


        } catch (Exception $e) {
            http_response_code(400);
            header("Content-Type: application/json");
            echo json_encode(['error' => $e->getMessage()]);
            exit;
        }

    }

    public function AddEmployee()
    {
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            header("Content-Type: application/json");
            echo json_encode([
                'status' => false,
                'msg' => 'Invalid request method'
            ]);
            return;
        }

        $rawData = file_get_contents('php://input');
        $data = json_decode($rawData);

        $this->checkNullIncomingData($data);

        $requiredFields = [
            'fname' => $data->fname,
            'lname' => $data->lname,
            'mname' => $data->mname,
            'dob' => $data->dob,
            'hireDate' => $data->hireDate,
            'email' => $data->email,
            'contact' => $data->contact,
            'role' => $data->role,
            'shift' => $data->shift,
            'type' => $data->type
        ];

        // Added logic for middle name,
        // we put temporary value for it
        // just for  the strlower to execute properly.
        $result = $this->inputValidation($requiredFields);

        // normalization of strings before inserting to database.
        $normalized = $this->StrNormalize($result);

        // Sanitize the data
        $sanitized = $this->prepareSanitation($normalized);

        $db_result = $this->assignEmployee($sanitized);

        $this->checkDbResult($db_result);

        $pdf = $this->pdf($db_result);

        header("Content-Type: application/json");
        $serverResponse = [
            'status' => true,
            'msg' => 'Employee added successfully',
            'data' => $db_result,
            'pdf' => $pdf
        ];

        echo json_encode($serverResponse);
    }
}