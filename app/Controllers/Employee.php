<?php
require_once __DIR__ . "/../Core/Controller.php";
require_once __DIR__ . "/../Models/DailyReportModel.php";
require_once __DIR__ . '/../Models/WeeklyReportModel.php';
require_once __DIR__ . '/../Models/BiweeklyReportModel.php';
require_once __DIR__ . '/../Models/SettingsModel.php';
require_once __DIR__ . '/../Helpers/Sanitation.php';
require_once __DIR__ . "/../DAO/EmployeeDAO.php";
require_once __DIR__. '/../Models/EmployeeDailyReportModel.php';
require_once __DIR__ . '/Admin.php';


class Employee extends Controller
{
    use Model;
    use EmployeeDAO;
    use AdminDAO;

    // This is used to create a single instance of the admin class in order to reuse some of its methods.
    protected $admin_call;

    private $sweep;


    private function routeValidation()
    {
        $key = '/employee';
        if (strpos($_SERVER['REQUEST_URI'], $key) !== false) {
            // If it does, call the checkAdmin method to validate the user
            $this->checkEmployee();
        }
    }

    public function __construct()
    {
        $this->routeValidation();
        // $this->checkEmployee();
        /**
         * This is the constructor of the Employee controller.
         * It initializes the Admin class to call the main method.
         * This is to serve the dashboard contents specifically for employee.
         */
        $this->admin_call = new Admin();
        $this->sweep = new ExceptionHandler();
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
                Employee::ArrayNullCheck($decoded_array);
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

    private function validHttpMethod($method)
    {
        if ($_SERVER["REQUEST_METHOD"] !== $method) {
            throw new Exception("Invalid request method");
        }
        return true;
    }

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
    public function breakLog()
    {
        $tableView = $this->employeeBreakLog($_SESSION['userId']);
        $this->view(
            'Employee/EmployeeBreakLog',
            [
                'tableView' => $tableView
            ]
        );
    }

    public function meetingLog()
    {
        $tableView = $this->employeeMeetingLog($_SESSION['userId']);
        $this->view('Employee/EmployeeMeetingLog', [
            'tableView' => $tableView,
        ]);
    }

    public function index()
    {
        $_SESSION["userId"];
        $startMeeting = new EmployeeModel();
        // $tableView = $startMeeting->getAllEmployee();
        // $platforms = $this->fetchAllPlatform();
        $this->view('Shared/sidenav/Employee', [
            // 'tableView' => $tableView,
            // 'platforms' => $platforms
        ]);
    }

    protected function ArrangeResults($data)
    {
        $results = [];
        foreach ($data as $row) {
            // Check for each property's existence before accessing it
            $results[] = [
                'DAILY_ID' => property_exists($row, 'daily_id') ? $row->daily_id : null,
                'DATE' => property_exists($row, 'date') ? $row->date : null,
                'CLOCK_IN' => property_exists($row, 'clock_in') ? $row->clock_in : null,
                'CLOCK_OUT' => property_exists($row, 'clock_out') ? $row->clock_out : null,
                'BREAK_IN' => property_exists($row, 'break_in') ? $row->break_in : null,
                'BREAK_OUT' => property_exists($row, 'break_out') ? $row->break_out : null,
                'HRS_WORKED' => property_exists($row, 'hrs_worked') ? $row->hrs_worked : null,
                'DURATION' => property_exists($row, 'duration') ? $row->duration : null,
                'EMP_ID' => property_exists($row, 'emp_id') ? $row->emp_id : null,
            ];
        }
        return $results;
    }


    public function dailyreport()
    {
        try {
            $data = $this->Get($_SESSION["userId"], 'get_daily_report_table');
            $results = $this->ArrangeResults($data);

            $reportModels = [];
            foreach ($results as $result) {
                $reportModels[] = new EmployeeDailyReportModel($result);
            }

            $this->view('Employee/DailyReport', [
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
            $data = $this->Get($_SESSION["userId"], 'get_weekly_report_table');
            $results = $this->ArrangeWeeklyResults($data);

            $reportModels = [];
            foreach ($results as $result) {
                $reportModels[] = new WeeklyReportModel($result);
            }

            $this->view('Employee/WeeklyReport', [
                'results' => $reportModels
            ]);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function fetchWeeklyDailyReports()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $reportDate = isset($_GET['report_date']) ? $_GET['report_date'] : null;
            $empId = isset($_GET['emp_id']) ? $_GET['emp_id'] : null;

            if ($reportDate && $empId) {
                try {
                    $query = "select * from weekly_stamp(:report_date, :emp_id)";

                    $params = [
                        'report_date' => $reportDate,
                        'emp_id' => $empId
                    ];

                    $data = $this->Query($query, $params);
                    $results = $this->ArrangeResults($data);

                    header("Content-Type: application/json");
                    echo json_encode($results);
                } catch (Exception $e) {
                    error_log("Error: " . $e->getMessage()); // Log the error message
                    header("Content-Type: application/json");
                    http_response_code(500);
                    echo json_encode(['error' => 'Server error. Please try again later.']);
                } catch (PDOException $e) {
                    error_log("PDO Error: " . $e->getMessage()); // Log the PDO error message
                    header("Content-Type: application/json");
                    http_response_code(500);
                    echo json_encode(['error' => 'Database error. Please try again later.']);
                }
            } else {
                header("Content-Type: application/json");
                http_response_code(400);
                echo json_encode(['error' => 'Invalid parameters.']);
            }
        } else {
            header("Content-Type: application/json");
            http_response_code(405);
            echo json_encode(['error' => 'Invalid request method.']);
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
                'APPR_STATUS' => property_exists($row, 'appr_status') ? $row->appr_status : null,
                'ACKNOWLEDGED_BY' => property_exists($row, 'acknowledged_by') ? $row->acknowledged_by : null,
            ];
        }
        return $results;
    }

    public function biweeklyreport()
    {
        try {
            $data = $this->Get($_SESSION["userId"], 'get_bi_weekly_report_table');
            $results = $this->ArrangeBiweeklyResults($data);

            $reportModels = [];
            foreach ($results as $result) {
                $reportModels[] = new BiweeklyReportModel($result);
            }

            $this->view('Employee/BiweeklyReport', [
                'results' => $reportModels
            ]);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function fetchBiweeklyDailyReports()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $reportDate = isset($_GET['report_date']) ? $_GET['report_date'] : null;
            $empId = isset($_GET['emp_id']) ? $_GET['emp_id'] : null;

            if ($reportDate && $empId) {
                try {
                    $query = "select * from bi_weekly_stamp(:report_date, :emp_id)";

                    $params = [
                        'report_date' => $reportDate,
                        'emp_id' => $empId
                    ];

                    error_log("SQL Query: " . $query);
                    error_log("Parameters: " . json_encode($params));

                    $data = $this->Query($query, $params);
                    $results = $this->ArrangeResults($data);

                    header("Content-Type: application/json");
                    echo json_encode($results);
                } catch (Exception $e) {
                    error_log("Error: " . $e->getMessage());
                    header("Content-Type: application/json");
                    http_response_code(500);
                    echo json_encode(['error' => 'Server error. Please try again later.']);
                } catch (PDOException $e) {
                    error_log("PDO Error: " . $e->getMessage());
                    header("Content-Type: application/json");
                    http_response_code(500);
                    echo json_encode(['error' => 'Database error. Please try again later.']);
                }
            }
        }
    }

    /**
     * This method is a copy of the main method in the Admin controller.
     * The purpose is to serve the dashboard contents specifically for employee.
     */
    public function main()
    {
        $this->admin_call->main();
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
                'EMAIL' => property_exists($row, 'email') ? $row->email : null,
                'ECN' => property_exists($row, 'ecn') ? $row->ecn : null,
                'IMAGE' => property_exists($row, 'image') ? $row->image : null,
            ];
        }
        return $results;
    }

    public function settings()
    {
        try {
            $data = $this->GetInfo($_SESSION["userId"]);
            $results = $this->ArrangePersonalInfo($data);

            $reportModels = [];
            foreach ($results as $result) {
                $reportModels[] = new SettingsModel($result);
            }

            $this->view('Employee/Settings', [
                'results' => $reportModels
            ]);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function UpdateProfilePic()
    {

        // if(!$result = $user->check_is_logged_in())
        // {
        //     header("Location:" . ROOT . "Login");
        //     die();
        // }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $profilePhoto = isset($_FILES['profilePhoto']) ? $_FILES['profilePhoto'] : null;
            $empId = isset($_SESSION["userId"]) ? $_SESSION["userId"] : null;

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
                'emp_id' => $_SESSION["userId"] ?? null
            ];

            $sanitized_data = [
                'f_name' => Sanitize::strSanitation($data['f_name']),
                'm_name' => Sanitize::strSanitation($data['m_name']),
                'l_name' => Sanitize::strSanitation($data['l_name']),
                'birth_date' => Sanitize::strSanitation($data['birth_date']),
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
                http_response_code(500);
                echo json_encode(['error' => 'Error: ' . $e->getMessage()]);
            } catch (PDOException $e) {
                http_response_code(500);
                echo json_encode(['error' => 'PDO Error: ' . $e->getMessage()]);
            }
        } else {
            http_response_code(405);
            echo json_encode(['error' => 'Method not allowed.']);
        }
    }

    public function UpdateSettingsPasswordInfo()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'curr_password' => $_POST['curr_password'] ?? null,
                'new_password' => $_POST['new_password'] ?? null,
                'emp_id' => $_SESSION["userId"] ?? null
            ];

            $sanitized_data = [
                'curr_password' => Sanitize::strSanitation($data['curr_password']),
                'new_password' => Sanitize::strSanitation($data['new_password']),
                'emp_id' => Sanitize::intSanitation($data['emp_id'])
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
                http_response_code(500);
                echo json_encode(['error' => 'Error: ' . $e->getMessage()]);
            } catch (PDOException $e) {
                http_response_code(500);
                echo json_encode(['error' => 'PDO Error: ' . $e->getMessage()]);
            }
        } else {
            http_response_code(405);
            echo json_encode(['error' => 'Method not allowed.']);
        }
    }

    public function UpdateSettingsContactInfo()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'email' => $_POST['email'] ?? null,
                'ecn' => $_POST['ecn'] ?? null,
                'emp_id' => $_SESSION["userId"] ?? null
            ];

            $sanitized_data = [
                'email' => Sanitize::emailSanitation($data['email']),
                'ecn' => Sanitize::strSanitation($data['ecn']),
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
                http_response_code(500);
                echo json_encode(['error' => 'Error: ' . $e->getMessage()]);
            } catch (PDOException $e) {
                http_response_code(500);
                echo json_encode(['error' => 'PDO Error: ' . $e->getMessage()]);
            }
        } else {
            http_response_code(405);
            echo json_encode(['error' => 'Method not allowed.']);
        }
    }

    private function employeeNotificationViewTable()
    {
        $notif_array = $this->fetchAllEmployeeNotification($_SESSION['userId']);
        return $notif_array;
    }

    public function employeeNotificationView()
    {
        $notif_array = $this->employeeNotificationViewTable();
        $this->view('Employee/EmployeeNotification', [
            'tableView' => $notif_array
        ]);
    }
}
