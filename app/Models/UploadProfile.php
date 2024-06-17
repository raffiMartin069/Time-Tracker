<?php

final class UploadProfile
{
    private $IMAGE; 

    public function __construct($data) { 
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
}