<?php
class MeetingLogModel
{

    use AdminDAO;

    private $date;
    private $meeting_title;
    private $meeting_description;
    private $huddle_start;
    private $huddle_end;
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

    public function setHuddleStart($huddle_start)
    {
        $this->huddle_start = $huddle_start;
    }

    public function setHuddleEnd($huddle_end)
    {
        $this->huddle_end = $huddle_end;
    }

    public function getHuddleStart()
    {
        return $this->huddle_start;
    }

    public function getHuddleEnd()
    {
        return $this->huddle_end;
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

    public function getPlatform()
    {
        return $this->platform;
    }

    public function getLink()
    {
        return $this->link;
    }

    
}