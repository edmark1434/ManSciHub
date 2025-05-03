<?php
require_once "api/Repository/RepositoryLogic.php";

class AuditLogAdmissionRepository {
    private RepositoryLogic $repository;

    public function __construct() {
        $this->repository = new RepositoryLogic();
    }

    public function getAllAuditLogAdmission(): array {
        $query = "
            SELECT a.chg_id, a.adms_id as track_id, a.chg_old_val, a.chg_new_val, TO_CHAR(a.chg_datetime, 'YYYY-MM-DD HH12:MI AM') as chg_datetime, ad.admin_username, r.adms_date , s.stud_fname, s.stud_mname, s.stud_lname, s.stud_suffix 
            FROM AUDIT_LOG_ADMISSION AS a
            INNER JOIN ADMIN AS ad ON a.admin_id = ad.admin_id
            INNER JOIN ADMISSION as r ON a.adms_id = r.adms_id
            INNER JOIN STUDENT as s ON r.stud_id = s.stud_id
        ";
        return $this->repository->executeQuery($query, []);
    }

    public function getAuditLogAdmissionById($id): ?array {
        $query = "
            SELECT a.chg_id, a.adms_id as track_id, a.chg_old_val, a.chg_new_val, TO_CHAR(a.chg_datetime, 'YYYY-MM-DD HH12:MI AM') as chg_datetime, ad.admin_username, r.adms_date , s.stud_fname, s.stud_mname, s.stud_lname, s.stud_suffix 
            FROM AUDIT_LOG_ADMISSION AS a
            INNER JOIN ADMIN AS ad ON a.admin_id = ad.admin_id
            INNER JOIN ADMISSION as r ON a.adms_id = r.adms_id
            INNER JOIN STUDENT as s ON r.stud_id = s.stud_id
            WHERE a.chg_id  = :id
        ";
        $params = [":id" => $id];
        $result = $this->repository->executeQuery($query, $params);
        return $this->repository->BuildResultQuery($result);
    }

    public function addAuditLogAdmission($change): void {
        $query = "INSERT INTO AUDIT_LOG_ADMISSION (ADMS_ID, CHG_OLD_VAL, CHG_NEW_VAL, ADMIN_ID) 
        VALUES (:ADMS_ID, :CHG_OLD_VAL, :CHG_NEW_VAL, :ADMIN_ID)";
        $params = $this->AuditLogAdmissionParameter($change);
        $this->repository->executeQuery($query, $params);
    }

    private function AuditLogAdmissionParameter($auditLogAdmission){
        $params =[
            ":ADMS_ID" => $auditLogAdmission->adms_id,
            ":CHG_OLD_VAL" => $auditLogAdmission->chg_old_val,
            ":CHG_NEW_VAL" =>$auditLogAdmission->chg_new_val,
            ":ADMIN_ID" => $auditLogAdmission->admin_id
        ];
        return $params;
    }
}
?>