<?php
final class AllManageShiftsModel

{ 
    private $SHIFTING_ID; 
    private $SHIFTING_NAME;  

    public function __construct($data) { 
        $this->SHIFTING_ID = $data['SHIFTING_ID']; 
        $this->SHIFTING_NAME = $data['SHIFTING_NAME'];  
      }
   
    public function getSHIFTID()
    {
        return $this->SHIFTING_ID;
    }
 
    public function setSHIFTID($SHIFTING_ID)
    {
        $this->SHIFTING_ID = $SHIFTING_ID;
    } 

    public function getSHIFTNAME()
    {
        return $this->SHIFTING_NAME;
    }
 
    public function setSHIFTNAME($SHIFTING_NAME)
    {
        $this->SHIFTING_NAME = $SHIFTING_NAME;
    }  

 }