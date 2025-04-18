<?php
require_once "api/Service/AdmissionHistoryService.php";

class AdmissionHistoryController{
    private AdmissionHistoryService $AdmissionHistoryService;
    public function __construct()
    {
        $this->AdmissionHistoryService = new AdmissionHistoryService();
    }

    public function getAllAdmissionHistory(){
        try{
            $AdmissionHistory = $this->AdmissionHistoryService->getAllAdmissionHistory();
            echo json_encode(["message" => "Successfully get student", "data" => $AdmissionHistory]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(["message" => $e->getMessage()]);
        }
    }
    public function getAllAdmissionHistoryWithYear(){
        try{
            $AdmissionHistory = $this->AdmissionHistoryService->getAllAdmissionHistoryWithYear();
            echo json_encode(["message" => "Successfully get Admission", "data" => $AdmissionHistory]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(["message" => $e->getMessage()]);
        }
    }
    public function getAdmissionHistoryById($id){
        try{
            $AdmissionHistory = $this->AdmissionHistoryService->getAdmissionHistoryById($id);
            echo json_encode(["message" => "Successfully get AdmissionHistory", "data" => $AdmissionHistory]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(["message" => $e->getMessage()]);
        }
    }   
    public function addAdmissionHistory($AdmissionHistory): void{
        try{
            $this->AdmissionHistoryService->addAdmissionHistory($AdmissionHistory);
            echo json_encode(["message" => "Successfully added AdmissionHistory"]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(["message" => $e->getMessage()]);
        }
    }
    public function updateAdmissionHistory($AdmissionHistory){
        try{
            $this->AdmissionHistoryService->updateAdmissionHistory($AdmissionHistory);
            echo json_encode(["message" => "Successfully updated AdmissionHistory"]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(["message" => $e->getMessage()]);
        }
    }

    public function deleteAdmissionHistory($id)
    {
        try{
            $this->AdmissionHistoryService->deleteAdmissionHistory($id);
            echo json_encode(["message" => "Successfully deleted AdmissionHistory {$id}"]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(["message" => $e->getMessage()]);
        }
    }
}
?>