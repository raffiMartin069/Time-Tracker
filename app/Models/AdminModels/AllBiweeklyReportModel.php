<?php
final class AllBiweeklyReportModel
{
    private $BI_WKLY_ID; 
    private $REPORT_DATE;
    private $TOTAL_HOURS;
    private $EMP_ID;
    private $EMPLOYEE_NAME; 
    private $SHIFTY;
 
    public function __construct($data) {
        $this->BI_WKLY_ID = $data['BI_WKLY_ID'];
        $this->REPORT_DATE = $data['REPORT_DATE'];
        $this->TOTAL_HOURS = $data['TOTAL_HOURS'];
        $this->EMP_ID = $data['EMP_ID'];   
        $this->EMPLOYEE_NAME = $data['EMPLOYEE_NAME'];  
        $this->SHIFTY = $data['SHIFTY'];
     }
 
    /**
     * @return mixed
     */
    public function getBIWKLYID()
    {
        return $this->BI_WKLY_ID;
    }
 
    /**
     * @param mixed $BI_WKLY_ID
     */
    public function setBIWKLYID($BI_WKLY_ID)
    {
        $this->BI_WKLY_ID = $BI_WKLY_ID;
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
}