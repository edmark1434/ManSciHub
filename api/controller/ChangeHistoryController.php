<?php
require_once "api/Service/ChangeHistoryService.php";

class ChangeHistoryController{
    private ChangeHistoryService $ChangeHistory_service;
    public function __construct()
    {
        $this->ChangeHistory_service = new ChangeHistoryService();
    }

        public function getAllChangeHistory(){
        try{
            $ChangeHistory = $this->ChangeHistory_service->getAllChangeHistory();
            echo json_encode(["message" => "Successfully get student", "data" => $ChangeHistory]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(["message" => $e->getMessage()]);
        }
    }
    public function getChangeHistoryById($id){
        try{
            $ChangeHistory = $this->ChangeHistory_service->getChangeHistoryById($id);
            echo json_encode(["message" => "Successfully get ChangeHistory", "data" => $ChangeHistory]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(["message" => $e->getMessage()]);
        }
    }   
    public function addChangeHistory($ChangeHistory): void{
        try{
            $this->ChangeHistory_service->addChangeHistory($ChangeHistory);
            echo json_encode(["message" => "Successfully added ChangeHistory"]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(["message" => $e->getMessage()]);
        }
    }
    public function updateChangeHistory($ChangeHistory){
        try{
            $this->ChangeHistory_service->updateChangeHistory($ChangeHistory);
            echo json_encode(["message" => "Successfully updated ChangeHistory"]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(["message" => $e->getMessage()]);
        }
    }

    public function deleteChangeHistory($id)
    {
        try{
            $this->ChangeHistory_service->deleteChangeHistory($id);
            echo json_encode(["message" => "Successfully deleted ChangeHistory {$id}"]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(["message" => $e->getMessage()]);
        }
    }
}
?>