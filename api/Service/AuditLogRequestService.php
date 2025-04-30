<?php

require_once "api/Repository/AuditLogRequestRepository.php";
require_once "api/Repository/AdminRepository.php";
require_once "api/Service/ServiceLogic.php";
require_once "api/Model/AuditLogRequest.php";

class AuditLogRequestService{
    private AuditLogRequestRepository $auditLogRequestRepository;
    private AdminRepository $adminRepository;
    private ServiceLogic $serviceLogic;

    public function __construct(){
        $this->auditLogRequestRepository = new AuditLogRequestRepository();
        $this->serviceLogic = new ServiceLogic();
        $this->adminRepository = new AdminRepository();
    }
    public function getAllAuditLogRequest()
    {
        $AuditLogRequest = $this->auditLogRequestRepository->getAllAuditLogRequest();
        return $this->serviceLogic->checkGetMethod($AuditLogRequest, "No Change History Found");
    }
    public function getAuditLogRequestById($id){
        $AuditLogRequest = $this->auditLogRequestRepository->getAuditLogRequestById($id);
        return $this->serviceLogic->checkGetMethod($AuditLogRequest, "Change History with id {$id} does not exist!");

    }
    public function addAuditLogRequest($AuditLogRequest){
        $this->serviceLogic->checkExistence($AuditLogRequest["admin_id"], $this->adminRepository, 'getAdminById', "Admin with id {$AuditLogRequest["admin_id"]} does not exist");
        $AuditLogRequest = $this->AuditLogRequestObject($AuditLogRequest);
        $this->auditLogRequestRepository->addAuditLogRequest($AuditLogRequest);
    }



    private function AuditLogRequestObject($entity){
        $auditLogAdmission = new AuditLogAdmission();
        $auditLogAdmission->chg_id = $entity["chg_id"] ?? NULL;
        $auditLogAdmission->req_track_id = $entity["req_track_id"] ?? NULL;
        $auditLogAdmission->chg_old_val = $entity["chg_old_val"] ?? NULL;
        $auditLogAdmission->chg_new_val = $entity["chg_new_val"] ?? NULL;
        $auditLogAdmission->chg_datetime = $entity["chg_datetime"] ?? NULL;
        $auditLogAdmission->admin_id = $entity["admin_id"] ?? NULL;
        return $auditLogAdmission;
    }
    private function AuditLogRequestObjectList($AuditLogRequest){
        $AuditLogRequestList = [];
        foreach($AuditLogRequest as $chg){
            $AuditLogRequestList[] = $this->AuditLogRequestObject($chg);
        }
        return $AuditLogRequestList;
    }
}

?>