<?php
require_once "api/Repository/RequestRepository.php";
require_once "api/Controller/StudentController.php";
require_once "api/Service/RequestService.php";
require_once "api/Repository/DocumentRepository.php";
require_once "api/Repository/StudentRepository.php";

class DocumentRequest{
    private RequestRepository $requestRepository;
    private StudentService $studentService;
    private RequestService $requestService;
    private RequestController $requestController;
    private DocumentRepository $documentRepository;
    private StudentRepository $studentRepository;
    public function __construct(){
        $this->requestRepository = new RequestRepository();
        $this->requestController = new RequestController();
        $this->studentService = new StudentService();
        $this->documentRepository = new DocumentRepository();
        $this->studentRepository = new StudentRepository();
        $this->requestService = new RequestService();
    }

    public function request($request):?array{
            //check if student exist
            $student = $this->checkStudentExist($request);
            //get the document type
            //make request as object
            $request_object = $this->RequestObject($request["req_purpose"], $student["stud_id"], $request["docu_id"]);
            //add new request
            $request = $this->requestController->addRequest($request_object);
            return $request;
    }

    private function checkStudentExist($request): array{
        //turn request as object
        $studentObject = $this->StudentObject($request);
        $student = $this->studentRepository->getStudentByFilter($studentObject);
        //check if student has record already
        if ($student) {
            //it will just change the email
            $student["stud_email"] = $request["stud_email"];
            $this->studentService->updateStudent($student);
        }else{
            //if does not exist it will add
            $this->studentService->addStudent($request);
            $student = $this->studentRepository->getStudentByFilter($studentObject);
        }
        return $student;
    }
    private function RequestObject($purpose,$stud_id,$docu_id){
        $requestObject = [
            "req_purpose" => $purpose,
            "stud_id" => $stud_id,
            "docu_id" => $docu_id
        ];
        return $requestObject;
    }
    private function StudentObject($request){
        $student = [
            "stud_fname"=> $request["stud_fname"],
            "stud_lname"=> $request["stud_lname"],
            "stud_mname"=> $request["stud_mname"] ?? NULL,
            "stud_suffix"=> $request["stud_suffix"] ?? NULL,
            "stud_lrn"=> $request["stud_lrn"] ?? NULL
        ];
        return $student;
    }
}
?>