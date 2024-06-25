<?php
require_once __DIR__."/../../Utilities/Sanitation.php";
require_once __DIR__."/../../Utilities/Mailing.php";

class RecoveryModel
{
    private $userId = '';
    private $bday = '';

    public function getId()
    {
        return $this->userId;
    }

    public function getBday()
    {
        return $this->bday;
    }

    public function setId($id)
    {
        if(!$this->nullCheck($id)) {
            throw new Exception("ID number is required", 400);
        }

        $id_sanitized = $this->sanitizeData($id);
        $this->userId = $id_sanitized;
    }

    public function setBday($bday)
    {
        if(!$this->nullCheck($bday)) {
            throw new Exception("Birthday is required", 400);
        }

        $bday_sanitized = $this->sanitizeData($bday);
        $this->bday = $bday_sanitized;
    }

    private function sanitizeData($raw_data)
    {
        $cleaner = new Sanitation();
        $sanitized = $cleaner->strSanitation($raw_data);
        return $sanitized;
    }

    public function sendEmail()
    {
        try {
            $mail = new Mailing('int3rnal.test@gmail.com', 'rafael.d.martinez@outlook.com', 'Password Recovery');
            $mail->sendEmail();
        } catch(Exception $e) {
            throw new Exception($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @return bool
     * Check if the required fields are not null
     */
    private function nullCheck($data)
    {
        if(!isset($data) || empty($data)) {
            return false;
        }
        return true;
    }
}