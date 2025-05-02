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
            $this->mail->addAddress($email,$fullname);
            $this->mail->Subject = $subject;
            $this->mail->Body = $this->getBody($subject,$fullname);
            $this->mail->send();
        } catch (Exception $e) {
            throw new Exception("Email doesn't send successfully ". $e);  
        }
    }

    private function getBody($subject,$fullname){
        $body = "";
        switch(strtoupper($subject)){
            case "ACCEPTED":
                $body = "<div style='font-family: Arial, sans-serif; color: #333;'>
                    <h2>Admission Result</h2><br><br>
                    <h2>Congratulations!</h2>
                    <p>Dear <b>{$fullname}</b>,</p>
                    <p>We are pleased to inform you that your admission request has been <strong style='color: green;'>accepted</strong>.</p>
                    <p>Please wait for further instructions regarding your enrollment process.</p>
                    <p>Thank you for choosing our institution!</p>
                    <br>
                    <p>Best regards,<br><strong>Admissions Office</strong></p>
                </div>";
                break;
            case "REJECTED":
                $body = "<div style='font-family: Arial, sans-serif; color: #333;'>
                    <h2>Admission Result</h2><br><br>
                    <p>Dear <b>{$fullname}</b>,</p>
                    <p>We regret to inform you that your admission request has been <strong style='color: red;'>rejected</strong>.</p>
                    <p>You may contact the admissions office for more details or reapply in the next enrollment period.</p>
                    <p>We appreciate your interest in our institution.</p>
                    <br>
                    <p>Best regards,<br><strong>Admissions Office</strong></p>
                </div>";
                break;
            case "REQUEST READY":
                $body = "<div style='font-family: Arial, sans-serif; color: #333;'>
                        <img src='https://your-school-logo-link.com/logo.png' alt='Mandaue Science High School' style='width: 150px; margin-bottom: 15px;'>
                        <h2 style='color: #27ae60;'>Document Ready for Release</h2>
                        <p>Dear <b>{$fullname}</b>,</p>
                        <p>We are pleased to inform you that your requested document is now <strong>ready to be claimed</strong> at the Registrar's Office.</p>
                        <p>Please bring a valid ID when claiming your document. If someone else will claim it on your behalf, kindly provide an authorization letter.</p>
                        <p>Thank you for your patience and for choosing <strong>Mandaue Science High School</strong>.</p>
                        <br>
                        <p>Best regards,<br><strong>Registrar's Office</strong></p>
                    </div>";
                break;
            case "REQUEST REJECTED":
                $body = "<div style='font-family: Arial, sans-serif; color: #333;'>
                    <img src='https://your-school-logo-link.com/logo.png' alt='Mandaue Science High School' style='width: 150px; margin-bottom: 15px;'>
                    <h2 style='color: #c0392b;'>Document Request Rejected</h2>
                    <p>Dear <b>{$fullname}</b>,</p>
                    <p>We regret to inform you that your document request has been <strong style='color: red;'>rejected</strong>.</p>
                    <p>This could be due to incomplete information, pending requirements, or invalid request type.</p>
                    <p>You may contact the Registrar's Office for further details or resubmit a new request.</p>
                    <p>We appreciate your understanding.</p>
                    <br>
                    <p>Best regards,<br><strong>Registrar's Office</strong></p>
                </div>";
                break;
            case "EMAIL":
                `<div style="font-family: Arial, sans-serif; padding: 20px; border: 1px solid #ddd; border-radius: 8px; background-color: #fef4f4; color: #b20000; max-width: 600px; margin: auto;">
                    <h2 style="margin-top: 0;">Document Request Failed</h2>
                    <p>The email address you used already exists in our system.</p>
                    <p><strong>Please submit your request again using the link below.</strong></p>
                    <a href="https://docs.google.com/forms/d/e/1FAIpQLSek5ijTAGq3_swRrX6x0pTdQwNAkLha_5bf_v6t5-9StvtM0Q/viewform" target="_blank" style="display: inline-block; margin-top: 15px; padding: 10px 20px; background-color: #b20000; color: white; text-decoration: none; border-radius: 4px;">Resubmit Request</a>
                </div>`;
                break;
            case "LRN":
                `<div style="font-family: Arial, sans-serif; padding: 20px; border: 1px solid #ddd; border-radius: 8px; background-color: #fef4f4; color: #b20000; max-width: 600px; margin: auto;">
                    <h2 style="margin-top: 0;">Document Request Failed</h2>
                    <p>The Lrn you used already exists in our system.</p>
                    <p><strong>Please submit your request again using the link below.</strong></p>
                    <a href="https://docs.google.com/forms/d/e/1FAIpQLSek5ijTAGq3_swRrX6x0pTdQwNAkLha_5bf_v6t5-9StvtM0Q/viewform" target="_blank" style="display: inline-block; margin-top: 15px; padding: 10px 20px; background-color: #b20000; color: white; text-decoration: none; border-radius: 4px;">Resubmit Request</a>
                </div>`;
                break;
        }
        return $body;
    }
}

?>