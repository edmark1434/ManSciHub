<?php
require_once "api/Repository/RepositoryLogic.php";

class RequestHistoryRepository {
    private RepositoryLogic $repository;

    public function __construct() {
        $this->repository = new RepositoryLogic();
    }

    public function getAllRequest(): array {
        $query = "SELECT 
                REQUEST_HISTORY.*, 
                DOCUMENT.*, 
                STUDENT.* 
            FROM REQUEST_HISTORY
            JOIN DOCUMENT ON REQUEST_HISTORY.DOCU_ID = DOCUMENT.DOCU_ID
            JOIN STUDENT ON REQUEST_HISTORY.STUD_ID = STUDENT.STUD_ID";
        return $this->repository->executeQuery($query, []);
    }

    public function getRequestHistoryById($id): ?array {
        $query = "SELECT 
                REQUEST_HISTORY.*, 
                DOCUMENT.*, 
                STUDENT.* 
            FROM REQUEST_HISTORY
            JOIN DOCUMENT ON REQUEST_HISTORY.DOCU_ID = DOCUMENT.DOCU_ID
            JOIN STUDENT ON REQUEST_HISTORY.STUD_ID = STUDENT.STUD_ID
            WHERE REQUEST_HISTORY.REQHS_ID = :id
        ";
        $params = [":id" => $id];
        $result = $this->repository->executeQuery($query, $params);
        return $this->repository->BuildResultQuery($result);
    }

    public function addRequest($request): void {
        $query = "INSERT INTO REQUEST_HISTORY (REQHS_ID,REQHS_DATE, REQHS_PURPOSE, 
                REQHS_STATUS, DOCU_ID, STUD_ID, REQHS_TRACK_ID) VALUES 
                ( :REQHS_ID, :REQHS_DATE, :REQHS_PURPOSE, :REQHS_STATUS, 
                :DOCU_ID, :STUD_ID, :REQHS_TRACK_ID)
        ";
        $params = $this->RequestHistoryParameter($request);
        $this->repository->executeQuery($query, $params);
    }

    public function updateRequest($request): void {
        $query = "UPDATE REQUEST_HISTORY SET  
                REQHS_DATE = :REQHS_DATE,
                REQHS_PURPOSE = :REQHS_PURPOSE, 
                REQHS_STATUS = :REQHS_STATUS, 
                DOCU_ID = :DOCU_ID,
                STUD_ID = :STUD_ID,
                REQHS_TRACK_ID = :REQHS_TRACK_ID,
                REQHS_PROC_DATE = :REQHS_PROC_DATE
            WHERE REQHS_ID = :REQHS_ID
        ";
        $params = $this->RequestHistoryParameter($request);
        $this->repository->executeQuery($query, $params);
    }

    public function deleteRequest($id): void {
        $query = "DELETE FROM REQUEST_HISTORY WHERE REQHS_ID = :id";
        $params = [":id" => $id];
        $this->repository->executeQuery($query, $params);
    }
        private function RequestHistoryParameter($request){
        $params = [
            ":REQHS_ID" => $request->reqhs_id,
            ":REQHS_DATE" => $request->reqhs_date,
            ":REQHS_PURPOSE" => $request->reqhs_purpose, 
            ":REQHS_STATUS" => $request->reqhs_status,
            ":REQHS_TRACK_ID" => $request->reqhs_track_id,
            ":DOCU_ID" => $request->docu_id,
            ":STUD_ID" => $request->stud_id,
        ];

        if(!empty($request->reqhs_proc_date)){
            $params[":REQHS_PROC_DATE"] = $request->reqhs_proc_date;
        }
        return $params;
    }
}
?>
