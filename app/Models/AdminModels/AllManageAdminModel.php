<?php
final class AllManageAdminModel

{ 
    private $ID; 
    private $EMPLOYEE;  

    public function __construct($data) { 
        $this->ID = $data['ID']; 
        $this->EMPLOYEE = $data['EMPLOYEE'];  
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