<?php
require_once "api/Repository/requestHistoryRepository.php";
require_once "api/Repository/DocumentRepository.php";
require_once "api/Repository/StudentRepository.php";
require_once "api/Service/ServiceLogic.php";
require_once "api/model/RequestHistory.php";
class RequestHistoryService{
    private RequestHistoryRepository $requestHistoryRepository;
    private DocumentRepository $documentRepository;
    private StudentRepository $studentRepository;
    private ServiceLogic $serviceLogic;
    public function __construct(){
        $this->requestHistoryRepository = new RequestHistoryRepository();
        $this->documentRepository = new DocumentRepository();
        $this->studentRepository = new StudentRepository();
        $this->serviceLogic = new ServiceLogic();
    }

    public function getAllRequestHistory(){
        $request = $this->requestHistoryRepository->getAllRequest();
        return $this->serviceLogic->checkGetMethod($request,"No Request History Found");
    }
    public function getRequestHistoryById($id){
        $request = $this->requestHistoryRepository->getRequestHistoryById($id);
        return $this->serviceLogic->checkGetMethod($request,"Request History with id {$id} does not exist");
    }
    public function addRequestHistory($request){
        $this->serviceLogic->checkExistence($request["stud_id"], $this->studentRepository,'getStudentById',"Student with id {$request["stud_id"]} does not exist!");
        $this->serviceLogic->checkExistence($request["docu_id"], $this->documentRepository,'getDocumentById',"Document with id {$request["docu_id"]} does not exist!");        
        $request = $this->RequestHistoryObject($request);
        $this->requestHistoryRepository->addRequest($request);
    }
    public function updateRequestHistory($request){
        $this->serviceLogic->checkExistence($request["reqhs_id"], $this->requestHistoryRepository, "getRequestHistoryById", "Request History with id {$request["reqhs_id"]} does not exist");
        $this->serviceLogic->checkExistence($request["stud_id"], $this->studentRepository,'getStudentById',"Student with id {$request["stud_id"]} does not exist!");
        $this->serviceLogic->checkExistence($request["docu_id"], $this->documentRepository,'getDocumentById',"Document with id {$request["docu_id"]} does not exist!");        
        $request = $this->RequestHistoryObject($request);
        $this->requestHistoryRepository->updateRequest($request);
    }
    public function deleteRequestHistory($id)
    {
        $this->serviceLogic->checkExistence($id, $this->requestHistoryRepository, "getRequestHistoryById", "Request History with id {$id} does not exist");
        $this->requestHistoryRepository->deleteRequest($id);
    }
    public function RequestHistoryObject($entity)
    {
        $requestHistory = new RequestHistory();
        $requestHistory->reqhs_date = $entity["reqhs_date"] ?? NULL;
        $requestHistory->reqhs_purpose = $entity["reqhs_purpose"] ?? NULL;
        $requestHistory->reqhs_status = $entity["reqhs_status"] ?? NULL;
        $requestHistory->reqhs_id = $entity["reqhs_id"] ?? NULL;
        $requestHistory->reqhs_proc_date = $entity["reqhs_proc_date"] ?? NULL;
        $requestHistory->docu_id = $entity["docu_id"] ?? NULL;
        $requestHistory->stud_id = $entity["stud_id"] ?? NULL;
        $requestHistory->reqhs_track_id = $entity["reqhs_track_id"] ?? NULL;

        return $requestHistory;
    }


}
?>