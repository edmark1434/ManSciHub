<?php
require_once "api/Service/RequestHistoryService.php";

class RequestHistoryController{
    private RequestHistoryService $RequestHistory_service;
    public function __construct()
    {
        $this->RequestHistory_service = new RequestHistoryService();
    }

        public function getAllRequestHistory(){
        try{
            $RequestHistory = $this->RequestHistory_service->getAllRequestHistory();
            echo json_encode(["message" => "Successfully get student", "data" => $RequestHistory]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(["message" => $e->getMessage()]);
        }
    }
    public function getRequestHistoryById($id){
        try{
            $RequestHistory = $this->RequestHistory_service->getRequestHistoryById($id);
            echo json_encode(["message" => "Successfully get RequestHistory", "data" => $RequestHistory]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(value: ["message" => $e->getMessage()]);
        }
    }   
    public function addRequestHistory($RequestHistory): void{
        try{
            $this->RequestHistory_service->addRequestHistory($RequestHistory);
            echo json_encode(["message" => "Successfully added RequestHistory"]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(["message" => $e->getMessage()]);
        }
    }
    public function updateRequestHistory($RequestHistory){
        try{
            $this->RequestHistory_service->updateRequestHistory($RequestHistory);
            echo json_encode(["message" => "Successfully updated RequestHistory"]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(["message" => $e->getMessage()]);
        }
    }

    public function deleteRequestHistory($id)
    {
        try{
            $this->RequestHistory_service->deleteRequestHistory($id);
            echo json_encode(["message" => "Successfully deleted RequestHistory {$id}"]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(["message" => $e->getMessage()]);
        }
    }
}
?>