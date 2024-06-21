<?php
Trait EmployeeDAO
{
    use Database;

    public function employeeMeetingLog($emp_id) 
    {
        try {
            $LOADER = new SQLoader();
            $query = $LOADER->loadSqlQuery('EmployeeMeetingLog.sql');
            $params = [
                $emp_id,
            ];
            return $this->Query($query, $params) ?? [];
        } catch(Exception $e) {
            echo 'Error: ' . $e->getMessage();
        } catch(PDOException $e) {
            echo 'PDO Error: ' . $e->getMessage();
        }
    }

    public function employeeBreakLog($emp_id) 
    {
        try {
            $LOADER = new SQLoader();
            $query = $LOADER->loadSqlQuery('EmployeeBreakLog.sql');
            $params = [
                $emp_id,
            ];
            return $this->Query($query, $params) ?? [];
        } catch(Exception $e) {
            echo 'Error: ' . $e->getMessage();
        } catch(PDOException $e) {
            echo 'PDO Error: ' . $e->getMessage();
        }
    }
}