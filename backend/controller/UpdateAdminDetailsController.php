<?php
require_once "backend/service/UpdateAdminDetails.php";
class UpdateAdminDetailsController extends UpdateAdminDetails{

    public function updateAdminDetails($request){
        try{
            $this->updateAdmin($request);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(["message" => $e->getMessage()]);
        }
    }
}
?>