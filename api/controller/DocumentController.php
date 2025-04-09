<?php
require_once "api/Service/DocumentService.php";

class DocumentController{
    private DocumentService $Document_service;
    public function __construct()
    {
        $this->Document_service = new DocumentService();
    }

        public function getAllDocument(){
        try{
            $Document = $this->Document_service->getAllDocument();
            echo json_encode(["message" => "Successfully get Document", "data" => $Document]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(["message" => $e->getMessage()]);
        }
    }
    public function getDocumentById($id){
        try{
            $Document = $this->Document_service->getDocumentById($id);
            echo json_encode(["message" => "Successfully get Document", "data" => $Document]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(["message" => $e->getMessage()]);
        }
    }   
    public function addDocument($Document): void{
        try{
            $this->Document_service->addDocument($Document);
            echo json_encode(["message" => "Successfully added Document"]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(["message" => $e->getMessage()]);
        }
    }
    public function updateDocument($Document){
        try{
            $this->Document_service->updateDocument($Document);
            echo json_encode(["message" => "Successfully updated Document"]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(["message" => $e->getMessage()]);
        }
    }

    public function deleteDocument($id)
    {
        try{
            $this->Document_service->deleteDocument($id);
            echo json_encode(["message" => "Successfully deleted Document {$id}"]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(["message" => $e->getMessage()]);
        }
    }
}
?>