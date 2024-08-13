<?php
final class DailyReportModel
{
    private $ID;
    private $DATE;
    private $CLOCK_IN;
    private $CLOCK_OUT;
    private $BREAK_IN;
    private $BREAK_OUT;
    private $HRS_WORKED;
    private $HUDDLE_STATUS;
    private $BREAK_STATUS;
    private $LUNCH_STATUS;

    public function __construct($data) {
        $this->ID = $data['ID'];
        $this->DATE = $data['DATE'];
        $this->CLOCK_IN = $data['CLOCK_IN'];
        $this->CLOCK_OUT = $data['CLOCK_OUT'];  
        // $this->BREAK_IN = $data['BREAK_IN'];
        // $this->BREAK_OUT = $data['BREAK_OUT'];
        $this->BREAK_STATUS = $data['BREAK_STATUS'];
        $this->HRS_WORKED = $data['HRS_WORKED'];
        $this->HUDDLE_STATUS = $data['HUDDLE_STATUS'];
        $this->LUNCH_STATUS = $data['LUNCH_STATUS'];
    }


    public function getLUNCHSTATUS()
    {
        return $this->LUNCH_STATUS;
    }

    public function setLUNCHSTATUS($LUNCH_STATUS)
    {
        $this->LUNCH_STATUS = $LUNCH_STATUS;
    }

    /**
     * @return mixed
     */
    public function getID()
    {
        return $this->ID;
    }

    /**
     * @param mixed $ID
     */
    public function setID($ID)
    {
        $this->ID = $ID;
    }

    /**
     * @return mixed
     */
    public function getDATE()
    {
        return $this->DATE;
    }

    /**
     * @param mixed $DATE
     */
    public function setDATE($DATE)
    {
        $this->DATE = $DATE;
    }

    /**
     * @return mixed
     */
    public function getCLOCKIN()
    {
        return $this->CLOCK_IN;
    }

    /**
     * @param mixed $CLOCK_IN
     */
    public function setCLOCKIN($CLOCK_IN)
    {
        $this->CLOCK_IN = $CLOCK_IN;
    }

    /**
     * @return mixed
     */
    public function getCLOCKOUT()
    {
        return $this->CLOCK_OUT;
    }

    /**
     * @param mixed $CLOCK_OUT
     */
    public function setCLOCKOUT($CLOCK_OUT)
    {
        $this->CLOCK_OUT = $CLOCK_OUT;
    }

    /**
     * @return mixed
     */
    public function getBREAKIN()
    {
        return $this->BREAK_IN;
    }

    /**
     * @param mixed $BREAK_IN
     */
    public function setBREAKIN($BREAK_IN)
    {
        $this->BREAK_IN = $BREAK_IN;
    }

    /**
     * @return mixed
     */
    public function getBREAKOUT()
    {
        return $this->BREAK_OUT;
    }

    /**
     * @param mixed $BREAK_OUT
     */
    public function setBREAKOUT($BREAK_OUT)
    {
        $this->BREAK_OUT = $BREAK_OUT;
    }

    /**
     * @return mixed
     */
    public function getHRSWORKED()
    {
        return $this->HRS_WORKED;
    }

    /**
     * @param mixed $HRS_WORKED
     */
    public function setHRSWORKED($HRS_WORKED)
    {
        $this->HRS_WORKED = $HRS_WORKED;
    }

    /**
     * @return mixed
     */
    public function getHUDDLESTATUS()
    {
        return $this->HUDDLE_STATUS;
    }

    /**
     * @param mixed $HUDDLESTATUS
     */
    public function setHUDDLESTATUS($HUDDLE_STATUS)
    {
        $this->HUDDLE_STATUS = $HUDDLE_STATUS;
    }


    /**
     * @return mixed
     */
    public function getBREAKSTATUS()
    {
        return $this->BREAK_STATUS;
    }

    /**
     * @param mixed $BREAK_STATUS
     */
    public function setBREAKSTATUS($BREAK_STATUS)
    {
        $this->BREAK_STATUS = $BREAK_STATUS;
    }
}