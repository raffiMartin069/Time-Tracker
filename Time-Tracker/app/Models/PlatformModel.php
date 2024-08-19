<?php
class PlatformModel
{
    use AdminDAO;

    private $platform_id;
    private $platform_name;

    public function fetchAllPlatform()
    {
        $platforms = $this->fetchAllPlatform();
        return $platforms;
    }

    public function __construct($platform_id=null, $platform_name=null)
    {
        $this->platform_id = $platform_id;
        $this->platform_name = $platform_name;
    }

    public function getPlatformId()
    {
        return $this->platform_id;
    }

    public function getPlatformName()
    {
        return $this->platform_name;
    }

    public function setPlatformId($platform_id)
    {
        $this->platform_id = $platform_id;
    }

    public function setPlatformName($platform_name)
    {
        $this->platform_name = $platform_name;
    }
}