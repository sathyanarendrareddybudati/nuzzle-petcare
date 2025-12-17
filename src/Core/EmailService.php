<?php
namespace App\Core;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class EmailService
{
    protected $mailer;

    public function __construct()
    {
        $this->mailer = new PHPMailer(true);
        $this->configure();
    }

    protected function configure()
    {
        try {
            // Server settings
            $this->mailer->isSMTP();
            $this->mailer->Host       = $_ENV['SMTP_SERVER'];
            $this->mailer->SMTPAuth   = true;
            $this->mailer->Username   = $_ENV['SMTP_USERNAME'];
            $this->mailer->Password   = $_ENV['SMTP_PASSWORD'];
            $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $this->mailer->Port       = $_ENV['SMTP_PORT'];

            //Recipients
            $this->mailer->setFrom($_ENV['SMTP_USERNAME'], 'Nuzzle PetCare');
        } catch (Exception $e) {
            // Handle exception
            error_log("PHPMailer configuration error: {$this->mailer->ErrorInfo}");
        }
    }

    public function sendEmail(string $to, string $subject, string $body): bool
    {
        try {
            $this->mailer->addAddress($to);

            // Content
            $this->mailer->isHTML(true);
            $this->mailer->Subject = $subject;
            $this->mailer->Body    = $body;

            $this->mailer->send();
            return true;
        } catch (Exception $e) {
            error_log("Message could not be sent. Mailer Error: {$this->mailer->ErrorInfo}");
            return false;
        }
    }

    public function renderTemplate(string $templatePath, array $data): string
    { ob_start();
        extract($data);
        include $templatePath;
        return ob_get_clean();
    }
}
