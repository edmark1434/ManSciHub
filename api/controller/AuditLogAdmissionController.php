<?php
require_once "api/Service/AuditLogAdmissionService.php";

class AuditLogAdmissionController{
    private AuditLogAdmissionService $auditLogAdmissionService;
    public function __construct()
    {
        $this->auditLogAdmissionService = new AuditLogAdmissionService();
    }

        public function getAllAuditLogAdmission(){
        try{
            $ChangeHistory = $this->auditLogAdmissionService->getAllAuditLogAdmission();
            echo json_encode(["message" => "Successfully get added Audit log Admission", "data" => $ChangeHistory]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(["message" => $e->getMessage()]);
        }
    }
    public function getAuditLogAdmissionById($id){
        try{
            $ChangeHistory = $this->auditLogAdmissionService->getAuditLogAdmissionById($id);
            echo json_encode(["message" => "Successfully get added Audit log Admission", "data" => $ChangeHistory]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(["message" => $e->getMessage()]);
        }
    }   
    public function addAuditLogAdmission($ChangeHistory): void{
        try{
            $this->auditLogAdmissionService->addAuditLogAdmission($ChangeHistory);
            echo json_encode(["message" => "Successfully added Audit log Admission"]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(["message" => $e->getMessage()]);
        }
    }
}
?>