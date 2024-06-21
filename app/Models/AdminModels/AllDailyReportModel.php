<?php
final class AllDailyReportModel 
{
    private $DAILY_ID;
    private $EMP_ID;
    private $DATE;
    private $CLOCK_IN; 
    private $BREAK_IN;
    private $BREAK_OUT;
    private $CLOCK_OUT;
    private $DURATION;
    private $HRS_WORKED;  
    private $EMPLOYEE_NAME;

    public function __construct($data) {
        $this->DAILY_ID = $data['DAILY_ID'];
        $this->EMP_ID = $data['EMP_ID'];
        $this->EMPLOYEE_NAME = $data['EMPLOYEE_NAME'];
        $this->DATE = $data['DATE'];
        $this->CLOCK_IN = $data['CLOCK_IN'];
        $this->BREAK_IN = $data['BREAK_IN'];
        $this->BREAK_OUT = $data['BREAK_OUT'];
        $this->DURATION = $data['DURATION'];
        $this->CLOCK_OUT = $data['CLOCK_OUT'];    
        $this->HRS_WORKED = $data['HRS_WORKED']; 
     }

     /**
     * @return mixed
     */
    public function getDAILYID()
    {
        return $this->DAILY_ID;
    }

    /**
     * @param mixed $DAILY_ID
     */
    public function setDAILYID($DAILY_ID)
    {
        $this->DAILY_ID = $DAILY_ID;
    } 

    /**
     * @return mixed
     */
    public function getEMPID()
    {
        return $this->EMP_ID;
    }

    /**
     * @param mixed $EMP_ID
     */
    public function setEMPID($EMP_ID)
    {
        $this->EMP_ID = $EMP_ID;
    }  

    /**
     * @return mixed
     */
    public function getEMPNAME()
    {
        return $this->EMPLOYEE_NAME;
    }

    /**
     * @param mixed $EMPLOYEE_NAME
     */
    public function setEMPNAME($EMPLOYEE_NAME)
    {
        $this->EMPLOYEE_NAME = $EMPLOYEE_NAME;
    }  

    /**
     * @return mixed
     */
    public function getDATE()
    {
        return $this->DATE;
    }

    /**
     * @param mixed $DATE
     */
    public function setDATE($DATE)
    {
        $this->DATE = $DATE;
    }

    /**
     * @return mixed
     */
    public function getCLOCKIN()
    {
        return $this->CLOCK_IN;
    }

    /**
     * @param mixed $CLOCK_IN
     */
    public function setCLOCKIN($CLOCK_IN)
    {
        $this->CLOCK_IN = $CLOCK_IN;
    }

    /**
     * @return mixed
     */
    public function getCLOCKOUT()
    {
        return $this->CLOCK_OUT;
    }

    /**
     * @param mixed $CLOCK_OUT
     */
    public function setCLOCKOUT($CLOCK_OUT)
    {
        $this->CLOCK_OUT = $CLOCK_OUT;
    }

    /**
     * @return mixed
     */
    public function getBREAKIN()
    {
        return $this->BREAK_IN;
    }

    /**
     * @param mixed $BREAK_IN
     */
    public function setBREAKIN($BREAK_IN)
    {
        $this->BREAK_IN = $BREAK_IN;
    }

    /**
     * @return mixed
     */
    public function getBREAKOUT()
    {
        return $this->BREAK_OUT;
    }

    /**
     * @param mixed $BREAK_OUT
     */
    public function setBREAKOUT($BREAK_OUT)
    {
        $this->BREAK_OUT = $BREAK_OUT;
    }

    /**
     * @return mixed
     */
    public function getDURATION()
    {
        return $this->DURATION;
    }

    /**
     * @param mixed $DURATION
     */
    public function setDURATION($DURATION)
    {
        $this->DURATION = $DURATION;
    }

    /**
     * @return mixed
     */
    public function getHRSWORKED()
    {
        return $this->HRS_WORKED;
    }

    /**
     * @param mixed $HRS_WORKED
     */
    public function setHRSWORKED($HRS_WORKED)
    {
        $this->HRS_WORKED = $HRS_WORKED;
    }

     
}