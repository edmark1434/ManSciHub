<?php
    require_once "api/Repository/RepositoryLogic.php";
    class DocumentRepository{
        private RepositoryLogic $repository;

        public function __construct(){
            $this->repository = new RepositoryLogic();
        }
        public function getAllDocument(): array
    {
        $query = "SELECT * FROM DOCUMENT";
        $result = $this->repository->executeQuery($query,[]);
        return $result;
    }
    public function getDocumentById($id):? array{
        $query = "SELECT * FROM DOCUMENT where DOCU_ID = :id";
        $params = [":id" => $id];
        $result = $this->repository->executeQuery($query, $params);
        return $this->repository->BuildResultQuery($result);       
    }


    public function addDocument($document): void{
        $query = "INSERT INTO DOCUMENT (DOCU_TYPE) VALUES (:DOCU_TYPE)";
        $params = $this->DocumentParameter($document);
        $this->repository->executeQuery($query, $params);
    }

    public function updateDocument($document): void{
        $query = "UPDATE DOCUMENT SET DOCU_TYPE = :DOCU_TYPE WHERE DOCU_ID = :DOCU_ID";
        $params = $this->DocumentParameter($document);
        $this->repository->executeQuery($query, $params);
    }

    public function deleteDocument($id): void
    {
        $query = "DELETE FROM DOCUMENT where DOCU_ID = :id";
        $params = [":id" => $id];
        $this->repository->executeQuery($query, $params);
    }
    public function getDocumentByFilter($docu_type){
        $query = "SELECT * FROM DOCUMENT WHERE DOCU_TYPE = :DOCU_TYPE";
        $params = [":DOCU_TYPE" => $docu_type];
        $result = $this->repository->executeQuery($query, $params);
        return $this->repository->BuildResultQuery($result);
    }
    private function DocumentParameter($document){
        $params = [
            ":DOCU_TYPE" => $document->docu_type,
        ];
        if(!empty($document->docu_id)){
            $params[":DOCU_ID"] = $document->docu_id;
        }
        return $params;
    }
    }
?>