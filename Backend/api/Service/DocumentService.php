<?php
    require_once "api/Repository/DocumentRepository.php";
    require_once "api/Model/Document.php";
    require_once "api/Service/ServiceLogic.php";
class DocumentService{
    private DocumentRepository $DocumentRepository;
    private ServiceLogic $serviceLogic;
    public function __construct(){
        $this->DocumentRepository = new DocumentRepository();
        $this->serviceLogic = new ServiceLogic();
    }

    public function getAllDocument(): array{
        $Document = $this->DocumentRepository->getAllDocument();
        $Document = $this->serviceLogic->checkGetMethod($Document, "No document found");
        return $this->DocumentListObject($Document);
    }
    public function getDocumentByID(int $id): Document{
        $Document = $this->DocumentRepository->getDocumentByID($id);
        $Document = $this->serviceLogic->checkGetMethod($Document, "Document with id {$id} does not exist");
        return $this->DocumentObject($Document);
    }
    public function addDocument($Document){
        $this->serviceLogic->checkExistence($Document["docu_type"], $this->DocumentRepository, 'getDocumentByFilter', "Document type {$Document["docu_type"]} is already exist!");
        $Document = $this->DocumentObject($Document);
        $this->DocumentRepository->addDocument($Document);
        
    }
    public function updateDocument($Document){
        $this->serviceLogic->checkExistence($Document["docu_id"], $this->DocumentRepository, "getDocumentById", "Document with id {$Document["docu_id"]} does not exist");
        $Document = $this->DocumentObject($Document);
        $this->DocumentRepository->updateDocument($Document);
    }
    public function deleteDocument(int $id){
        $this->serviceLogic->checkExistence($id, $this->DocumentRepository, "getDocumentById", "Document with id {$id} does not exist");
        $this->DocumentRepository->deleteDocument($id);
    }

    public function DocumentObject($Document):Document{
        $DocumentObject = new Document();
        $DocumentObject->docu_id = $Document['docu_id'] ?? NULL;
        $DocumentObject->docu_type = $Document['docu_type'] ?? NULL;
        return $DocumentObject;
    }
    public function DocumentListObject($Document): array
    {
        $DocumentList = [];
        foreach ($Document as $Docu) {
            $DocumentList[] = $this->DocumentObject($Docu);
        }
        return $DocumentList;
    }
}
?>