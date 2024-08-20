<?php

/**
 * This class is only intended for employment id, employee status name and work hours
 * Another class will hold the complete employment table details.
 */

class EmploymentModel 
{
    private $EMPLOYMENT_ID;
    private $EMPLOYMENT_TYPE;
    private $WORK_HOURS;

    public function getEmploymentID()
    {
        return $this->EMPLOYMENT_ID;
    }
    public function setEmploymentID($EMPLOYMENT_ID)
    {
        $this->EMPLOYMENT_ID = $EMPLOYMENT_ID;
        return $this;
    }
    public function getEmploymentType()
    {
        return $this->EMPLOYMENT_TYPE;
    }
    public function setEmploymentType($EMPLOYMENT_TYPE)
    {
        $this->EMPLOYMENT_TYPE = $EMPLOYMENT_TYPE;
        return $this;
    }
    public function getWorkHours()
    {
        return $this->WORK_HOURS;
    }
    public function setWorkHours($WORK_HOURS)
    {
        $this->WORK_HOURS = $WORK_HOURS;
        return $this;
    }
    
}