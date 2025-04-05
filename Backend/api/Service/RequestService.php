<?php
require_once "api/Repository/RequestRepository.php";
require_once "api/Repository/DocumentRepository.php";
require_once "api/Repository/StudentRepository.php";
require_once "api/Service/ServiceLogic.php";
require_once "api/model/Request.php";

class RequestService{
    private RequestRepository $requestRepository;
    private DocumentRepository $documentRepository;
    private StudentRepository $studentRepository;
    private ServiceLogic $serviceLogic;

    public function __construct(){
        $this->requestRepository = new RequestRepository();
        $this->documentRepository = new DocumentRepository();
        $this->studentRepository = new StudentRepository();
        $this->serviceLogic = new ServiceLogic();
    }

    public function getAllRequest(){
        $request = $this->requestRepository->getAllRequest();
        return $this->serviceLogic->checkGetMethod($request, "No Request found");
    }
    public function getRequestById($id){
        $request = $this->requestRepository->getRequestById($id);
        return $this->serviceLogic->checkGetMethod($request, "Request id {$id} does not exist");
    }
    public function addRequest($request){
        $this->serviceLogic->checkExistence($request["stud_id"], $this->studentRepository,'getStudentById',"Student with id {$request["stud_id"]} does not exist!");
        $this->serviceLogic->checkExistence($request["docu_id"], $this->documentRepository,'getDocumentById',"Document with id {$request["docu_id"]} does not exist!");
        $request = $this->RequestObject($request);
        $this->requestRepository->addRequest($request);
    }
    public function updateRequest($request){
        $this->serviceLogic->checkExistence($request["req_track_id"], $this->requestRepository, "getRequestById", "Request with id {$request["req_track_id"]} does not exist");
        $this->serviceLogic->checkExistence($request["stud_id"], $this->studentRepository,'getStudentById',"Student with id {$request["stud_id"]} does not exist!");
        $this->serviceLogic->checkExistence($request["docu_id"], $this->documentRepository,'getDocumentById',"Document with id {$request["docu_id"]} does not exist!");
        $request = $this->RequestObject($request);
        $this->requestRepository->updateRequest($request);
    }
    public function deleteRequest($id)
    {
        $this->serviceLogic->checkExistence($id, $this->requestRepository, "getRequestById", "Request with id {$id} does not exist");
        $this->requestRepository->deleteRequest($id);
    }
    public function RequestObject($entity)
    {
        $request = new Request();
        $request->req_date = $entity["req_date"] ?? NULL;
        $request->req_purpose = $entity["req_purpose"] ?? NULL;
        $request->req_status = $entity["req_status"] ?? NULL;
        $request->req_track_id = $entity["req_track_id"] ?? NULL;
        $request->docu_id = $entity["docu_id"] ?? NULL;
        $request->stud_id = $entity["stud_id"] ?? NULL;
        return $request;
    }

    
}
?>