<?php
require_once "backend/service/login.php";

class LoginController extends login{
    public function loginController($username,$password){
        try{
            $admin = $this->login($username,$password);
            echo json_encode(["message" => "Successfully login!", "data" => $admin]);
        } catch (Exception $e) {
            http_response_code(401);
            echo json_encode( ["message" => $e->getMessage()]);
        }
    }
}
?>