<?php
require_once "backend/service/UpdateAdminControls.php";
class UpdateAdminControlsController extends UpdateAdminControls{

    public function updateAdminControls($request){
        try{
            $this->updateControls($request);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(["message" => $e->getMessage()]);
        }
    }
}
?>