<?php
require_once "backend/service/Login.php";

class LoginController extends Login{
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