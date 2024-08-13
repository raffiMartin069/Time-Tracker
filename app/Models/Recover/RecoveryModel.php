<?php
require_once __DIR__."/../../Utilities/Sanitation.php";
require_once __DIR__."/../../Utilities/Mailing.php";
require_once __DIR__."/../../DAO/RecoveryDAO.php";
require_once __DIR__."/TokenModel.php";
class RecoveryModel
{
    private $userId = '';
    private $bday = '';
    private $email = '';
    private $token = '';

    use RecoveryDAO;

    public function __construct()
    {
        $this->token = new Token();
    }

    public function getEmail()
    {
        $email = $this->email;
        return $email;
    }

    public function setEmail($email)
    {
        if(!$this->nullCheck($email)) {
            throw new Exception("Email is required", 400);
        }
        $email_sanitized = new Sanitation();
        $sanitized = $email_sanitized->emailSanitation($email);
        $this->email = $sanitized;
    }

    public function getId()
    {
        $userId = $this->userId;
        return $userId;
    }

    public function getBday()
    {
        $bday = $this->bday;
        return $bday;
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
     * @method mixed fetchRecord()
     * This will get the record from the database
     * Instead of returning the entire arr
     */
    public function fetchRecord()
    {
        $isRecordExist = $this->validateEmail($this->email);
        foreach($isRecordExist as $record) {
            $hasToken = $record->token;
            $hasEmail = $record->email_exists;
        }
        $this->token->setToken($hasToken);
        return $hasEmail && isset($hasToken) ? $isRecordExist : [];
    }

    private function sanitizeData($raw_data)
    {
        $cleaner = new Sanitation();
        $sanitized = $cleaner->strSanitation($raw_data);
        return $sanitized;
    }

    /**
     * @deprecated
     * Currently this is not in use, however this method is created for future use.
     * The checking of token expiration is handled by the database which means it is the one who will
     */
    public function isLinkExpired($expires) {
        $currentTime = time();
        return $currentTime > $expires;
    }

    /**
     * @deprecated
     * Currently this is not in use, however this method is created for future use.
     * The checking of token expiration is handled by the database which means it is the one who will
     */
    public function generateRecoveryLink() {
        // $expirationDuration = 300;
        // $expirationTime = time() + $expirationDuration;
        
        $token = hash('sha256', bin2hex(random_bytes(16)));
        $recoveryLink = RECOVERY_REDIRECT . "&token=" . $token;
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
        // $recoveryLink = $this->generateRecoveryLink();
        // $recoveryLink = RECOVERY_REDIRECT.'/?/\/'.hash('md5', $this->token->getToken() . bin2hex(random_bytes(16)));
        $recoveryLink = RECOVERY_REDIRECT;
        return <<<HTML
            <div>
                <p>We noticed you might have had some trouble accessing your account recently.
                     To ensure your continued security and access, 
                     we'd like to help you reset your password quickly and easily.</p>
                <p>Here's what to do:</p>
                <ol>
                    <li>Click the link below to reset your password.</li>
                    <li>Re-enter your credentials (For assurance purposes.)</li>
                    <li>Follow the instructions.</li>
                </ol>
                <h3><strong>Please copy and paste this confirmation code after clicking the link.</strong></h3>
                <h4><strong>Access Token: {$this->token->getToken()}</strong></h4>
                <p>Password Reset Link: <a href="{$recoveryLink}" >Reset Password</a></p>
                <p class="mt-5"><strong>If you received this email in error:</strong>
                 We apologize for any inconvenience. Please disregard this email and delete it securely.</p>
                <p>Cheers!,</p>
                <p><strong>The WhereToNext Team</strong></p>
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
        return '<div style="padding-top: 20px;"><h3><b>Dear colleague, we hope this email finds you well.</b></h3></div>';
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
            
            $mail = new Mailing('int3rnal.test@gmail.com', $this->email, 
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