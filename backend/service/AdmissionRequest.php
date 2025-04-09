<?php
require_once "api/Repository/AdmissionRepository.php";
require_once "api/Controller/AdmissionController.php";
require_once "api/Repository/StudentRepository.php";
require_once "api/Service/StudentService.php";

class AdmissionRequest{
    private AdmissionRepository $admissionRepository;
    private AdmissionController $admissionController;
    private StudentRepository $studentRepository;
    private StudentService $studentService;

    public function __construct(){
        $this->admissionRepository = new AdmissionRepository();
        $this->admissionController = new AdmissionController();
        $this->studentRepository = new StudentRepository();
        $this->studentService = new StudentService();
    }
    public function AdmissionEntry($request){
        $student = $this->checkStudentExist($request);
        $request["adms_status"] = "PENDING";
        $admission = $this->AdmissionObject([$request["adms_status"],$student["stud_id"]]);
        return $this->admissionController->addAdmission($admission);
    }
    public function checkStudentExist($request){
        $studentObj = $this->StudentObject($request);
        $student = $this->studentRepository->getStudentByFilter($studentObj);
        if ($student) {
            throw new Exception("Student {$request["stud_fname"]} {$request["stud_lname"]} {$request["stud_mname"]} {$request["stud_suffix"]} is already exist");
        }else{
            $this->studentService->addStudent($request);
            return $this->studentRepository->getStudentByFilter($request);
        }
    }
    public function AdmissionObject($admission){
        $admission = [
            "adms_status" => $admission[0],
            "stud_id" => $admission[1]
        ];
        return $admission;
    }
    public function StudentObject($request){
        $student = [
            "stud_lname" => $request["stud_lname"],
            "stud_fname" => $request["stud_fname"],
            "stud_mname" => $request["stud_mname"] ?? NULL,
            "stud_suffix" => $request["stud_suffix"] ?? NULL
        ];
        return $student;
    }
}

?>