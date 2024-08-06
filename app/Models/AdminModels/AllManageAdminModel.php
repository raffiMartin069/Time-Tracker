<?php
final class AllManageAdminModel

{ 
    private $ID; 
    private $EMPLOYEE;  

    public function __construct($data) { 
        $this->ID = $data['ID']; 
        $this->EMPLOYEE = $data['EMPLOYEE'];  
      }
  
    public function getEMPID()
    {
        return $this->ID;
    }

    public function setEMPID($ID)
    {
        $this->ID = $ID;
    } 

    public function getEMPNAME()
    {
        return $this->EMPLOYEE;
    }


    public function setEMPNAME($EMPLOYEE)
    {
        $this->EMPLOYEE = $EMPLOYEE;
    }  

 }
