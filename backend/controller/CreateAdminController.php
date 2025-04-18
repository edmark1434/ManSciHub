<?php

require_once "backend/service/CreateAdmin.php";
class CreateAdminController extends CreateAdmin{

    public function addAdmin($request){
        try{
            $this->CreateAdmin($request);
        } catch (Exception $e) {
            echo json_encode(["message" => $e->getMessage()]);
        }
    }
}
?>