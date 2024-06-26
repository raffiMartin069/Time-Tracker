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

    /**
     * TODO: Be right back to the method, I need to initialize this for querying the database.
     * @return bool
     */
    public function fetchRecord()
    {
        return true;
    }

    private function sanitizeData($raw_data)
    {
        $cleaner = new Sanitation();
        $sanitized = $cleaner->strSanitation($raw_data);
        return $sanitized;
    }

    public function isLinkExpired($expires) {
        $currentTime = time();
        return $currentTime > $expires;
    }

    public function generateRecoveryLink() {
        $expirationDuration = 300;
        $expirationTime = time() + $expirationDuration;
        $recoveryLink = RECOVERY_REDIRECT . "&expires=" . $expirationTime;
        return $recoveryLink;
    }

    /**
     * @return string
     * Email body template
     * There are no UI for this feature, so the email body is hardcoded.
     * However, if it requires to be dynamic, I made this method to be flexible.
     * The Mailing class in the Utilities folder is created to be reusable and dynamic
     * just to prepare for future changes or updates if time comes that the program will
     * be needing a UI. In  this case the Mailing class can be easily integrated through this
     * model of any other models.
     */
    public function emailBody()
    {
        $recoveryLink = $this->generateRecoveryLink();
        return <<<HTML
            <div style="padding-top: 20px;">
                <p>We noticed you might have had some trouble accessing your account recently.
                     To ensure your continued security and access, 
                     we'd like to help you reset your password quickly and easily.</p>
                <p>Here's what to do:</p>
                <ol>
                    <li>Click the link below to reset your password.</li>
                    <li>Re-enter your credentials (For assurance purposes.)</li>
                    <li>Follow the instructions.</li>
                </ol>
                <p>Password Reset Link: <a href="{$recoveryLink}">Reset Password</a></p>
                <p class="mt-5"><strong>If you received this email in error:</strong>
                 We apologize for any inconvenience. Please disregard this email and delete it securely.</p>
                <p>Cheers!,</p>
                <p>The WhereToNext Team</p>
            </div>
            HTML;
    }

    public function setEmailImage()
    {
        $path = __DIR__ . '/../../../public/assets/img/login/logo_wtn.png';
        $logoCid = 'companyLogo';

        return [
            'path' => $path,
            'cid' => $logoCid
        ];
    }

    public function imageFormat()
    {
        return '<img src="cid:' . $this->setEmailImage()['cid'] . '" alt="Company Logo" class="d-flex" style="width: 75px; height: 75px; display: block;">';
    }

    public function emailHeader()
    {
        return '<div style="padding-top: 20px;"><b>Dear colleague, I hope this email finds you well.</b></div>';
    }

    /**
     * @return bool
     * Send email to the user
     * Call this method to the controller to send the email.
     */
    public function sendEmail()
    {
        $email_body = $this->emailBody();
        try {
            $path = $this->setEmailImage()['path'];
            $cid = $this->setEmailImage()['cid'];
            $imgFormat = $this->imageFormat();
            $header = $this->emailHeader();
            
            $mail = new Mailing('int3rnal.test@gmail.com', 'rafael.d.martinez@outlook.com', 
            'Password Recovery', $email_body, 
            $path, $cid, 
            $header, $imgFormat);
            $result = $mail->sendEmail();
            return $result;
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