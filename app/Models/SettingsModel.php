<?php
final class SettingsModel

{ 
    private $EMP_ID;
    private $FNAME;
    private $MNAME;  
    private $LNAME; 
    private $BIRTH_DATE;
    private $EMAIL;
    private $ECN;  
    private $IMAGE; 

    public function __construct($data) { 
        $this->EMP_ID = $data['EMP_ID'];
        $this->FNAME = $data['FNAME'];
        $this->MNAME = $data['MNAME']; 
        $this->LNAME = $data['LNAME'];
        $this->BIRTH_DATE = $data['BIRTH_DATE'];
        $this->EMAIL = $data['EMAIL'];   
        $this->ECN = $data['ECN']; 
        $this->IMAGE = $data['IMAGE'];
     }
  
    public function getPROFILEPIC()
    {
        return $this->IMAGE;
    }
 
    public function setPROFILEPIC($IMAGE)
    {
        $this->IMAGE = $IMAGE;
    }
 
    public function getEMPID()
    {
        return $this->EMP_ID;
    } 
    
    public function setEMPID($EMP_ID)
    {
        $this->EMP_ID = $EMP_ID;
    } 
    
    public function getFNAME()
    {
        return $this->FNAME;
    }
 
    public function setFNAME($FNAME)
    {
        $this->FNAME = $FNAME;
    }
 
    public function getMNAME()
    {
        return $this->MNAME;
    }
 
    public function setMNAME($MNAME)
    {
        $this->MNAME = $MNAME;
    } 
 
    public function getLNAME()
    {
        return $this->LNAME;
    }
 
    public function setLNAME($LNAME)
    {
        $this->LNAME = $LNAME;
    }
 
    public function getBIRTHDATE()
    {
        return $this->BIRTH_DATE;
    }
 
    public function setBIRTHDATE($BIRTH_DATE)
    {
        $this->BIRTH_DATE = $BIRTH_DATE;
    }
 
    public function getEMAIL()
    {
        return $this->EMAIL;
    }
 
    public function setEMAIL($EMAIL)
    {
        $this->EMAIL = $EMAIL;
    }

    public function getECN()
    {
        return $this->ECN;
    }
 
    public function setECN($ECN)
    {
        $this->ECN = $ECN;
    } 
}
