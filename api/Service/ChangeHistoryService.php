<?php

require_once "api/Repository/ChangeHistoryRepository.php";
require_once "api/Repository/AdminRepository.php";
require_once "api/Service/ServiceLogic.php";
require_once "api/Model/ChangeHistory.php";

class ChangeHistoryService{
    private ChangeHistoryRepository $changeHistoryRepository;
    private AdminRepository $adminRepository;
    private ServiceLogic $serviceLogic;

    public function __construct(){
        $this->changeHistoryRepository = new ChangeHistoryRepository();
        $this->serviceLogic = new ServiceLogic();
        $this->adminRepository = new AdminRepository();
    }
    public function getAllChangeHistory()
    {
        $changeHistory = $this->changeHistoryRepository->getAllChangeHistory();
        return $this->serviceLogic->checkGetMethod($changeHistory, "No Change History Found");
    }
    public function getChangeHistoryById($id){
        $changeHistory = $this->changeHistoryRepository->getChangeHistoryById($id);
        return $this->serviceLogic->checkGetMethod($changeHistory, "Change History with id {$id} does not exist!");

    }
    public function addChangeHistory($changeHistory){
        $this->serviceLogic->checkExistence($changeHistory["admin_id"], $this->adminRepository, 'getAdminById', "Admin with id {$changeHistory["admin_id"]} does not exist");
        $changeHistory = $this->ChangeHistoryObject($changeHistory);
        $this->changeHistoryRepository->addChangeHistory($changeHistory);
    }
    public function updateChangeHistory($changeHistory){
        $this->serviceLogic->checkExistence($changeHistory["chg_id"], $this->changeHistoryRepository,'getChangeHistoryById',"Change History with id {$changeHistory["chg_id"]} does not exist" );
        $this->serviceLogic->checkExistence($changeHistory["admin_id"], $this->adminRepository, 'getAdminById', "Admin with id {$changeHistory["admin_id"]} does not exist");
        $changeHistory = $this->ChangeHistoryObject($changeHistory);
        $this->changeHistoryRepository->updateChangeHistory($changeHistory);
    }

    public function deleteChangeHistory($id)
    {
        $this->serviceLogic->checkExistence($id, $this->changeHistoryRepository,'getChangeHistoryById',"Change History with id {$id} does not exist" );
        $this->changeHistoryRepository->deleteChangeHistory($id);
    }

    private function ChangeHistoryObject($entity){
        $changeHistoryObject = new ChangeHistory();
        $changeHistoryObject->chg_id = $entity["chg_id"] ?? NULL;
        $changeHistoryObject->chg_table = $entity["chg_table"] ?? NULL;
        $changeHistoryObject->chg_table_id = $entity["chg_table_id"] ?? NULL;
        $changeHistoryObject->chg_old_val = $entity["chg_old_val"] ?? NULL;
        $changeHistoryObject->chg_new_val = $entity["chg_new_val"] ?? NULL;
        $changeHistoryObject->chg_datetime = $entity["chg_datetime"] ?? NULL;
        $changeHistoryObject->admin_id = $entity["admin_id"] ?? NULL;
        return $changeHistoryObject;
    }
    private function ChangeHistoryObjectList($changeHistory){
        $changeHistoryList = [];
        foreach($changeHistory as $chg){
            $changeHistoryList[] = $this->ChangeHistoryObject($chg);
        }
        return $changeHistoryList;
    }
}

?>