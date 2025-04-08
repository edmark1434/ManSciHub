<?php
    require_once "api/Repository/RepositoryLogic.php";
    
    class RequestRepository{
        private RepositoryLogic $repository;
        
        public function __construct(){
            $this->repository = new RepositoryLogic();
        }

        public function getAllRequest(): array
    {
        $query = "SELECT 
            REQUEST.*, 
            DOCUMENT.*,
            STUDENT.* 
        FROM REQUEST
        JOIN DOCUMENT ON REQUEST.DOCU_ID = DOCUMENT.DOCU_ID
        JOIN STUDENT  ON REQUEST.STUD_ID = STUDENT.STUD_ID";
        $result = $this->repository->executeQuery($query,[]);
        return $result;
    }
    public function getRequestById($id):? array{
        $query = "SELECT 
            REQUEST.*, 
            DOCUMENT.*,
            STUDENT.* 
        FROM REQUEST
        JOIN DOCUMENT ON REQUEST.DOCU_ID = DOCUMENT.DOCU_ID
        JOIN STUDENT  ON REQUEST.STUD_ID = STUDENT.STUD_ID
        WHERE REQ_TRACK_ID = :id
        ";
        $params = [":id" => $id];
        $result = $this->repository->executeQuery($query, $params);
        return $this->repository->BuildResultQuery($result);       
    }

    public function addRequest(Request $request): void{
        $query = "INSERT INTO REQUEST (REQ_PURPOSE,DOCU_ID,STUD_ID) VALUES ( :REQ_PURPOSE, :DOCU_ID, :STUD_ID)";
        $params = $this->RequestParameter($request);
        $this->repository->executeQuery($query, $params);
    }

    public function updateRequest($request): void{
        $query = "UPDATE REQUEST SET  REQ_DATE = :REQ_DATE,
        REQ_PURPOSE = :REQ_PURPOSE, REQ_STATUS = :REQ_STATUS, DOCU_ID= :DOCU_ID, STUD_ID = :STUD_ID 
        WHERE REQ_TRACK_ID = :REQ_TRACK_ID";
        $params = $this->RequestParameter($request);
        $this->repository->executeQuery($query, $params);
    }

    public function deleteRequest($id): void
    {
        $query = "DELETE FROM Request where REQ_TRACK_ID = :id";
        $params = [":id" => $id];
        $this->repository->executeQuery($query, $params);
    }

    private function RequestParameter($request){
        $params = [
            ":REQ_PURPOSE" => $request->req_purpose, 
            ":DOCU_ID" => $request->docu_id,
            ":STUD_ID" => $request->stud_id,
        ];
        if(!empty($request->req_track_id)){
            $params[":REQ_TRACK_ID"] = $request->req_track_id;
        }
        if(!empty($request->req_date)){
            $params[":REQ_DATE"] = $request->req_date;
        }
        if(!empty($request->req_status)){
            $params[":REQ_STATUS"] = $request->req_status;
        }
        return $params;
    }
    }
?>