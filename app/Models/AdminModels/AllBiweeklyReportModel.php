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
    
    public function getBIWKLYID()
    {
        return $this->BI_WKLY_ID;
    }
 
    public function setBIWKLYID($BI_WKLY_ID)
    {
        $this->BI_WKLY_ID = $BI_WKLY_ID;
    }
 
    public function getREPORTDATE()
    {
        return $this->REPORT_DATE;
    }
    
    public function setREPORTDATE($REPORT_DATE)
    {
        $this->REPORT_DATE = $REPORT_DATE;
    }
 
    public function getTOTALHRS()
    {
        return $this->TOTAL_HOURS;
    }
 
    public function setTOTALHRS($TOTAL_HOURS)
    {
        $this->TOTAL_HOURS = $TOTAL_HOURS;
    }
 
    public function getEMPID()
    {
        return $this->EMP_ID;
    }
 
    public function setEMPID($EMP_ID)
    {
        $this->EMP_ID = $EMP_ID;
    }
    
    public function getEMPNAME()
    {
        return $this->EMPLOYEE_NAME;
    }
 
    public function setEMPNAME($EMPLOYEE_NAME)
    {
        $this->EMPLOYEE_NAME = $EMPLOYEE_NAME;
    }  

    public function getSHIFTY()
    {
        return $this->SHIFTY;
    }

    public function setSHIFTY($SHIFTY)
    {
        $this->SHIFTY = $SHIFTY;
    } 
}
