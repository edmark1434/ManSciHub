<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require "vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__,2));
$dotenv->load();
class EmailConfig{
    private PHPMailer $mail;
    public function __construct()
    {
        $this->mail = new PHPMailer(true);
        $this->mail->isSMTP();
        $this->mail->Host = 'smtp.gmail.com';
        $this->mail->SMTPAuth = true;
        $this->mail->Username = 'pizzahu1678@gmail.com';
        $this->mail->Password = $_ENV["EMAIL_APP_KEY"];     
        $this->mail->SMTPSecure = 'tls';
        $this->mail->Port = 587;
        $this->mail->isHTML(true);
    }
    public function sendMail($email,$fullname,$subject){
        try {
            $this->mail->setFrom($this->mail->Username, "ManSciHub");
            $this->mail->addAddress($email, $fullname);
            $this->mail->Subject = $subject;
            $this->mail->Body = $this->getBody($subject);
            $this->mail->send();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());  
        }
    }

    private function getBody($subject){
        $body = "<h1>hi im edmark</h1>";
        return $body;
    }
}

?>