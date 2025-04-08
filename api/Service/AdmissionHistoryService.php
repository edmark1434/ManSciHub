<?php
require_once "api/Repository/AdmissionHistoryRepository.php";
require_once "api/Service/ServiceLogic.php";
require_once "api/Model/AdmissionHistory.php";
require_once "api/Repository/StudentRepository.php";

class AdmissionHistoryService{
    private AdmissionHistoryRepository $AdmissionHistoryRepository;
    private ServiceLogic $serviceLogic;
    private StudentRepository $studentRepository;
    public function __construct()
    {
        $this->AdmissionHistoryRepository = new AdmissionHistoryRepository();
        $this->serviceLogic = new ServiceLogic();
        $this->studentRepository = new StudentRepository();
    }

    public function getAllAdmissionHistory(){
        $AdmissionHistory = $this->AdmissionHistoryRepository->getAllAdmissionHistory();
        return $this->serviceLogic->checkGetMethod($AdmissionHistory,"No Admission History Found");
    }
    public function getAdmissionHistoryById($id)
    {
        $AdmissionHistory = $this->AdmissionHistoryRepository->getAdmissionHistoryById($id);
        return $this->serviceLogic->checkGetMethod($AdmissionHistory,"Admission History with id {$id} does not exist!");
    }

    public function addAdmissionHistory($AdmissionHistory){
        $this->serviceLogic->checkExistence(["stud_id" => $AdmissionHistory["stud_id"]],$this->AdmissionHistoryRepository,"getAdmissionHistoryByFilter","Admission History with Student id {$AdmissionHistory["stud_id"]} is already exist!");
        $this->serviceLogic->checkExistence($AdmissionHistory["stud_id"], $this->studentRepository, 'getStudentById', "Student with id {$AdmissionHistory["stud_id"]} does not exist!");
        $AdmissionHistory =  $this->AdmissionHistoryObject($AdmissionHistory);
        $this->AdmissionHistoryRepository->addAdmissionHistory( $AdmissionHistory );
    }

    public function updateAdmissionHistory($AdmissionHistory){
        $this->serviceLogic->checkExistence($AdmissionHistory["admhs_id"],$this->AdmissionHistoryRepository,"getAdmissionHistoryById","Admission History with id {$AdmissionHistory["admhs_id"]} does not exist!");
        $this->serviceLogic->checkExistence($AdmissionHistory["stud_id"], $this->studentRepository, 'getStudentById', "Student with id {$AdmissionHistory["stud_id"]} does not exist!");
        $result = $this->getAdmissionHistoryById( $AdmissionHistory["admhs_id"] );
        if($result["stud_id"] != $AdmissionHistory["stud_id"]){
        $this->serviceLogic->checkExistence(["stud_id" => $AdmissionHistory["stud_id"]],$this->AdmissionHistoryRepository,"getAdmissionHistoryByFilter","Admission History with Student id {$AdmissionHistory["stud_id"]} is already exist!");
        }
        $AdmissionHistory =  $this->AdmissionHistoryObject($AdmissionHistory);
        $this->AdmissionHistoryRepository->updateAdmissionHistory($AdmissionHistory);
    }
    public function deleteAdmissionHistory($id)
    {
        $this->serviceLogic->checkExistence($id,$this->AdmissionHistoryRepository,"getAdmissionHistoryById","Admission History with id {$id} does not exist!");
        $this->AdmissionHistoryRepository->deleteAdmissionHistory($id);
    }

    private function AdmissionHistoryObject($entity){
        $AdmissionHistory = new AdmissionHistory();
        $AdmissionHistory->admhs_id = $entity["admhs_id"] ?? NULL;
        $AdmissionHistory->admhs_date = $entity["admhs_date"] ?? NULL;
        $AdmissionHistory->admhs_status = $entity["admhs_status"] ?? NULL;
        $AdmissionHistory->admhs_proc_date = $entity["admhs_proc_date"] ?? NULL;
        $AdmissionHistory->stud_id = $entity["stud_id"] ?? NULL;
        return $AdmissionHistory;
    }

}
?>