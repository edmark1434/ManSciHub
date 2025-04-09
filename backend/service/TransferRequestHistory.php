<?php
require_once "api/Controller/RequestHistoryController.php";
require_once "api/Service/RequestService.php";
class TransferRequestHistory{

    private RequestHistoryController $requestHistoryController;
    private RequestService $requestService;

    public function __construct(){
        $this->requestHistoryController = new RequestHistoryController();
        $this->requestService = new RequestService();
    }
    public function transferRequest($request){
        if($request["req_status"] === "RETRIEVE" || $request["req_status"] === "REJECTED"){
            $request_history = $this->RequestHistoryObject($request);
            $this->requestHistoryController->addRequestHistory($request_history);
            $this->requestService->deleteRequest($request["req_track_id"]);
        }
    }

    public function RequestHistoryObject($request){
        $requestObject = [
            "reqhs_status" => $request["req_status"],
            "reqhs_date" => $request["req_date"],
            "docu_id" => $request["docu_id"],
            "stud_id" => $request["stud_id"],
            "reqhs_purpose" => $request["req_purpose"]
        ];
        return $requestObject;
    }

    
}
?>