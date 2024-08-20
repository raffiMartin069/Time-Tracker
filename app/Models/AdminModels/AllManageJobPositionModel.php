<?php
final class AllManageJobPositionModel

{ 
    private $TITLE_ID; 
    private $TITLE_NAME;  

    public function __construct($data) { 
        $this->TITLE_ID = $data['TITLE_ID']; 
        $this->TITLE_NAME = $data['TITLE_NAME'];  
      }
   
    public function getTITLEID()
    {
        return $this->TITLE_ID;
    }

    public function setTITLEID($TITLE_ID)
    {
        $this->TITLE_ID = $TITLE_ID;
    } 
 
    public function getTITLENAME()
    {
        return $this->TITLE_NAME;
    }
 
    public function setTITLENAME($TITLE_NAME)
    {
        $this->TITLE_NAME = $TITLE_NAME;
    }  
 }
