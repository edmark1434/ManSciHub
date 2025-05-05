<?php
require_once "backend/service/UpdateDocument.php";
class UpdateDocumentController extends UpdateDocument{
    
    public function updateDocumentStatus($request){
        try{
            $this->updateDocument($request);
        } catch (Exception $e) {
            echo json_encode(["message" => $e->getMessage()]);
        }
    }
}
?>