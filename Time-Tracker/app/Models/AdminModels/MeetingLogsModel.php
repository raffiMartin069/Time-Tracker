<?php
class MeetingLogModel
{

    use AdminDAO;

    private $date;
    private $meeting_title;
    private $meeting_description;
    private $meeting_start;
    private $meeting_end;
    private $platform;
    private $link;

    public function getMeetingLogs()
    {
        return $this->adminMeetingLogs();
    }

    public function setDate($date)
    {
        $this->date = $date;
    }

    public function setMeetingTitle($meeting_title)
    {
        $this->meeting_title = $meeting_title;
    }

    public function setMeetingDescription($meeting_description)
    {
        $this->meeting_description = $meeting_description;
    }

    public function setMeetingStart($meeting_start)
    {
        $this->meeting_start = $meeting_start;
    }

    public function setMeetingEnd($meeting_end)
    {
        $this->meeting_end = $meeting_end;
    }

    public function setPlatform($platform)
    {
        $this->platform = $platform;
    }

    public function setLink($link)
    {
        $this->link = $link;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function getMeetingTitle()
    {
        return $this->meeting_title;
    }

    public function getMeetingDescription()
    {
        return $this->meeting_description;
    }

    public function getMeetingStart()
    {
        return $this->meeting_start;
    }

    public function getMeetingEnd()
    {
        return $this->meeting_end;
    }

    public function getPlatform()
    {
        return $this->platform;
    }

    public function getLink()
    {
        return $this->link;
    }

    
}