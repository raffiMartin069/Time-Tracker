<?php
require_once __DIR__ . "/../Core/Controller.php";
require_once __DIR__ . "/../Models/AdminModels/AdminOperationModel.php";
require_once __DIR__ . "/../Models/AdminModels/MeetingLogsModel.php";
require_once __DIR__ . "/../Models/AdminModels/BreakLogsModel.php";
require_once __DIR__ . "/../Models/EmployeeModel.php";
require_once __DIR__ . "/../Models/PlatformModel.php";
require_once __DIR__ . "/../Models/ShiftModel.php";
require_once __DIR__ . "/../DAO/AdminDAO.php";
require_once __DIR__ . '/../Utilities/PDFUtility.php';
require_once __DIR__ . '/../Utilities/ExceptionHandler.php';
require_once __DIR__ . "/../Models/AdminModels/AllDailyReportModel.php";
require_once __DIR__ . "/../Models/AdminModels/AllWeeklyReportModel.php";
require_once __DIR__ . "/../Models/AdminModels/AllBiweeklyReportModel.php";
require_once __DIR__ . "/../Models/AdminModels/AllSettingsModel.php";
require_once __DIR__ . "/../Models/AdminModels/AllManageAdminModel.php";
require_once __DIR__ . '/../Helpers/Sanitation.php';


class Admin extends Controller
{

    use Model;
    use AdminDAO;

    private function sanitizeUpdateEmployeePosition($data)
    {
        $sanitize = new Sanitation();
        try {
            $sanitized_data = [
                $sanitize->intSanitation($data['update_position']),
                $sanitize->intSanitation($data['update_role']),
            ];
            return $sanitized_data;
        } catch (Exception $e) {
            http_response_code(400);
            header("Content-Type: application/json");
            echo json_encode(['error' => $e->getMessage()]);
            exit;
        }
    }

    private function addUpdatePositionDB($pos_id, $emp_id)
    {
        /*
         * This is supposed to be passed to model since a model of this exist.
         * For some reason the code is a bit risky and as a work around I just
         * directly called the the method in the DAO to passed the data directly
         * to the database. The data have pass through validation and sanitation
         * before reaching this point.
         */
        $result = $this->updateEmployeePos($emp_id, $pos_id);
        return $result;
    }

    public function updateEmployeePosition()
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
        $data = json_decode($rawData);

        // reuse this method
        $this->prepareUpdateEmployeeChecks($data);


        $arr = [];
        foreach ($data as $key => $value) {
            $arr[$key] = $value;
        }

        // reuse this method
        $cleaned_data = $this->sanitizeUpdateEmployeePosition($arr);

        $work_id = $cleaned_data[1];
        $emp_id = $cleaned_data[0];


        // this method should be changed.
        $result = $this->addUpdatePositionDB($work_id, $emp_id);

        header("Content-Type: application/json");
        $serverResponse = [
            'status' => $result,
            'msg' => 'Employee added successfully',
        ];
        echo json_encode($serverResponse);
    }

    private function checkSoftDeleteNull($data)
    {
        if (empty($data)) {
            throw new Exception('Please fill out all fields');
        }
    }

    private function prepareSanitizeSoftDelete($data)
    {
        $sanitize = new Sanitation();
        try {

            $sanitized_data = $sanitize->intSanitation($data);

            return $sanitized_data;
        } catch (Exception $e) {
            http_response_code(400);
            header("Content-Type: application/json");
            echo json_encode(['error' => $e->getMessage()]);
            exit;
        }
    }

    private function addSoftDeleteDB($data)
    {
        $emp = new EmployeeModel();
        $emp->setID($data);
        $result = $emp->softDeleteEmployee();
        return $result;
    }

    private function prepareCheckSoftDeleteNull($data)
    {
        try {
            $this->checkSoftDeleteNull($data[0]);
        } catch (Exception $e) {
            header('Content-Type: application/json');
            http_response_code(400);
            echo json_encode(['error' => $e->getMessage()]);
            exit;
        }
    }

    public function softDeleteEmployee()
    {
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            header("Content-Type: application/json");
            echo json_encode([
                'status' => false,
                'message' => 'Invalid request method'
            ]);
            die();
        }

        $rawData = file_get_contents('php://input');

        $data = json_decode($rawData);

        $arr = [];

        foreach ($data as $key => $value) {
            $arr[$key] = $value;
        }

        $this->prepareCheckSoftDeleteNull($arr['del']);

        $cleaned_data = $this->prepareSanitizeSoftDelete($arr['del']);

        $result = $this->addSoftDeleteDB($cleaned_data);

        header("Content-Type: application/json");
        $serverResponse = [
            'status' => $result,
            'msg' => 'Employee deleted successfully',
        ];
        echo json_encode($serverResponse);
        exit;
    }

    private function addUpdateEmployee($work_id, $emp_id)
    {
        $emp = new EmployeeModel();

        $emp->setWorkingHours($work_id);
        $emp->setID($emp_id);

        $result = $emp->updateEmployeeHours();
        return $result;
    }

    private function sanitizeUpdateEmployee($data)
    {
        $sanitize = new Sanitation();
        try {
            $sanitized_data = [
                $sanitize->strSanitation($data['search_emp']),
                $sanitize->strSanitation($data['type']),
            ];
            return $sanitized_data;
        } catch (Exception $e) {
            http_response_code(400);
            header("Content-Type: application/json");
            echo json_encode(['error' => $e->getMessage()]);
            exit;
        }
    }

    private function prepareUpdateEmployeeChecks($data)
    {
        try {
            $this->checkNullIncomingData($data);
        } catch (Exception $e) {
            header('Content-Type: application/json');
            http_response_code(400);
            echo json_encode(['error' => $e->getMessage()]);
            exit;
        }
    }

    public function updateEmployee()
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
        $data = json_decode($rawData);

        $this->prepareUpdateEmployeeChecks($data);


        $arr = [];
        foreach ($data as $key => $value) {
            $arr[$key] = $value;
        }

        $cleaned_data = $this->sanitizeUpdateEmployee($arr);

        $work_id = $cleaned_data[1];
        $emp_id = $cleaned_data[0];

        $result = $this->addUpdateEmployee($work_id, $emp_id);

        header("Content-Type: application/json");
        $serverResponse = [
            'status' => $result,
            'msg' => 'Employee added successfully',
        ];
        echo json_encode($serverResponse);
    }

    private function biWeeklyReports()
    {
        $biWeekly = $this->fetchAllBiWeeklyReport();
        return $biWeekly;
    }

    private function weeklyReports()
    {
        $weekly = $this->fetchAllWeeklyReport();
        return $weekly;
    }

    private function dailyReports()
    {
        $daily = $this->fetchAllDailyReport();
        return $daily;
    }

    /**
     * @coversDefaultClass Admin
     * @method mixed reports()
     * This method will be used to generate reports to the views.
     * Typically passing read only data.
     */
    public function reports()
    {
        $daily = $this->dailyReports();
        $weekly = $this->weeklyReports();
        $biWeekly = $this->biWeeklyReports();
        $this->view('Admin/Report', [
            'daily' => $daily,
            'weekly' => $weekly,
            'biWeekly' => $biWeekly
        ]);
    }

    private function notificationViewTable()
    {
        $notif_array = $this->fetchAllNotification();
        return $notif_array;
    }

    public function notificationView()
    {
        $notif_array = $this->notificationViewTable();
        $this->view('Admin/Notification', [
            'tableView' => $notif_array
        ]);
    }

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

    private function sanitizeMeetingInputs($data)
    {
        try {
            $sanitize = new Sanitation();
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


    public function notification()
    {
        $mess = $_SESSION["notification"];
        $popup = $_SESSION['popup_notif'];
        if (!empty($mess)) {
            header("Content-Type: application/json");
            echo json_encode(['mess' => $mess, 'popup' => $popup]);
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
        $results = $this->GetAll('employee');

        // $this->Delete(240, 'employee', 'emp_id');

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

    private static function randomNumber()
    {
        return rand(50, 100);
    }

    private static function salt()
    {
        return bin2hex(random_bytes(15));
    }

    private static function pepper()
    {
        return 'G4hT9Zr3';
    }

    /**
     * @return string
     * This method will be used to generate a random string.
     * This will be used to generate a random string for the password.
     * This will server as a placeholder only for the checks to succeed in normalize method.
     * This will be then disregarded after the normalization of the string.
     */
    private static function randomStrGenerator()
    {
        $data = self::randomNumber() . self::salt() . self::pepper();
        return hash('sha256', $data);
    }

    /**
     * @param $arr
     * This method will be used to normalize the string.
     * This will be used to normalize the string before inserting to the database.
     */
    private function StrNormalize($arr)
    {
        $result = [];
        $randomize = self::randomStrGenerator();
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
                $value = $randomize;
            }

            if ($key === 'email') {
                $result[$key] = $value;
                continue;
            }
            $result[$key] = ucwords(strtolower($value));

            if ($key === 'mname' && $value === $randomize) {
                $value = '';
                $result[$key] = $value;
            }
        }

        return $result;
    }

    /**
     * @param $arr
     * This method will be used to generate a pdf file.
     * This will be used to generate a pdf file for the newly added employee.
     */
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

    /**
     * @param $array
     * This method checks if the array has null values.
     * There is no need to call this out because this will be handled by the checkIndividualData method.
     * This is a helper method for checkNullIncomingData.
     * Exception will be thrown if there is a null value in the array.
     * */
    private static function ArrayNullCheck($array)
    {

        // perform pre checks before handling the actual looping.
        if (empty($array) || $array === null || $array === "") {
            throw new Exception('Please fill out all fields');
        }

        foreach ($array as $key => $value) {
            if ($value === "") {
                throw new Exception('Please fill out all fields');
            }

            if ($value === null) {
                throw new Exception('Please fill out all fields');
            }

            if (!isset($value)) {
                throw new Exception('Please fill out all fields');
            }
        }
    }

    /**
     * @param $data
     * This method checks the individual data for null values.
     * */
    private function checkIndividualData($data = [])
    {
        foreach ($data as $key => $value) {

            if ($key === 'participants') {
                $decoded_array = json_decode($value, true);
                Admin::ArrayNullCheck($decoded_array);
            }

            if ($key === 'mname') {
                continue;
            }

            if ($value === "") {
                throw new Exception('Please fill out all fields');
            }

            if (!isset($value)) {
                throw new Exception('Please fill out all fields');
            }

            if ($value === null) {
                throw new Exception('Please fill out all fields');
            }

            if (is_array($value)) {
                Admin::ArrayNullCheck($value);
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
            'role' => $data->role ?? null,
            'shift' => $data->shift ?? null,
            'type' => $data->type ?? null
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

    // airielle
    // public function index()
    // {
    //     $_SESSION["UID"] = 12;
    //     $this->view('Shared/sidenav/Admin');
    // }

    protected function ArrangeReportsResults($data)
    {
        $results = [];
        foreach ($data as $row) {
            $results[] = [
                'DAILY_ID' => property_exists($row, 'daily_id') ? $row->daily_id : null,
                'EMP_ID' => property_exists($row, 'emp_id') ? $row->emp_id : null,
                'EMPLOYEE_NAME' => property_exists($row, 'employee_name') ? $row->employee_name : null,
                'DATE' => property_exists($row, 'date') ? $row->date : null,
                'CLOCK_IN' => property_exists($row, 'clock_in') ? $row->clock_in : null,
                'BREAK_IN' => property_exists($row, 'break_in') ? $row->break_in : null,
                'BREAK_OUT' => property_exists($row, 'break_out') ? $row->break_out : null,
                'DURATION' => property_exists($row, 'duration') ? $row->duration : null,
                'CLOCK_OUT' => property_exists($row, 'clock_out') ? $row->clock_out : null,
                'HRS_WORKED' => property_exists($row, 'hrs_worked') ? $row->hrs_worked : null,
            ];
        }
        return $results;
    }

    public function dailyreport()
    {
        try {
            $data = $this->GetAll('get_daily_report_table_admin()');
            $results = $this->ArrangeReportsResults($data);

            $reportModels = [];
            foreach ($results as $result) {
                $reportModels[] = new AllDailyReportModel($result);
            }

            $this->view('Admin/DailyReport', [
                'results' => $reportModels
            ]);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    protected function ArrangeWeeklyResults($data)
    {
        $results = [];
        foreach ($data as $row) {
            $results[] = [
                'WKLY_ID' => property_exists($row, 'wkly_id') ? $row->wkly_id : null,
                'REPORT_DATE' => property_exists($row, 'report_date') ? $row->report_date : null,
                'TOTAL_HOURS' => property_exists($row, 'total_hours') ? $row->total_hours : null,
                'EMP_ID' => property_exists($row, 'emp_id') ? $row->emp_id : null,
                'EMPLOYEE_NAME' => property_exists($row, 'employee_name') ? $row->employee_name : null,
                'APPR_STATUS' => property_exists($row, 'appr_status') ? $row->appr_status : null,
                'ACKNOWLEDGED_BY' => property_exists($row, 'acknowledged_by') ? $row->acknowledged_by : null,
            ];
        }
        return $results;
    }

    public function weeklyreport()
    {
        try {
            $data = $this->GetAll('get_weekly_report_table_admin()');
            $results = $this->ArrangeWeeklyResults($data);

            $reportModels = [];
            foreach ($results as $result) {
                $reportModels[] = new AllWeeklyReportModel($result);
            }

            $this->view('Admin/WeeklyReport', [
                'results' => $reportModels
            ]);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    // Daily Stamps of each employee for the week
    public function fetchWeeklyDailyReports()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $reportDate = isset($_GET['report_date']) ? $_GET['report_date'] : null;
            $empId = isset($_GET['emp_id']) ? $_GET['emp_id'] : null;

            try {
                $query = "select * from weekly_stamp(:report_date, :emp_id)";

                $params = [
                    'report_date' => $reportDate,
                    'emp_id' => $empId
                ];

                $data = $this->Query($query, $params);
                $results = $this->ArrangeReportsResults($data);
                header("Content-Type: application/json");
                echo json_encode($results);
            } catch (Exception $e) {
                echo "Error: " . $e->getMessage();
            } catch (PDOException $e) {
                echo "PDO Error: " . $e->getMessage();
            }
        } else {
            die();
        }
    }

    public function fetchAcknowledgementData()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $wklyId = isset($_GET['wkly_id']) ? $_GET['wkly_id'] : null;
            $empId = isset($_SESSION["UID"]) ? $_SESSION["UID"] : null;
            $password = isset($_GET['password']) ? $_GET['password'] : null;

            try {
                // Call the stored procedure to approve the weekly report
                $query = "call approve_weekly_report(:emp_id, :wkly_id, :password)";
                $params = [
                    'emp_id' => $empId,
                    'wkly_id' => $wklyId,
                    'password' => $password
                ];

                $this->Query($query, $params);

                $returnQuery = "SELECT acknowledged_by FROM get_weekly_report_table_admin() WHERE wkly_id = :wkly_id";

                $returnParams = [
                    'wkly_id' => $wklyId
                ];

                $returnData = $this->Query($returnQuery, $returnParams);

                if (!empty($returnData) && isset($returnData[0])) {

                    $returnUpdatedData = $returnData[0];

                    header("Content-Type: application/json");
                    echo json_encode([
                        'acknowledgedBy' => $returnUpdatedData->acknowledged_by ?? null
                    ]);
                }
            } catch (PDOException $e) {
                echo "PDO Error: " . $e->getMessage();
            } catch (Exception $e) {
                echo "Error: " . $e->getMessage();
            }
        } else {
            die();
        }
    }

    public function fetchBiweeklyAcknowledgementData()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $biWklyId = isset($_GET['bi_wkly_id']) ? $_GET['bi_wkly_id'] : null;
            $empId = isset($_SESSION["UID"]) ? $_SESSION["UID"] : null;
            $password = isset($_GET['password']) ? $_GET['password'] : null;

            try {
                // Call the stored procedure to approve the weekly report
                $query = "call approve_bi_weekly_report(:emp_id, :bi_wkly_id, :password)";
                $params = [
                    'emp_id' => $empId,
                    'bi_wkly_id' => $biWklyId,
                    'password' => $password
                ];

                $this->Query($query, $params);

                $returnQuery = "SELECT acknowledged_by FROM get_bi_weekly_report_table_admin() WHERE bi_wkly_id = :bi_wkly_id";
                $returnParams = [
                    'bi_wkly_id' => $biWklyId
                ];

                $returnData = $this->Query($returnQuery, $returnParams);

                if (!empty($returnData) && isset($returnData[0])) {
                    $returnUpdatedData = $returnData[0];

                    header("Content-Type: application/json");
                    echo json_encode([
                        'acknowledgedBy' => $returnUpdatedData->acknowledged_by ?? null
                    ]);
                }
            } catch (PDOException $e) {
                echo "PDO Error: " . $e->getMessage();
            } catch (Exception $e) {
                echo "Error: " . $e->getMessage();
            }
        } else {
            die();
        }
    }
    protected function ArrangeBiweeklyResults($data)
    {
        $results = [];
        foreach ($data as $row) {
            $results[] = [
                'BI_WKLY_ID' => property_exists($row, 'bi_wkly_id') ? $row->bi_wkly_id : null,
                'REPORT_DATE' => property_exists($row, 'report_date') ? $row->report_date : null,
                'TOTAL_HOURS' => property_exists($row, 'total_hours') ? $row->total_hours : null,
                'EMP_ID' => property_exists($row, 'emp_id') ? $row->emp_id : null,
                'EMPLOYEE_NAME' => property_exists($row, 'employee_name') ? $row->employee_name : null,
                'APPR_STATUS' => property_exists($row, 'appr_status') ? $row->appr_status : null,
                'ACKNOWLEDGED_BY' => property_exists($row, 'acknowledged_by') ? $row->acknowledged_by : null,
            ];
        }
        return $results;
    }

    public function biweeklyreport()
    {
        try {
            $data = $this->GetAll('get_bi_weekly_report_table_admin()');
            $results = $this->ArrangeBiweeklyResults($data);

            $reportModels = [];
            foreach ($results as $result) {
                $reportModels[] = new AllBiweeklyReportModel($result);
            }

            $this->view('Admin/BiweeklyReport', [
                'results' => $reportModels
            ]);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    // Daily Stamps of each employee for the week
    public function fetchBiweeklyDailyReports()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $reportDate = isset($_GET['report_date']) ? $_GET['report_date'] : null;
            $empId = isset($_GET['emp_id']) ? $_GET['emp_id'] : null;

            try {
                $query = "select * from bi_weekly_stamp(:report_date, :emp_id)";

                $params = [
                    'report_date' => $reportDate,
                    'emp_id' => $empId
                ];

                $data = $this->Query($query, $params);
                $results = $this->ArrangeBiweeklyResults($data);
                header("Content-Type: application/json");
                echo json_encode($results);
            } catch (Exception $e) {
                echo "Error: " . $e->getMessage();
            } catch (PDOException $e) {
                echo "PDO Error: " . $e->getMessage();
            }
        } else {
            die();
        }
    }

    protected function ArrangePersonalInfo($data)
    {
        $results = [];
        foreach ($data as $row) {
            $results[] = [
                'EMP_ID' => property_exists($row, 'emp_id') ? $row->emp_id : null,
                'FNAME' => property_exists($row, 'fname') ? $row->fname : null,
                'MNAME' => property_exists($row, 'mname') ? $row->mname : null,
                'LNAME' => property_exists($row, 'lname') ? $row->lname : null,
                'BIRTH_DATE' => property_exists($row, 'birth_date') ? $row->birth_date : null,
                'HIRED_DATE' => property_exists($row, 'hired_date') ? $row->hired_date : null,
                'EMAIL' => property_exists($row, 'email') ? $row->email : null,
                'ECN' => property_exists($row, 'ecn') ? $row->ecn : null,
                'IMAGE' => property_exists($row, 'image') ? $row->image : null,
            ];
        }
        return $results;
    }

    public function editProfileInformation()
    {
        try {
            $data = $this->GetInfo($_SESSION["UID"], 'employee');
            $results = $this->ArrangePersonalInfo($data);

            $reportModels = [];
            foreach ($results as $result) {
                $reportModels[] = new AllSettingsModel($result);
            }

            $this->view('Admin/Settings', [
                'results' => $reportModels
            ]);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    protected function ArrangeManageAccess($data)
    {
        $results = [];
        foreach ($data as $row) {
            $results[] = [
                'EMP_ID' => property_exists($row, 'emp_id') ? $row->emp_id : null,
                'EMPLOYEE' => property_exists($row, 'employee') ? $row->employee : null,
            ];
        }
        return $results;
    }

    public function manageAdminAccess()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            try {
                $data = $this->GetAll('get_admin_employees()');
                if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                    header("Content-Type: application/json");
                    echo json_encode($data);
                    exit;
                }

                $admins = $this->ArrangeManageAccess($data);

                $adminModels = [];
                foreach ($admins as $admin) {
                    $adminModels[] = new AllManageAdminModel($admin);
                }

                $this->view('Admin/ManageAdmin', [
                    'admins' => $adminModels
                ]);
            } catch (Exception $e) {
                http_response_code(500);
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => $e->getMessage()]);
            } catch (PDOException $e) {
                http_response_code(500);
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => $e->getMessage()]);
            }
        } elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
            try {
                $empId = isset($_POST['empId']) ? $_POST['empId'] : [];
                if (!is_array($empId)) {
                    $empId = [$empId];
                }
                $empId = array_map('intval', $empId);

                if (empty($empId)) {
                    throw new Exception('No employee IDs provided');
                }

                $idsArray = implode(',', $empId);
                $query = "SELECT remove_admins(ARRAY[" . $idsArray . "])";

                $this->Query($query);

                header("Content-Type: application/json");
                echo json_encode(['success' => true]);
            } catch (Exception $e) {
                http_response_code(500);
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => $e->getMessage()]);
            } catch (PDOException $e) {
                http_response_code(500);
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => $e->getMessage()]);
            }
        } else {
            die();
        }
    }

    public function manageRecycleBin()
    {
        try {
            $data = $this->GetAll('get_admin_employees()');


            $admins = $this->ArrangeManageAccess($data);

            $adminModels = [];
            foreach ($admins as $admin) {
                $adminModels[] = new AllManageAdminModel($admin);
            }

            $this->view('Admin/RecycleBin', [
                'admins' => $adminModels
            ]);
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        } catch (PDOException $e) {
            echo "PDO Error: " . $e->getMessage();
        }
    }

    public function RecoverAccount()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $empId = isset($_POST['empId']) ? $_POST['empId'] : null;

            try {
                $result = $this->checkId($empId);

                 if (isset($result[0]) && is_object($result[0])) {
                    if ($result[0]->count > 0) {
                        $currentStatus = $this->getEmpStatus($empId);

                        if ($currentStatus === false) {
                            $query = "UPDATE employee SET status = TRUE WHERE emp_id = :emp_id";
                            $params = [
                                'emp_id' => $empId
                            ];
                            $this->UpdateQuery($query, $params);
                            $message = 'Employee account has been successfully recovered.';
                            header('Content-Type: application/json');
                            echo json_encode(['success' => true, 'message' => $message]);
                        } else {
                            $message = 'Employee account cannot be recovered because it is not deleted.';
                            header('Content-Type: application/json');
                            echo json_encode(['success' => false, 'message' => $message]);
                        }
                     } 
                    else {
                        header('Content-Type: application/json');
                        echo json_encode(['success' => false, 'message' => 'The Entered ID was not found.']);
                    }
                } else {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => false, 'message' => 'The Entered ID was not found.']);
                }
            } catch (Exception $e) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
            }
        } else {
            die();  
        }
    }



    public function DeleteAccount()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $empId = isset($_POST['empId']) ? $_POST['empId'] : null;

        try {
            // Assuming checkId method returns an array of objects with a 'count' property
            $result = $this->checkId($empId);

            if (isset($result[0]) && is_object($result[0])) {
                if ($result[0]->count > 0) {
                    $query = "DELETE FROM employee WHERE emp_id = :emp_id";
                    $params = [
                        'emp_id' => $empId
                    ];
                    $this->DeleteQuery($query, $params);
                    $message = 'Employee account has been permanently deleted.';
                    header('Content-Type: application/json');
                    echo json_encode(['success' => true, 'message' => $message]);
                } else {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => false, 'message' => 'The entered ID does not exist. It may have already been deleted.']);
                }
            } else {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'The Entered ID was not found.']);
            }
        } catch (Exception $e) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
    }
}


    public function manageNoneAdminAccess()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            try {
                $data = $this->GetAll('get_non_admin_employees()');
                $results = $this->ArrangeManageAccess($data);

                header("Content-Type: application/json");
                echo json_encode($results);
            } catch (Exception $e) {
                echo "Error: " . $e->getMessage();
            } catch (PDOException $e) {
                echo "PDO Error: " . $e->getMessage();
            }
        } elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
            try {
                $empId = isset($_POST['empId']) ? $_POST['empId'] : [];
                if (!is_array($empId)) {
                    $empId = [$empId];
                }
                $empId = array_map('intval', $empId);

                $idsArray = implode(',', $empId);
                $query = "SELECT add_admins(ARRAY[" . $idsArray . "])";

                $this->Query($query);

                header("Content-Type: application/json");
                echo json_encode(['success' => true]);
            } catch (Exception $e) {
                echo "Error: " . $e->getMessage();
            } catch (PDOException $e) {
                echo "PDO Error: " . $e->getMessage();
            }
        } else {
            die();
        }
    }

    public function UpdateProfilePic()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $profilePhoto = isset($_FILES['profilePhoto']) ? $_FILES['profilePhoto'] : null;
            $empId = isset($_SESSION["UID"]) ? $_SESSION["UID"] : null;

            $allowed = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/svg+xml'];

            if ($profilePhoto && $profilePhoto['error'] == 0 && in_array($profilePhoto['type'], $allowed)) {
                $folder = 'uploads/';

                if (!file_exists($folder)) {
                    mkdir($folder, 0777, true);
                }

                $destination = $folder . basename($profilePhoto['name']);
                move_uploaded_file($_FILES['profilePhoto']['tmp_name'], $destination);

                try {
                    $query = "CALL change_profile_photo(:emp_id, :profile_photo)";
                    $params = [
                        'emp_id' => $empId,
                        'profile_photo' => $destination
                    ];

                    $this->Query($query, $params);
                } catch (Exception $e) {
                    echo "Error: " . $e->getMessage();
                } catch (PDOException $e) {
                    echo "PDO Error: " . $e->getMessage();
                }
            } else {
                echo "Uploaded image is not valid!";
            }
        } else {
            die();
        }
    }

    public function UpdateSettingsGeneralInfo()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'f_name' => $_POST['f_name'] ?? null,
                'm_name' => $_POST['m_name'] ?? null,
                'l_name' => $_POST['l_name'] ?? null,
                'birth_date' => $_POST['birth_date'] ?? null,
                'emp_id' => $_SESSION["UID"] ?? null
            ];

            $sanitized_data = [
                'f_name' => Sanitation::strSanitation($data['f_name']),
                'm_name' => Sanitation::strSanitation($data['m_name']),
                'l_name' => Sanitation::strSanitation($data['l_name']),
                'birth_date' => Sanitation::strSanitation($data['birth_date']),
                'emp_id' => Sanitation::intSanitation($data['emp_id'])
            ];

            if ($sanitized_data['emp_id'] === null) {
                http_response_code(400);
                echo json_encode(['error' => 'Invalid Tracker ID.']);
                exit;
            }

            try {
                $query = "CALL change_info(:emp_id, :l_name, :m_name, :f_name, :birth_date)";
                $params = [
                    ':emp_id' => $sanitized_data['emp_id'],
                    ':l_name' => $sanitized_data['l_name'],
                    ':m_name' => $sanitized_data['m_name'],
                    ':f_name' => $sanitized_data['f_name'],
                    ':birth_date' => $sanitized_data['birth_date']
                ];

                $this->Query($query, $params);

                $returnQuery = "SELECT lname, mname, fname, birth_date FROM employee WHERE emp_id = :emp_id";
                $returnParams = [':emp_id' => $sanitized_data['emp_id']];

                $returnData = $this->Query($returnQuery, $returnParams);

                if (!empty($returnData) && isset($returnData[0])) {
                    $returnUpdatedData = $returnData[0];

                    header("Content-Type: application/json");
                    echo json_encode([
                        'f_name' => $returnUpdatedData->fname ?? null,
                        'm_name' => $returnUpdatedData->mname ?? null,
                        'l_name' => $returnUpdatedData->lname ?? null,
                        'birth_date' => $returnUpdatedData->birth_date ?? null,
                    ]);
                }
            } catch (Exception $e) {
                echo "Error: " . $e->getMessage();
            } catch (PDOException $e) {
                echo "PDO Error: " . $e->getMessage();
            }
        } else {
            die();
        }
    }

    public function UpdateSettingsPasswordInfo()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'curr_password' => $_POST['curr_password'] ?? null,
                'new_password' => $_POST['new_password'] ?? null,
                'emp_id' => $_SESSION["UID"] ?? null
            ];

            $sanitized_data = [
                'curr_password' => Sanitation::strSanitation($data['curr_password']),
                'new_password' => Sanitation::strSanitation($data['new_password']),
                'emp_id' => Sanitation::intSanitation($data['emp_id'])
            ];

            if ($sanitized_data['emp_id'] === null) {
                http_response_code(400);
                echo json_encode(['error' => 'Invalid employee ID.']);
                exit;
            }

            try {
                $query = "CALL change_password(:emp_id, :curr_password, :new_password)";
                $params = [
                    ':emp_id' => $sanitized_data['emp_id'],
                    ':curr_password' => $sanitized_data['curr_password'],
                    ':new_password' => $sanitized_data['new_password']
                ];

                $data = $this->Query($query, $params);

                if (!empty($data) && isset($data[0])) {
                    $updatedInfo = $data[0];
                    header("Content-Type: application/json");
                    echo json_encode([
                        'curr_password' => $updatedInfo['curr_password'] ?? null,
                        'new_password' => $updatedInfo['new_password'] ?? null,
                    ]);
                }
            } catch (Exception $e) {
                echo "Error: " . $e->getMessage();
            } catch (PDOException $e) {
                echo "PDO Error: " . $e->getMessage();
            }
        } else {
            die();
        }
    }

    public function UpdateSettingsContactInfo()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'email' => $_POST['email'] ?? null,
                'ecn' => $_POST['ecn'] ?? null,
                'emp_id' => $_SESSION["UID"] ?? null
            ];

            $sanitized_data = [
                'email' => Sanitation::emailSanitation($data['email']),
                'ecn' => Sanitation::strSanitation($data['ecn']),
                'emp_id' => Sanitation::intSanitation($data['emp_id'])
            ];

            if ($sanitized_data['emp_id'] === null || !filter_var($sanitized_data['email'], FILTER_VALIDATE_EMAIL)) {
                http_response_code(400);
                echo json_encode(['error' => 'Invalid input data.']);
                exit;
            }

            try {
                $query = "CALL change_email_contact(:emp_id, :email, :ecn)";
                $params = [
                    ':emp_id' => $sanitized_data['emp_id'],
                    ':email' => $sanitized_data['email'],
                    ':ecn' => $sanitized_data['ecn']
                ];

                $this->Query($query, $params);

                $returnQuery = "SELECT email, ecn FROM employee_credential WHERE emp_id = :emp_id";
                $returnParams = [':emp_id' => $sanitized_data['emp_id']];

                $returnData = $this->Query($returnQuery, $returnParams);

                if (!empty($returnData) && isset($returnData[0])) {
                    $returnUpdatedData = $returnData[0];

                    header("Content-Type: application/json");
                    echo json_encode([
                        'email' => $returnUpdatedData->email ?? null,
                        'ecn' => $returnUpdatedData->ecn ?? null,
                    ]);
                }
            } catch (Exception $e) {
                echo "Error: " . $e->getMessage();
            } catch (PDOException $e) {
                echo "PDO Error: " . $e->getMessage();
            }
        } else {
            die();
        }
    }
}
