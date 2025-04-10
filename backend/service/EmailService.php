<?php
require_once "EmailConfig.php";
class EmailService{
    private EmailConfig $emailConfig;
    public function __construct()
    {
        $this->emailConfig = new EmailConfig();
    }
    public function sendEmail($student){
        $fullname = $student["stud_fname"] . " " . $student["stud_mname"] . " " . $student["stud_lname"] . " " . $student["stud_suffix"];
        $email = $student["stud_email"];
        $subject = $student["email_subject"];
        $this->emailConfig->sendMail($email, $fullname, $subject);
    }
}
?>