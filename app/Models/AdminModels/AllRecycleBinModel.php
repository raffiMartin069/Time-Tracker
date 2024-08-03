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
  
    /**
     * @return mixed
     */
    public function getEMPID()
    {
        return $this->ID;
    }

    /**
     * @param mixed $ID
     */
    public function setEMPID($ID)
    {
        $this->ID = $ID;
    } 

    /**
     * @return mixed
     */
    public function getEMPLNAME()
    {
        return $this->LAST_NAME;
    }

    /**
     * @param mixed $LAST_NAME
     */
    public function setEMPLNAME($LAST_NAME)
    {
        $this->LAST_NAME = $LAST_NAME;
    }  

    /**
     * @return mixed
     */
    public function getEMPMNAME()
    {
        return $this->MIDDLE_NAME;
    }

    /**
     * @param mixed $MIDDLE_NAME
     */
    public function setEMPMNAME($MIDDLE_NAME)
    {
        $this->MIDDLE_NAME = $MIDDLE_NAME;
    } 

    /**
     * @return mixed
     */
    public function getEMPFNAME()
    {
        return $this->FIRST_NAME;
    }

    /**
     * @param mixed $FIRST_NAME
     */
    public function setEMPFNAME($FIRST_NAME)
    {
        $this->FIRST_NAME = $FIRST_NAME;
    }  

    /**
     * @return mixed
     */
    public function getEMPBIRTHDATE()
    {
        return $this->BIRTH_DATE;
    }

    /**
     * @param mixed $BIRTH_DATE
     */
    public function setEMPBIRTHDATE($BIRTH_DATE)
    {
        $this->BIRTH_DATE = $BIRTH_DATE;
    } 

    /**
     * @return mixed
     */
    public function getEMPHIREDATE()
    {
        return $this->HIRED_DATE;
    }

    /**
     * @param mixed $HIRED_DATE
     */
    public function setEMPHIREDATE($HIRED_DATE)
    {
        $this->HIRED_DATE = $HIRED_DATE;
    }  

    /**
     * @return mixed
     */
    public function getEMPEMAIL()
    {
        return $this->EMAIL;
    }

    /**
     * @param mixed $EMAIL
     */
    public function setEMPEMAIL($EMAIL)
    {
        $this->EMAIL = $EMAIL;
    } 

    /**
     * @return mixed
     */
    public function getEMPCONTACT()
    {
        return $this->CONTACT;
    }

    /**
     * @param mixed $CONTACT
     */
    public function setEMPCONTACT($CONTACT)
    {
        $this->CONTACT = $CONTACT;
    }  

    /**
     * @return mixed
     */
    public function getEMPPOSITION()
    {
        return $this->POSITION;
    }

    /**
     * @param mixed $POSITION
     */
    public function setEMPPOSITION($POSITION)
    {
        $this->POSITION = $POSITION;
    } 

    /**
     * @return mixed
     */
    public function getEMPSHIFT()
    {
        return $this->SHIFT;
    }

    /**
     * @param mixed $SHIFT
     */
    public function setEMPSHIFT($SHIFT)
    {
        $this->SHIFT = $SHIFT;
    } 
    
    /**
     * @return mixed
     */
    public function getEMPSTAT()
    {
        return $this->EMPLOYMENT_STATUS;
    }

    /**
     * @param mixed $EMPLOYMENT_STATUS
     */
    public function setEMPSTAT($EMPLOYMENT_STATUS)
    {
        $this->EMPLOYMENT_STATUS = $EMPLOYMENT_STATUS;
    } 

    /**
     * @return mixed
     */
    public function getEMPHRS()
    {
        return $this->REQUIRED_HOURS;
    }

    /**
     * @param mixed $REQUIRED_HOURS
     */
    public function setEMPHRS($REQUIRED_HOURS)
    {
        $this->REQUIRED_HOURS = $REQUIRED_HOURS;
    } 
 }