<?php
require_once "api/Service/RequestService.php";

class RequestController{
    private RequestService $request_service;
    public function __construct()
    {
        $this->request_service = new RequestService();
    }

        public function getAllRequest(){
        try{
            $request = $this->request_service->getAllRequest();
            echo json_encode(["message" => "Successfully get request", "data" => $request]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(["message" => $e->getMessage()]);
        }
    }
    public function getRequestById($id){
        try{
            $request = $this->request_service->getRequestById($id);
            echo json_encode(["message" => "Successfully get Request", "data" => $request]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(value: ["message" => $e->getMessage()]);
        }
    }   
    public function addRequest($request){
        try{
            $request = $this->request_service->addRequest($request);
            echo json_encode(["message" => "Successfully added Request","data" => $request]);
            http_response_code(200);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(["message" => $e->getMessage()]);
            return null;
        }
    }
    public function updateRequest($request){
        try{
            $this->request_service->updateRequest($request);
            echo json_encode(["message" => "Successfully updated Request"]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(["message" => $e->getMessage()]);
        }
    }

    public function deleteRequest($id)
    {
        try{
            $this->request_service->deleteRequest($id);
            echo json_encode(["message" => "Successfully deleted Request {$id}"]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(["message" => $e->getMessage()]);
        }
    }
}
?>