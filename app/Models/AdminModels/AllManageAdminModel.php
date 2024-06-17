<?php
final class AllManageAdminModel

{ 
    private $EMP_ID;
    private $FNAME;
    private $MNAME;  
    private $LNAME; 
    private $BIRTH_DATE;
    private $HIRED_DATE;


    public function __construct($data) { 
        $this->EMP_ID = $data['EMP_ID'];
        $this->FNAME = $data['FNAME'];
        $this->MNAME = $data['MNAME']; 
        $this->LNAME = $data['LNAME'];
        $this->BIRTH_DATE = $data['BIRTH_DATE'];
        $this->HIRED_DATE = $data['HIRED_DATE']; 
 
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
    public function getFNAME()
    {
        return $this->FNAME;
    }

    /**
     * @param mixed $FNAME
     */
    public function setFNAME($FNAME)
    {
        $this->FNAME = $FNAME;
    }

    /**
     * @return mixed
     */
    public function getMNAME()
    {
        return $this->MNAME;
    }

    /**
     * @param mixed $MNAME
     */
    public function setMNAME($MNAME)
    {
        $this->MNAME = $MNAME;
    } 

    /**
     * @return mixed
     */
    public function getLNAME()
    {
        return $this->LNAME;
    }

    /**
     * @param mixed $LNAME
     */
    public function setLNAME($LNAME)
    {
        $this->LNAME = $LNAME;
    }

    /**
     * @return mixed
     */
    public function getBIRTHDATE()
    {
        return $this->BIRTH_DATE;
    }

    /**
     * @param mixed $BIRTH_DATE
     */
    public function setBIRTHDATE($BIRTH_DATE)
    {
        $this->BIRTH_DATE = $BIRTH_DATE;
    } 

    /**
     * @return mixed
     */
    public function getHIREDDATE()
    {
        return $this->HIRED_DATE;
    }

    /**
     * @param mixed $HIRED_DATE
     */
    public function setHIREDDATE($HIRED_DATE)
    {
        $this->HIRED_DATE = $HIRED_DATE;
    } 
}