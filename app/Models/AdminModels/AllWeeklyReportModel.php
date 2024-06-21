<?php
final class AllWeeklyReportModel
{
    private $WKLY_ID;
    private $REPORT_DATE;
    private $TOTAL_HOURS;
    private $EMP_ID;
    private $EMPLOYEE_NAME; 
    private $APPR_STATUS;
    private $ACKNOWLEDGED_BY;

    public function __construct($data) {
        $this->WKLY_ID = $data['WKLY_ID'];
        $this->REPORT_DATE = $data['REPORT_DATE'];
        $this->TOTAL_HOURS = $data['TOTAL_HOURS'];
        $this->EMP_ID = $data['EMP_ID'];   
        $this->EMPLOYEE_NAME = $data['EMPLOYEE_NAME']; 
        $this->APPR_STATUS = $data['APPR_STATUS'];
        $this->ACKNOWLEDGED_BY = $data['ACKNOWLEDGED_BY'];
     } 

    /**
     * @return mixed
     */
    public function getWKLYID()
    {
        return $this->WKLY_ID;
    }
 
    /**
     * @param mixed $WKLY_ID
     */
    public function setWKLYID($WKLY_ID)
    {
        $this->WKLY_ID = $WKLY_ID;
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
    public function getTOTALHRS()
    {
        return $this->TOTAL_HOURS;
    }
 
    /**
     * @param mixed $TOTAL_HOURS
     */
    public function setTOTALHRS($TOTAL_HOURS)
    {
        $this->TOTAL_HOURS = $TOTAL_HOURS;
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
    public function getAPPRSTAT()
    {
        return $this->APPR_STATUS;
    }
 
    /**
     * @param mixed $APPR_STATUS
     */
    public function setAPPRSTAT($APPR_STATUS)
    {
        $this->APPR_STATUS = $APPR_STATUS;
    }

    /**
     * @return mixed
     */
    public function getACKNOWLEDGEDBY()
    {
        return $this->ACKNOWLEDGED_BY;
    }
 
    /**
     * @param mixed $ACKNOWLEDGEDBY
     */
    public function setACKNOWLEDGEDBY($ACKNOWLEDGED_BY)
    {
        $this->ACKNOWLEDGED_BY = $ACKNOWLEDGED_BY;
    }
}