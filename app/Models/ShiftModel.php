<?php
/**
 * This class is only intended for shift id and shift name
 * Another class will hold the complete shift table details.
 */
class ShiftModel
{
    private $SHIFT_ID;
    private $SHIFT_NAME;

    public function getShiftID()
    {
        return $this->SHIFT_ID;
    }
    public function setShiftID($SHIFT_ID)
    {
        $this->SHIFT_ID = $SHIFT_ID;
        return $this;
    }

    public function getShiftName()
    {
        return $this->SHIFT_NAME;
    }
    public function setShiftName($SHIFT_NAME)
    {
        $this->SHIFT_NAME = $SHIFT_NAME;
        return $this;
    }
}