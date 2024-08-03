<?php
final class AllDailyReportModel 
{
    private $DAILY_ID;
    private $RECORD_ID;
    private $EMP_ID;
    private $EMPLOYEE_NAME;
    private $DATE;
    private $CLOCK_IN; 
    private $LUNCH_IN;
    private $LUNCH_OUT;
    private $LUNCH_DURATION;
    private $TOTAL_BREAK;
    private $CLOCK_OUT; 
    private $REPORT_DATE;
    private $SHIFTY;
    private $HRS_WORKED;   

    public function __construct($data) {
        $this->DAILY_ID = $data['DAILY_ID'];
        $this->RECORD_ID = $data['RECORD_ID'];
        $this->EMP_ID = $data['EMP_ID'];
        $this->EMPLOYEE_NAME = $data['EMPLOYEE_NAME'];
        $this->DATE = $data['DATE'];
        $this->CLOCK_IN = $data['CLOCK_IN'];
        $this->LUNCH_IN = $data['LUNCH_IN'];
        $this->LUNCH_OUT = $data['LUNCH_OUT'];
        $this->LUNCH_DURATION = $data['LUNCH_DURATION'];
        $this->TOTAL_BREAK = $data['TOTAL_BREAK'];
        $this->REPORT_DATE = $data['REPORT_DATE'];
        $this->SHIFTY = $data['SHIFTY'];
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
    public function getRECORDID()
    {
        return $this->RECORD_ID;
    }

    /**
     * @param mixed $RECORD_ID
     */
    public function setRECORDID($RECORD_ID)
    {
        $this->RECORD_ID = $RECORD_ID;
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
    public function getLUNCHOUT()
    {
        return $this->LUNCH_OUT;
    }

    /**
     * @param mixed $LUNCH_OUT
     */
    public function setLUNCHOUT($LUNCH_OUT)
    {
        $this->LUNCH_OUT = $LUNCH_OUT;
    }

    /**
     * @return mixed
     */
    public function getLUNCHIN()
    {
        return $this->LUNCH_IN;
    }

    /**
     * @param mixed $LUNCH_IN
     */
    public function setLUNCHIN($LUNCH_IN)
    {
        $this->LUNCH_IN = $LUNCH_IN;
    } 

    /**
     * @return mixed
     */
    public function getLUNCHDURATION()
    {
        return $this->LUNCH_DURATION;
    }

    /**
     * @param mixed $LUNCH_DURATION
     */
    public function setLUNCHDURATION($LUNCH_DURATION)
    {
        $this->LUNCH_DURATION = $LUNCH_DURATION;
    }

    /**
     * @return mixed
     */
    public function getTOTALBREAK()
    {
        return $this->TOTAL_BREAK;
    }

    /**
     * @param mixed $TOTAL_BREAK
     */
    public function setTOTALBREAK($TOTAL_BREAK)
    {
        $this->TOTAL_BREAK = $TOTAL_BREAK;
    }

    /**
     * @return mixed
     */
    public function getREPORTDATE()
    {
        return $this->REPORT_DATE;
    }

    /**
     * @param mixed $REPORT_DATE
     */
    public function setREPORTDATE($REPORT_DATE)
    {
        $this->REPORT_DATE = $REPORT_DATE;
    }

    /**
     * @return mixed
     */
    public function getSHIFTY()
    {
        return $this->SHIFTY;
    }

    /**
     * @param mixed $SHIFTY
     */
    public function setSHIFTY($SHIFTY)
    {
        $this->SHIFTY = $SHIFTY;
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