<?php
require_once __DIR__ . "/../../DAO/AdminDAO.php";
require_once __DIR__ . "/../Interface/AdminOperationinterface.php";
class DailyOperationModel implements AdminOperationInterface
{
    use AdminDAO;

    private $daily_id;
    private $date;
    private $clock_in;
    private $clock_out;
    private $meeting_status;
    private $hrs_worked;
    private $emp_id;
    private $break_status;
    private $operation;

    public function Action()
    {
        $success = true;
        switch ($this->getOperation()) {
            case 0:
                $success = $this->adminClockIn($this->getEmp_id());
                break;

            case 1:
                $success = $this->adminClockOut($this->getEmp_id());
                break;
            case 2:
                $success = $this->adminMeetingIn($this->getEmp_id());
                break;

            case 3:
                $success = $this->adminMeetingOut($this->getEmp_id());
                break;

            case 4:
                $success = $this->adminBreakIn($this->getEmp_id());
                break;

            case 5:
                $success = $this->adminBreakOut($this->getEmp_id());
                break;

            default:
                throw new Exception("Invalid Operation");
        }
        return $success;
    }

    public function getOperation()
    {
        return $this->operation;
    }

    public function setOperation($operation)
    {
        $this->operation = $operation;
        return $this;
    }

    public function getDaily_id()
    {
        return $this->daily_id;
    }

    public function setDaily_id($daily_id)
    {
        $this->daily_id = $daily_id;
        return $this;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setDate($date)
    {
        $this->date = $date;
        return $this;
    }

    public function getClock_in()
    {
        return $this->clock_in;
    }

    public function setClock_in($clock_in)
    {
        $this->clock_in = $clock_in;
        return $this;
    }

    public function getClock_out()
    {
        return $this->clock_out;
    }

    public function setClock_out($clock_out)
    {
        $this->clock_out = $clock_out;
        return $this;
    }

    public function getMeeting_status()
    {
        return $this->meeting_status;
    }

    public function setMeeting_status($meeting_status)
    {
        $this->meeting_status = $meeting_status;
        return $this;
    }

    public function getHrs_worked()
    {
        return $this->hrs_worked;
    }

    public function setHrs_worked($hrs_worked)
    {
        $this->hrs_worked = $hrs_worked;
        return $this;
    }

    public function getEmp_id()
    {
        return $this->emp_id;
    }

    public function setEmp_id($emp_id)
    {
        $this->emp_id = $emp_id;
        return $this;
    }

    public function getBreak_status()
    {
        return $this->break_status;
    }

    public function setBreak_status($break_status)
    {
        $this->break_status = $break_status;
        return $this;
    }
}