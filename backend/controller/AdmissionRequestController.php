<?php
require_once "backend/service/AdmissionRequest.php";
class AdmissionRequestController extends AdmissionRequest{

    public function Admission($request){
        try {
            $this->AdmissionEntry($request);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(["message" => $e->getMessage()]);
        }
    }
}
?>