<?php
require_once "backend/service/TransferRequestHistory.php";
class TransferRequestHistoryController extends TransferRequestHistory{
    
    public function transferRequestHistory($request){
        try{
            $this->transferRequest($request);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(["message" => $e->getMessage()]);
        }
    }
}
?>