<?php
require_once __DIR__ . "/../../public/vendor/autoload.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Mailing
{
    private $sender = '';
    private $recipient = '';
    private $subject = '';
    private $headers = '';

    public function __construct($sender, $recipient, $subject)
    {
        $this->sender = $sender; // Corrected from $this->sendFrom to $this->sender
        $this->recipient = $recipient; // Corrected from $this->sendTo to $this->recipient
        $this->subject = $subject;
    }


    private function companyLogo()
    {
        $path = __DIR__ . '/../../public/assets/img/login/logo_wtn.png';
        $logoCid = 'companyLogo';

        return [
            'path' => $path,
            'cid' => $logoCid
        ];
    }

    private function extractBody()
    {
        $body = file_get_contents(ROOT . "resources/Email.txt");
        return $body;
    }

    public function sendEmail()
    {
        $mail = new PHPMailer(true);
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
        // $dotenv->safeLoad();
        $dotenv->load();

        try {

            $mail->isSMTP();
            $mail->Host = $_ENV['MAIL_HOST'];
            $mail->SMTPAuth = true;
            $mail->Username = $_ENV['MAIL_USERNAME'];
            $mail->Password = $_ENV['MAIL_PASSWORD'];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = $_ENV['MAIL_PORT'];

            $mail->setFrom($this->sender);
            $mail->addAddress($this->recipient);

            $mail->isHTML(true);

            $mail->addEmbeddedImage($this->companyLogo()['path'], $this->companyLogo()['cid'], 'logo_wtn.png');
            $img = '<img src="cid:' . $this->companyLogo()['cid'] . '" alt="Company Logo" class="d-flex" style="width: 75px; height: 75px; display: block;">';
            $header = '<div style="padding-top: 20px;"><b>Dear colleague, I hope this email finds you well.</b></div>';

            // New message to add
            $recovery = RECOVERY_REDIRECT; // Assign a value to $RECOVERY_REDIRECT
            $newMessage = <<<HTML
                <div style="padding-top: 20px;">
                    <p>We noticed you might have had some trouble accessing your account recently. To ensure your continued security and access, we'd like to help you reset your password quickly and easily.</p>
                    <p>Here's what to do:</p>
                    <ol>
                        <li>Click the link below to reset your password.</li>
                        <li>Re-enter your credentials (For assurance purposes.)</li>
                        <li>Follow the instructions.</li>
                    </ol>
                    <p>Password Reset Link: <a href="{$recovery}">Reset Password</a></p>
                    <p class="mt-5">If incase that this is a mistake, kindly disregard the email.</p>
                    <p>Cheers!,</p>
                    <p>The WhereToNext Team</p>
                </div>
                HTML;

            // Concatenate the new message with the existing content
            $content = $newMessage;

            // Continue with the rest of the email setup...
            $htmlBody = $img . $header . $content;
            $mail->Body = $htmlBody;
            $mail->Subject = $this->subject;

            $mail->send();
        } catch (Exception $e) {
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode(['error' => 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo]);
            exit();
        }
    }
}