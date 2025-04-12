<?php
require_once "backend/service/DocumentRequest.php";

class DocumentRequestController extends DocumentRequest{


    public function DocumentRequest($request)
    {
        try{
            $this->request($request);
            http_response_code(200);
        }catch (Exception $e) {
            http_response_code(400);
            echo json_encode(["message" => $e->getMessage()]);
        }
    }
}
?>