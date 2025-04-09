<?php
require_once "api/Repository/AdminControlsRepository.php";
require_once "api/Model/AdminControls.php";
require_once "api/Service/ServiceLogic.php";
class AdminControlsService{
    private AdminControlsRepository $adminControlsRepository;
    private ServiceLogic $serviceLogic;

    public function __construct(){
        $this->adminControlsRepository = new AdminControlsRepository();
        $this->serviceLogic = new ServiceLogic();
    }

    public function getAllAdminControls()
    {
        $adminControls = $this->adminControlsRepository->getAllAdminControls();
        $adminControls = $this->serviceLogic->checkGetMethod($adminControls,"No Admin Controls found");
        return $this->AdminControlsObjectList($adminControls);
    }
        public function getAdminControlsByKey($key)
    {
        $adminControls = $this->adminControlsRepository->getAdminControlsByKey($key);
        $adminControls = $this->serviceLogic->checkGetMethod($adminControls,"Admin Controls with key {$key} does not exist");
        return $this->AdminControlsObject($adminControls);
    }
    public function addAdminControls($adminControls){
        $this->serviceLogic->checkExistence(["ctrl_key" => $adminControls["ctrl_key"]], $this->adminControlsRepository,'getAdminControlsByFilter',"Admin Control with key {$adminControls["ctrl_key"]} is already exist");
        $adminControls= $this->AdminControlsObject($adminControls);
        $this->adminControlsRepository->addAdminControls($adminControls);
    }
    public function updateAdminControls($adminControls)
    {
        $this->serviceLogic->checkExistence($adminControls["ctrl_key"], $this->adminControlsRepository,'getAdminControlsByKey',"Admin Control with key {$adminControls["ctrl_key"]} does not exist");
        $adminControls = $this->AdminControlsObject($adminControls);
        $this->adminControlsRepository->updateAdminControls($adminControls);
    }
    public function deleteAdminControls($key){
        $this->serviceLogic->checkExistence($key, $this->adminControlsRepository,'getAdminControlsByKey',"Admin Control with key {$key} does not exist");
        $this->adminControlsRepository->deleteAdminControls($key);
    }
    private function AdminControlsObject($entity){
        $adminControls = new AdminControls();
        $adminControls->ctrl_key = $entity["ctrl_key"];
        $adminControls->ctrl_value = $entity["ctrl_value"];
        return $adminControls;
    }
    private function AdminControlsObjectList($entity)
    {
        $adminControlsList = [];
        foreach($entity as $adminControls){
            $adminControlsList[] = $this->AdminControlsObject($adminControls);
        }
        return $adminControlsList;
    }
}
?>