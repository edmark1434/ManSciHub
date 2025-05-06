<?php
require_once "api/Repository/RepositoryLogic.php";

class AuditLogRequestRepository {
    private RepositoryLogic $repository;

    public function __construct() {
        $this->repository = new RepositoryLogic();
    }

    public function getAllAuditLogRequest(): array {
        $query = "
            SELECT a.chg_id, a.req_track_id as track_id, a.chg_old_val, a.chg_new_val, a.chg_datetime, ad.admin_username, r.req_date , s.stud_fname, s.stud_mname, s.stud_lname, s.stud_suffix 
            FROM AUDIT_LOG_REQUEST AS a
            INNER JOIN ADMIN AS ad ON a.admin_id = ad.admin_id
            INNER JOIN REQUEST as r ON a.req_track_id = r.req_track_id
            INNER JOIN STUDENT as s ON r.stud_id = s.stud_id";
        return $this->repository->executeQuery($query, []);
    }

    public function getAuditLogRequestById($id): ?array {
        $query = "
            SELECT a.chg_id, a.req_track_id as track_id, a.chg_old_val, a.chg_new_val, a.chg_datetime, ad.admin_username, r.req_date , s.stud_fname, s.stud_mname, s.stud_lname, s.stud_suffix 
            FROM AUDIT_LOG_REQUEST AS a
            INNER JOIN ADMIN AS ad ON a.admin_id = ad.admin_id
            INNER JOIN REQUEST as r ON a.req_track_id = r.req_track_id
            INNER JOIN STUDENT as s ON r.stud_id = s.stud_id
            WHERE a.chg_id  = :id
        ";
        $params = [":id" => $id];
        $result = $this->repository->executeQuery($query, $params);
        return $this->repository->BuildResultQuery($result);
    }

    public function addAuditLogRequest($change): void {
        $query = "INSERT INTO AUDIT_LOG_REQUEST (REQ_TRACK_ID, CHG_OLD_VAL, CHG_NEW_VAL, ADMIN_ID) 
        VALUES (:REQ_TRACK_ID, :CHG_OLD_VAL, :CHG_NEW_VAL, :ADMIN_ID)";
        $params = $this->AuditLogRequestParameter($change);
        $this->repository->executeQuery($query, $params);
    }

    private function AuditLogRequestParameter($auditLogRequest){
        $params =[
            ":REQ_TRACK_ID" => $auditLogRequest->req_track_id,
            ":CHG_OLD_VAL" => $auditLogRequest->chg_old_val,
            ":CHG_NEW_VAL" =>$auditLogRequest->chg_new_val,
            ":ADMIN_ID" => $auditLogRequest->admin_id
        ];
        return $params;
    }
}
?>