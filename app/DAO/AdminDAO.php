<?php
/**
 * DATA ACCESS OBJECT (DAO) 
 * This class contains methods that are used to interact with the database.
 * The methods in this class are used to clock in and clock out employees.
 * The only focus of this groups of classes is to have specific and non-general operations in the database.
 * PHP version 7.4
 */
trait AdminDAO
{
    private function adminMeetingIn($id) {
        try {
            $query = "update daily_report set meeting_in = current_timestamp where emp_id = :id and date = current_date;";
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
            $query = "insert into daily_report(emp_id) values (:id);";
            $params = [
                'id' => $id
            ];
            return $this->Query($query, $params);
        
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
            $query = "update daily_report set clock_out = current_timestamp where emp_id = :id and date = current_date;";
            
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
            $query = "SELECT date FROM get_daily_report(:id)";
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
