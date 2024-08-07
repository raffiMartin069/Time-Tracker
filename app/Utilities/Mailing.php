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
    private $body = '';
    private $img = '';
    private $imgCid = '';
    private $emailHeader = '';
    private $imgFormat = '';
    private static $mail = '';

    public function __construct(
        $sender=null, $recipient=null, $subject=null, 
        $body=null, $img=null, $imgCid=null, 
        $emailHeader=null, $imgFormat=null
        )
    {
        self::$mail = new PHPMailer(true) ?? null;
        $this->sender = $sender;
        $this->recipient = $recipient;
        $this->subject = $subject;
        $this->body = $body;
        $this->img = $img;
        $this->imgCid = $imgCid;
        $this->emailHeader = $emailHeader;
        $this->imgFormat = $imgFormat;
    }

    private static function smtpCredentials()
    {
        self::$mail->Host = $_ENV['MAIL_HOST'];
        self::$mail->Username = $_ENV['MAIL_USERNAME'];
        self::$mail->Password = $_ENV['MAIL_PASSWORD'];
        self::$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        self::$mail->Port = $_ENV['MAIL_PORT'];
    }

    public function sendEmail()
    {
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
        // $dotenv->safeLoad();
        $dotenv->load();

        try {
            self::$mail->isSMTP();
            self::smtpCredentials();
            self::$mail->SMTPAuth = true;
            self::$mail->setFrom($this->sender);
            self::$mail->addAddress($this->recipient);
            self::$mail->isHTML(true);
            self::$mail->addEmbeddedImage($this->img, $this->imgCid);
            $img = $this->imgFormat;
            $header = $this->emailHeader; 

            // Concatenate the new message with the existing content
            $content = $this->body;

            // Continue with the rest of the email setup...
            $htmlBody = $img . $header . $content;
            self::$mail->Body = $htmlBody;
            self::$mail->Subject = $this->subject;
            self::$mail->send();
            return true;
        } catch (Exception $e) {
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode(['error' => 'Message could not be sent. Mailer Error: ' . self::$mail->ErrorInfo]);
            exit();
        }
    }
}