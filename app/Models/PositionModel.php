<?php
final class PositionModel
{
    private $POSITION_ID;
    private $POSITION_NAME;

    public function getPositionID()
    {
        return $this->POSITION_ID;
    }
    public function setPositionID($POSITION_ID)
    {
        $this->POSITION_ID = $POSITION_ID;
        return $this;
    }

    public function getPositionName()
    {
        return $this->POSITION_NAME;
    }
    public function setPositionName($POSITION_NAME)
    {
        $this->POSITION_NAME = $POSITION_NAME;
        return $this;
    }
}
