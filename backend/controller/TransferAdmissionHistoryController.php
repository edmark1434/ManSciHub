<?php
require_once "backend/service/TransferAdmissionHistory.php";
class TransferAdmissionHistoryController extends TransferAdmissionHistory{

    public function TransferAllAdmission(){
        try{
            $this->TransferAllAdmissionHistory();
            echo json_encode(["message" => "Admission Closed!"]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(["message"=> $e->getMessage()]);
        }   
    }
}

?>