<?php
require_once "api/Repository/AdmissionRepository.php";
require_once "api/Service/ServiceLogic.php";
require_once "api/Model/Admission.php";
require_once "api/Repository/StudentRepository.php";

class AdmissionService{
    private AdmissionRepository $admissionRepository;
    private ServiceLogic $serviceLogic;
    private StudentRepository $studentRepository;
    public function __construct()
    {
        $this->admissionRepository = new AdmissionRepository();
        $this->serviceLogic = new ServiceLogic();
        $this->studentRepository = new StudentRepository();
    }

    public function getAllAdmission(){
        $admissions = $this->admissionRepository->getAllAdmission();
        return $this->serviceLogic->checkGetMethod($admissions,"No Admission found");
    }
    public function getAdmissionById($id)
    {
        $admission = $this->admissionRepository->getAdmissionById($id);
        return $this->serviceLogic->checkGetMethod($admission, "Admission with {$id} does not exist!");
    }

    public function addAdmission($admission){
        $this->serviceLogic->checkExistence(["stud_id" => $admission["stud_id"]],$this->admissionRepository,"getAdmissionByFilter","Admission with Student id {$admission["stud_id"]} is already exist!");
        $this->serviceLogic->checkExistence($admission["stud_id"], $this->studentRepository, 'getStudentById', "Student with id {$admission["stud_id"]} does not exist!");
        $admission =  $this->AdmissionObject($admission);
        $this->admissionRepository->addAdmission( $admission);
    }

    public function updateAdmission($admission){
        //validation
        $this->serviceLogic->checkExistence($admission["adms_id"],$this->admissionRepository,"getAdmissionById","Admission with Student id {$admission["adms_id"]} does not exist!");
        $this->serviceLogic->checkExistence($admission["stud_id"], $this->studentRepository, 'getStudentById', "Student with id {$admission["stud_id"]} does not exist!");
        $admission =  $this->AdmissionObject($admission);
        $this->admissionRepository->updateAdmission($admission);
    }
    public function deleteAdmission($id)
    {
        $this->serviceLogic->checkExistence($id,$this->admissionRepository,"getAdmissionById","Admission with Student id {$id} does not exist!");
        $this->admissionRepository->deleteAdmission($id);
    }

    private function AdmissionObject($entity){
        $admission = new Admission();
        $admission->adms_id = $entity["adms_id"] ?? NULL;
        $admission->adms_date = $entity["adms_date"] ?? NULL;
        $admission->adms_status = $entity["adms_status"] ?? NULL;
        $admission->stud_id = $entity["stud_id"] ?? NULL;
        return $admission;
    }
}
?>