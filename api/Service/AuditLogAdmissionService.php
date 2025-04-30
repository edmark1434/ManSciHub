<?php

require_once "api/Repository/AuditLogAdmissionRepository.php";
require_once "api/Repository/AdminRepository.php";
require_once "api/Service/ServiceLogic.php";
require_once "api/Model/AuditLogAdmission.php";

class AuditLogAdmissionService{
    private AuditLogAdmissionRepository $AuditLogAdmissionRepository;
    private AdminRepository $adminRepository;
    private ServiceLogic $serviceLogic;

    public function __construct(){
        $this->AuditLogAdmissionRepository = new AuditLogAdmissionRepository();
        $this->serviceLogic = new ServiceLogic();
        $this->adminRepository = new AdminRepository();
    }
    public function getAllAuditLogAdmission()
    {
        $AuditLogAdmission = $this->AuditLogAdmissionRepository->getAllAuditLogAdmission();
        return $this->serviceLogic->checkGetMethod($AuditLogAdmission, "No Change History Found");
    }
    public function getAuditLogAdmissionById($id){
        $AuditLogAdmission = $this->AuditLogAdmissionRepository->getAuditLogAdmissionById($id);
        return $this->serviceLogic->checkGetMethod($AuditLogAdmission, "Change History with id {$id} does not exist!");

    }
    public function addAuditLogAdmission($AuditLogAdmission){
        $this->serviceLogic->checkExistence($AuditLogAdmission["admin_id"], $this->adminRepository, 'getAdminById', "Admin with id {$AuditLogAdmission["admin_id"]} does not exist");
        $AuditLogAdmission = $this->AuditLogAdmissionObject($AuditLogAdmission);
        $this->AuditLogAdmissionRepository->addAuditLogAdmission($AuditLogAdmission);
    }



    private function AuditLogAdmissionObject($entity){
        $auditLogAdmission = new AuditLogAdmission();
        $auditLogAdmission->chg_id = $entity["chg_id"] ?? NULL;
        $auditLogAdmission->adms_id = $entity["adms_id"] ?? NULL;
        $auditLogAdmission->chg_old_val = $entity["chg_old_val"] ?? NULL;
        $auditLogAdmission->chg_new_val = $entity["chg_new_val"] ?? NULL;
        $auditLogAdmission->chg_datetime = $entity["chg_datetime"] ?? NULL;
        $auditLogAdmission->admin_id = $entity["admin_id"] ?? NULL;
        return $auditLogAdmission;
    }
    private function AuditLogAdmissionObjectList($AuditLogAdmission){
        $AuditLogAdmissionList = [];
        foreach($AuditLogAdmission as $chg){
            $AuditLogAdmissionList[] = $this->AuditLogAdmissionObject($chg);
        }
        return $AuditLogAdmissionList;
    }
}

?>