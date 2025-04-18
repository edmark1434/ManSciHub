<?php
require_once "backend/service/UpdateAdminPassword.php";
class UpdateAdminPasswordController extends updateAdminPassword{

    public function UpdateAdminPass($request){
        try{
            $this->UpdateAdminPassword($request);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(["message" => $e->getMessage()]);
        }
    }
}
?>