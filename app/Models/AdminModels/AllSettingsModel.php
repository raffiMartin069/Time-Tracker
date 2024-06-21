<?php
final class AllSettingsModel

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
 
      /**
     * @return mixed
     */
    public function getPROFILEPIC()
    {
        return $this->IMAGE;
    }

    /**
     * @param mixed $IMAGE
     */
    public function setPROFILEPIC($IMAGE)
    {
        $this->IMAGE = $IMAGE;
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
    public function getEMAIL()
    {
        return $this->EMAIL;
    }

    /**
     * @param mixed $EMAIL
     */
    public function setEMAIL($EMAIL)
    {
        $this->EMAIL = $EMAIL;
    }

     /**
     * @return mixed
     */
    public function getECN()
    {
        return $this->ECN;
    }

    /**
     * @param mixed $ECN
     */
    public function setECN($ECN)
    {
        $this->ECN = $ECN;
    } 
}