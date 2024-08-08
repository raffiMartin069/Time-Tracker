<?php
final class EmployeeDailyReportModel

{
    private $DAILY_ID; 
    private $DATE;
    private $CLOCK_IN; 
    private $LUNCH_IN;
    private $LUNCH_OUT;
    private $LUNCH_DURATION;
    private $TOTAL_BREAK;
    private $CLOCK_OUT; 
    private $HRS_WORKED;   

    public function __construct($data) {
        $this->DAILY_ID = $data['DAILY_ID']; 
        $this->DATE = $data['DATE'];
        $this->CLOCK_IN = $data['CLOCK_IN'];
        $this->LUNCH_IN = $data['LUNCH_IN'];
        $this->LUNCH_OUT = $data['LUNCH_OUT'];
        $this->LUNCH_DURATION = $data['LUNCH_DURATION'];
        $this->TOTAL_BREAK = $data['TOTAL_BREAK'];
        $this->CLOCK_OUT = $data['CLOCK_OUT'];    
        $this->HRS_WORKED = $data['HRS_WORKED']; 
     }
 
    public function getDAILYID()
    {
        return $this->DAILY_ID;
    } 
    
    public function setDAILYID($DAILY_ID)
    {
        $this->DAILY_ID = $DAILY_ID;
    } 
 
    public function getDATE()
    {
        return $this->DATE;
    }
 
    public function setDATE($DATE)
    {
        $this->DATE = $DATE;
    }
 
    public function getCLOCKIN()
    {
        return $this->CLOCK_IN;
    }
 
    public function setCLOCKIN($CLOCK_IN)
    {
        $this->CLOCK_IN = $CLOCK_IN;
    }
 
    public function getCLOCKOUT()
    {
        return $this->CLOCK_OUT;
    }
 
    public function setCLOCKOUT($CLOCK_OUT)
    {
        $this->CLOCK_OUT = $CLOCK_OUT;
    }
 
    public function getLUNCHIN()
    {
        return $this->LUNCH_IN;
    }
 
    public function setLUNCHIN($LUNCH_IN)
    {
        $this->LUNCH_IN = $LUNCH_IN;
    }
 
    public function getLUNCHOUT()
    {
        return $this->LUNCH_OUT;
    }
 
    public function setLUNCHOUT($LUNCH_OUT)
    {
        $this->LUNCH_OUT = $LUNCH_OUT;
    }
 
    public function getLUNCHDURATION()
    {
        return $this->LUNCH_DURATION;
    }
 
    public function setDURATION($LUNCH_DURATION)
    {
        $this->LUNCH_DURATION = $LUNCH_DURATION;
    }

    public function getTOTALBREAK()
    {
        return $this->TOTAL_BREAK;
    }
 
    public function setTOTALBREAK($TOTAL_BREAK)
    {
        $this->TOTAL_BREAK = $TOTAL_BREAK;
    }
 
    public function getHRSWORKED()
    {
        return $this->HRS_WORKED;
    }
 
    public function setHRSWORKED($HRS_WORKED)
    {
        $this->HRS_WORKED = $HRS_WORKED;
    } 
}
