<?php
require_once "api/controller/DocumentController.php";
class UpdateDocument{
    private DocumentController $documentController;
    public function __construct()
    {
        $this->documentController = new DocumentController();
    }
    public function updateDocument( $request)
    {
        if(password_verify($request["confirm_password"],$request["admin_password"])){
            $this->documentController->updateDocument($request);
        }else{
            throw new Exception("Incorrect Password");
        }
    }
}
?>