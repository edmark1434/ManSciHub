<?php
require_once "api/Service/AuditLogRequestService.php";

class AuditLogRequestController{
    private AuditLogRequestService $auditLogRequestService;
    public function __construct()
    {
        $this->auditLogRequestService = new AuditLogRequestService();
    }

        public function getAllAuditLogRequest(){
        try{
            $ChangeHistory = $this->auditLogRequestService->getAllAuditLogRequest();
            echo json_encode(["message" => "Successfully get added Audit log Request", "data" => $ChangeHistory]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(["message" => $e->getMessage()]);
        }
    }
    public function getAuditLogRequestById($id){
        try{
            $ChangeHistory = $this->auditLogRequestService->getAuditLogRequestById($id);
            echo json_encode(["message" => "Successfully get added Audit log Request", "data" => $ChangeHistory]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(["message" => $e->getMessage()]);
        }
    }   
    public function addAuditLogRequest($ChangeHistory): void{
        try{
            $this->auditLogRequestService->addAuditLogRequest($ChangeHistory);
            echo json_encode(["message" => "Successfully added Audit log Request"]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(["message" => $e->getMessage()]);
        }
    }
}
?>