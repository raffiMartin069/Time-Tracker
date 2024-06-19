<?php
final class AllManageAdminModel

{ 
    private $EMP_ID; 
    private $EMPLOYEE;  

    public function __construct($data) { 
        $this->EMP_ID = $data['EMP_ID']; 
        $this->EMPLOYEE = $data['EMPLOYEE'];  
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
        return $this->EMPLOYEE;
    }

    /**
     * @param mixed $EMPLOYEE
     */
    public function setEMPNAME($EMPLOYEE)
    {
        $this->EMPLOYEE = $EMPLOYEE;
    }  

 }