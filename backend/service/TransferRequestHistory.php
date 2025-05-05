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
        if(strcasecmp($request["req_status"],"ACCEPTED") == 0 || strcasecmp($request["req_status"],"REJECTED") == 0) {
            $request_history = $this->RequestHistoryObject($request);
            $this->requestHistoryController->addRequestHistory($request_history);
            $this->requestService->deleteRequest($request["req_track_id"]);
        }
    }

    public function RequestHistoryObject($request){
        $requestObject = [
            "reqhs_id" => $request["req_track_id"],
            "reqhs_status" => $request["req_status"],
            "reqhs_date" => $request["req_date"],
            'reqhs_track_id' => $request["req_track_id"],
            "docu_id" => $request["docu_id"],
            "stud_id" => $request["stud_id"],
            "reqhs_purpose" => $request["req_purpose"]
        ];
        return $requestObject;
    }

    
}
?>