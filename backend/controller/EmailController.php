<?php
require_once "backend/service/EmailService.php";
class EmailController extends EmailService{

    public function EmailNotification($student){
        try {
            $this->sendEmail($student);
            echo json_encode(["message" => "Email Sent Successfully!"]);
        } catch (Exception $e) {
            echo json_encode(["message" => $e->getMessage()]);
        }
    }
}
?>