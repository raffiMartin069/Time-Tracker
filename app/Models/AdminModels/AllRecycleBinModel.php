<?php
final class AllRecycleBinModel

{ 
    private $ID; 
    private $LAST_NAME;  
    private $MIDDLE_NAME; 
    private $FIRST_NAME;  
    private $BIRTH_DATE; 
    private $HIRED_DATE;  
    private $EMAIL; 
    private $CONTACT;  
    private $POSITION; 
    private $SHIFT;  
    private $EMPLOYMENT_STATUS; 
    private $REQUIRED_HOURS;  

    public function __construct($data) { 
        $this->ID = $data['ID']; 
        $this->LAST_NAME = $data['LAST_NAME'];
        $this->MIDDLE_NAME = $data['MIDDLE_NAME']; 
        $this->FIRST_NAME = $data['FIRST_NAME'];
        $this->BIRTH_DATE = $data['BIRTH_DATE']; 
        $this->HIRED_DATE = $data['HIRED_DATE'];
        $this->EMAIL = $data['EMAIL']; 
        $this->CONTACT = $data['CONTACT'];
        $this->POSITION = $data['POSITION']; 
        $this->SHIFT = $data['SHIFT'];
        $this->EMPLOYMENT_STATUS = $data['EMPLOYMENT_STATUS']; 
        $this->REQUIRED_HOURS = $data['REQUIRED_HOURS'];  
      }
   
    public function getEMPID()
    {
        return $this->ID;
    }
 
    public function setEMPID($ID)
    {
        $this->ID = $ID;
    } 
 
    public function getEMPLNAME()
    {
        return $this->LAST_NAME;
    }
 
    public function setEMPLNAME($LAST_NAME)
    {
        $this->LAST_NAME = $LAST_NAME;
    }  
 
    public function getEMPMNAME()
    {
        return $this->MIDDLE_NAME;
    }
 
    public function setEMPMNAME($MIDDLE_NAME)
    {
        $this->MIDDLE_NAME = $MIDDLE_NAME;
    } 
 
    public function getEMPFNAME()
    {
        return $this->FIRST_NAME;
    }
 
    public function setEMPFNAME($FIRST_NAME)
    {
        $this->FIRST_NAME = $FIRST_NAME;
    }  
 
    public function getEMPBIRTHDATE()
    {
        return $this->BIRTH_DATE;
    }
 
    public function setEMPBIRTHDATE($BIRTH_DATE)
    {
        $this->BIRTH_DATE = $BIRTH_DATE;
    } 
 
    public function getEMPHIREDATE()
    {
        return $this->HIRED_DATE;
    }
 
    public function setEMPHIREDATE($HIRED_DATE)
    {
        $this->HIRED_DATE = $HIRED_DATE;
    }  
 
    public function getEMPEMAIL()
    {
        return $this->EMAIL;
    }
 
    public function setEMPEMAIL($EMAIL)
    {
        $this->EMAIL = $EMAIL;
    } 
 
    public function getEMPCONTACT()
    {
        return $this->CONTACT;
    }
 
    public function setEMPCONTACT($CONTACT)
    {
        $this->CONTACT = $CONTACT;
    }  
 
    public function getEMPPOSITION()
    {
        return $this->POSITION;
    }
 
    public function setEMPPOSITION($POSITION)
    {
        $this->POSITION = $POSITION;
    } 
 
    public function getEMPSHIFT()
    {
        return $this->SHIFT;
    }
 
    public function setEMPSHIFT($SHIFT)
    {
        $this->SHIFT = $SHIFT;
    } 
 
    public function getEMPSTAT()
    {
        return $this->EMPLOYMENT_STATUS;
    }
 
    public function setEMPSTAT($EMPLOYMENT_STATUS)
    {
        $this->EMPLOYMENT_STATUS = $EMPLOYMENT_STATUS;
    } 
 
    public function getEMPHRS()
    {
        return $this->REQUIRED_HOURS;
    }
 
    public function setEMPHRS($REQUIRED_HOURS)
    {
        $this->REQUIRED_HOURS = $REQUIRED_HOURS;
    } 
 }
