<?php
require_once "api/Repository/RepositoryLogic.php";

class ChangeHistoryRepository {
    private RepositoryLogic $repository;

    public function __construct() {
        $this->repository = new RepositoryLogic();
    }

    public function getAllChangeHistory(): array {
        $query = "SELECT CHANGE_HISTORY.*,ADMIN.* FROM CHANGE_HISTORY 
        JOIN ADMIN ON CHANGE_HISTORY.ADMIN_ID = ADMIN.ADMIN_ID";
        return $this->repository->executeQuery($query, []);
    }

    public function getChangeHistoryById($id): ?array {
        $query = "SELECT CHANGE_HISTORY.*,ADMIN.* FROM CHANGE_HISTORY 
        JOIN ADMIN ON CHANGE_HISTORY.ADMIN_ID = ADMIN.ADMIN_ID
        WHERE CHG_ID = :id";
        $params = [":id" => $id];
        $result = $this->repository->executeQuery($query, $params);
        return $this->repository->BuildResultQuery($result);
    }

    public function addChangeHistory($change): void {
        $query = "INSERT INTO CHANGE_HISTORY (CHG_TABLE,CHG_TABLE_ID, CHG_OLD_VAL, CHG_NEW_VAL, ADMIN_ID) 
        VALUES (:CHG_TABLE,:CHG_TABLE_ID, :CHG_OLD_VAL, :CHG_NEW_VAL, :ADMIN_ID)";
        $params = $this->ChangeHistoryParameter($change);
        $this->repository->executeQuery($query, $params);
    }

    public function updateChangeHistory($change): void {
    $query = "UPDATE CHANGE_HISTORY SET 
            CHG_TABLE = :CHG_TABLE,
            CHG_TABLE_ID = :CHG_TABLE_ID,
            CHG_OLD_VAL = :CHG_OLD_VAL,
            CHG_NEW_VAL = :CHG_NEW_VAL,
            CHG_DATETIME = :CHG_DATETIME,
            ADMIN_ID = :ADMIN_ID
        WHERE CHG_ID = :CHG_ID";
    $params = $this->ChangeHistoryParameter($change);
    $this->repository->executeQuery($query, $params);
}

    public function deleteChangeHistory($id): void {
        $query = "DELETE FROM CHANGE_HISTORY WHERE CHG_ID = :id";
        $params = [":id" => $id];
        $this->repository->executeQuery($query, $params);
    }

    private function ChangeHistoryParameter($changeHistory){
        $params =[
            ":CHG_TABLE" => $changeHistory->chg_table,
            ":CHG_TABLE_ID" => $changeHistory->chg_table_id,
            ":CHG_OLD_VAL" => $changeHistory->chg_old_val,
            ":CHG_NEW_VAL" => $changeHistory->chg_new_val,
            ":ADMIN_ID" => $changeHistory->admin_id
        ];
        if(!empty($changeHistory->chg_id)){
            $params[":CHG_ID"] = $changeHistory->chg_id;
        }
        if(!empty($changeHistory->chg_datetime)){
            $params[":CHG_DATETIME"] = $changeHistory->chg_datetime;
        }
        return $params;
    }
}
?>