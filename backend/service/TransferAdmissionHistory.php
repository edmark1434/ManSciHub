<?php
require_once "api/Repository/AdmissionHistoryRepository.php";
require_once "api/Repository/AdmissionRepository.php";
require_once "api/Repository/StudentRepository.php";
require_once "api/Service/AdmissionService.php";
class TransferAdmissionHistory{
    private AdmissionHistoryRepository $admissionHistoryRepository;
    private AdmissionService $admissionService;
    private StudentRepository $studentRepository;
    private AdmissionRepository $admissionRepository;

    public function __construct(){
        $this->admissionHistoryRepository = new AdmissionHistoryRepository();
        $this->admissionService = new AdmissionService();
        $this->studentRepository = new StudentRepository();
        $this->admissionRepository = new AdmissionRepository();
    }

    public function TransferAllAdmissionHistory()
    {   
        $admissionList = $this->admissionService->getAdmissions();
        $this->admissionHistoryRepository->addAllAdmissionHistory($admissionList);
        $this->studentRepository->updateRejectedStudent();            
        $this->admissionRepository->deleteAllAdmission();
    }   

}
?>