<?php
class BreakLogModel
{

    use AdminDAO;

    public $break_in;
    public $break_out;
    public $duration;
    public $emp_name;
    public $emp_id;

    public function getBreakLog()
    {;
        return $this->adminBreakLogs();
    }

    public function getBreakIn()
    {
        return $this->break_in;
    }

    public function getBreakOut()
    {
        return $this->break_out;
    }

    public function getDuration()
    {
        return $this->duration;
    }

    public function getEmpName()
    {
        return $this->emp_name;
    }

    public function getEmpId()
    {
        return $this->emp_id;
    }

    public function setBreakIn($break_in)
    {
        $this->break_in = $break_in;
    }

    public function setBreakOut($break_out)
    {
        $this->break_out = $break_out;
    }

    public function setDuration($duration)
    {
        $this->duration = $duration;
    }

    public function setEmpName($emp_name)
    {
        $this->emp_name = $emp_name;
    }

    public function setEmpId($emp_id)
    {
        $this->emp_id = $emp_id;
    }
}