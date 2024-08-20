<?php
final class AllEmploymentClassificationModel

{ 
    private $EMPLOYMENT_ID; 
    private $EMPLOYMENT_NAME;  
    private $REQUIRED_HOURS; 

    public function __construct($data) { 
        $this->EMPLOYMENT_ID = $data['EMPLOYMENT_ID']; 
        $this->EMPLOYMENT_NAME = $data['EMPLOYMENT_NAME'];  
        $this->REQUIRED_HOURS = $data['REQUIRED_HOURS'];  
      }
   
    public function getEMPLOYMENTID()
    {
        return $this->EMPLOYMENT_ID;
    }
 
    public function setEMPLOYMENTID($EMPLOYMENT_ID)
    {
        $this->EMPLOYMENT_ID = $EMPLOYMENT_ID;
    } 
 
    public function getEMPLOYMENTNAME()
    {
        return $this->EMPLOYMENT_NAME;
    }
 
    public function setEMPLOYMENTNAME($EMPLOYMENT_NAME)
    {
        $this->EMPLOYMENT_NAME = $EMPLOYMENT_NAME;
    }  
 
    public function getEMPLOYMENTHRS()
    {
        return $this->REQUIRED_HOURS;
    }
 
    public function setEMPLOYMENTHRS($REQUIRED_HOURS)
    {
        $this->REQUIRED_HOURS = $REQUIRED_HOURS;
    }  
 }
