<?php
/**
 * DATA ACCESS OBJECT (DAO) 
 * This class contains methods that are used to interact with the database.
 * The methods in this class are used to clock in and clock out employees.
 * The only focus of this groups of classes is to have specific and non-general operations in the database.
 */
trait AdminDAO
{
    use Database;

    /**
     * @method insertMeeting(@param $data)
     * This method accepts a an array of integers to be inserted in the database.
     * Together with it is the meeting details.
     */
    public function insertMeeting($data)
    {
        try {
            $LOADER = new SQLoader();
            $query = $LOADER->loadSqlQuery('CreateMeeting.sql');
            
            $array_id = array_map('intval', $data['7']);
            $arrayString = "{" . implode(",", $array_id) . "}";
            $params = [
                $data[0],
                $data[1],
                $data[2],
                $data[3],
                $data[4],
                $data[5],
                $data[6],
                $arrayString
            ];

            return $this->Query($query, $params);
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        } catch (PDOException $e) {
            echo 'PDO Error: ' . $e->getMessage();
        }
    }

    public function fetchAllPlatform()
    {
        try {
            $LOADER = new SQLoader();
            $query = $LOADER->loadSqlQuery('Platform.sql');
            return $this->Query($query);
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        } catch (PDOException $e) {
            echo 'PDO Error: ' . $e->getMessage();
        }
    }

    public function fetchAllEmployee()
    {
        try {
            $LOADER = new SQLoader();
            $query = $LOADER->loadSqlQuery('Employee.sql');
            return $this->Query($query);
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        } catch (PDOException $e) {
            echo 'PDO Error: ' . $e->getMessage();
        }
    }

    public function adminBreakLogs()
    {
        try {
            $LOADER = new SQLoader();
            $query = $LOADER->loadSqlQuery('BreakLogs.sql');
            return $this->Query($query);
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        } catch (PDOException $e) {
            echo 'PDO Error: ' . $e->getMessage();
        }
    }

    public function adminMeetingLogs()
    {
        try{
            $LOADER = new SQLoader();
            $query = $LOADER->loadSqlQuery('MeetingLogs.sql');
            return $this->Query($query);
        } catch(Exception $e) {
            echo 'Error: ' . $e->getMessage();
        } catch(PDOException $e) {
            echo 'PDO Error: ' . $e->getMessage();
        }
    }


    public function adminButtonState($id, $date)
    {
        try {
            $LOADER = new SQLoader();
            $query = $LOADER->loadSqlQuery('AdminState.sql');
            $params = [
                $id,
                $date
            ];
            return $this->Query($query, $params);
        } catch(Exception $e) {
            echo 'Error: ' . $e->getMessage();
        } catch(PDOException $e) {
            echo 'PDO Error: ' . $e->getMessage();
        }
    }

    public function insertNewEmployee($data = [])
    {
        try {
            $LOADER = new SQLoader();
            // Load the SQL query from the InsertNewEmployee.sql file
            $query = $LOADER->loadSqlQuery('AddEmployee.sql');

            $params = [
                $data['lname'],
                $data['mname'],
                $data['fname'],
                $data['dob'],
                $data['hireDate'],
                $data['email'],
                $data['contact'],
                $data['role'],
                $data['shift'],
                $data['type']
            ];

            $result = $this->Query($query, $params);
            // Use $params instead of $data when calling the Query method
            return $result;
        } catch (Exception $e) {
            header("Content-Type: application/json");
            http_response_code(500);
            echo json_encode(['error' => 'Error: ' . $e->getMessage()]);
            exit;
        } catch (PDOException $e) {
            header("Content-Type: application/json");
            http_response_code(500);
            echo json_encode(['error' => 'PDO Error: ' . $e->getMessage()]);
            exit;
        }
    }

    public function manageEmployeeTable()
    {
        try {
            $LOADER = new SQLoader();
            $query = $LOADER->loadSqlQuery('ManageEmployeeView.sql');
            return $this->Query($query);
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        } catch (PDOException $e) {
            echo 'PDO Error: ' . $e->getMessage();
        }
    }

    private function adminBreakOut($id)
    {
        try {
            $LOADER = new SQLoader();
            $query = $LOADER->loadSqlQuery('BreakOut.sql');
            $params = [
                'id' => $id
            ];
            return !empty($this->Query($query, $params)) ? true : false;
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        } catch (PDOException $e) {
            echo 'PDO Error: ' . $e->getMessage();
        }
    }

    private function adminBreakIn($id)
    {
        try {
            $LOADER = new SQLoader();
            $query = $LOADER->loadSqlQuery('BreakIn.sql');
            $params = [
                'id' => $id
            ];
            return !empty($this->Query($query, $params)) ? true : false;
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        } catch (PDOException $e) {
            echo 'PDO Error: ' . $e->getMessage();
        }
    }

    private function adminMeetingOut($id)
    {
        try {
            $LOADER = new SQLoader();
            $query = $LOADER->loadSqlQuery('MeetingOut.sql');
            $params = [
                'id' => $id
            ];
            return !empty($this->Query($query, $params)) ? true : false;
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        } catch (PDOException $e) {
            echo 'PDO Error: ' . $e->getMessage();
        }
    }

    private function adminMeetingIn($id)
    {
        try {
            $LOADER = new SQLoader();
            $query = $LOADER->loadSqlQuery('MeetingIn.sql');
            $params = [
                'id' => $id
            ];
            return !empty($this->Query($query, $params)) ? true : false;
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        } catch (PDOException $e) {
            echo 'PDO Error: ' . $e->getMessage();
        }
    }

    private function adminClockIn($id)
    {
        try {
            $LOADER = new SQLoader();
            $query = $LOADER->loadSqlQuery('ClockIn.sql');
            $params = [
                'id' => $id
            ];
            return !empty($this->Query($query, $params)) ? true : false;
        } catch (Exception $e) {
            http_response_code(500); // Set a proper HTTP response code
            header('Content-Type: application/json'); // Indicate the content type is JSON
            echo json_encode(['error' => 'Error: ' . $e->getMessage()]);
            exit;
        } catch (PDOException $e) {
            http_response_code(500); // Set a proper HTTP response code
            header('Content-Type: application/json'); // Indicate the content type is JSON
            echo json_encode(['error' => 'Error: ' . $e->getMessage()]);
            exit;
        }
    }

    private function adminClockOut($id)
    {
        try {
            $LOADER = new SQLoader();
            $query = $LOADER->loadSqlQuery('ClockOut.sql');
            $params = [
                'id' => $id
            ];
            return !empty($this->Query($query, $params)) ? true : false;
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        } catch (PDOException $e) {
            echo 'PDO Error: ' . $e->getMessage();
        }
    }

    private function findCurrentDate($id)
    {
        try {
            $LOADER = new SQLoader();
            $query = $LOADER->loadSqlQuery('FindCurrentDate.sql');
            $params = [
                'id' => $id
            ];
            return $this->Query($query, $params);
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        } catch (PDOException $e) {
            echo 'PDO Error: ' . $e->getMessage();
        }
    }
}
