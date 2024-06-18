<?php
Trait Model {

    use Database;

    /**
     * @param string $query
     * Added this intended for employees display since there are no display in his/her dashboard
     */
    public function fetchAllEmployeeNotification($id)
    {
        try {
            $query = "select * from get_meeting_notification(:id)";
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


    public function Get($id, $table) { 
        try {
            // $this->validate($table);
            $query = "SELECT * FROM {$table}(:id); ";
            $params = [
                'id' => $id
            ];
            return $this->Query($query, $params);
        } catch(Exception $e) {
            echo 'Error: ' . $e->getMessage();
        } catch(PDOException $e) {
            echo 'PDO Error: ' . $e->getMessage();
        }
    }

    public function GetInfo($id) {
        try {
            $query = "
                SELECT e.emp_id, e.lname, e.mname, e.fname, e.birth_date, e.hired_date, 
                       ec.email, ec.ecn 
                FROM employee e 
                INNER JOIN employee_credential ec ON e.emp_id = ec.emp_id 
                WHERE e.emp_id = :id
            ";
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

    public function GetAll($table) {
        try {
            $query = "SELECT * FROM {$table};";
            return $this->Query($query);
        } catch(PDOException $e) {
            echo 'PDO Error: ' . $e->getMessage();
        } catch(Exception $e) {
            echo 'Error: ' . $e->getMessage();
        
        }
    }

    public function Delete($id, $table, $col) {
        try{
            $query = "DELETE FROM {$table} WHERE {$col} = :id";
            $params = [
                'id' => $id
            ];
            return $this->Query($query, $params);
        } catch(Exception $e) {
            echo 'Error: ' . $e->getMessage();
        } catch(PDOException $e) {
            echo 'PDO Error: ' . $e->getMessage();
        }
    }
}