<?php
    require_once "api/Repository/RepositoryLogic.php";
    class AdmissionHistoryRepository{
        private RepositoryLogic $repository;
        public function __construct(){
            $this->repository = new RepositoryLogic();
        }

        public function getAllAdmissionHistory(): array
    {
        $query = "SELECT Admission_History.*, STUDENT.* FROM Admission_History JOIN STUDENT ON
        STUDENT.STUD_ID = Admission_History.STUD_ID";
        $result = $this->repository->executeQuery($query,[]);
        return $result;
    }
    public function getAdmissionHistoryById($id):? array{
        $query = "SELECT Admission_History.*, STUDENT.* FROM Admission_History JOIN STUDENT ON
        STUDENT.STUD_ID = Admission_History.STUD_ID
        WHERE ADMHS_ID = :id";
        $params = [":id" => $id];
        $result = $this->repository->executeQuery($query, $params);
        return $this->repository->BuildResultQuery($result);       
    }
        public function getAdmissionHistoryByFilter($params):? array{
        $query = "SELECT ADMISSION_HISTORY.*, STUDENT.* FROM ADMISSION_HISTORY JOIN STUDENT ON
        STUDENT.STUD_ID = ADMISSION_HISTORY.STUD_ID WHERE 1=1 ";
        $stud_id = isset($params["stud_id"]) ? $params["stud_id"] : null;
        $params = [];
        if(!empty($stud_id)){
            $query .= "AND ADMISSION_HISTORY.STUD_ID = :id";
            $params = [":id"=> $stud_id];
        }
        $result = $this->repository->executeQuery($query, $params);
        return $this->repository->BuildResultQuery($result);       
    }
    public function addAdmissionHistory($AdmissionHistory): void{
        $query = "INSERT INTO Admission_History (ADMHS_DATE,ADMHS_STATUS,STUD_ID) VALUES (:ADMHS_DATE,:ADMHS_STATUS,:STUD_ID)";
        $params = $this->AdmissionHistoryParameter($AdmissionHistory);
        $this->repository->executeQuery($query, $params);
    }

public function addAllAdmissionHistory($AdmissionHistoryList) {
    if (empty($AdmissionHistoryList)) return;

    $placeholders = [];
    $params = [];

    foreach ($AdmissionHistoryList as $index => $adms) {
        $placeholders[] = "(:ADMHS_DATE$index, :ADMHS_STATUS$index, :STUD_ID$index)";
        $params["ADMHS_DATE$index"] = $adms["adms_date"];
        $params["ADMHS_STATUS$index"] = $adms["adms_status"];
        $params["STUD_ID$index"] = $adms["stud_id"];
    }

    $query = "INSERT INTO Admission_History (ADMHS_DATE, ADMHS_STATUS, STUD_ID) VALUES " . implode(",", $placeholders);
    $this->repository->executeQuery($query, $params);
}


    public function updateAdmissionHistory($AdmissionHistory): void{
        $query = "UPDATE Admission_History SET ADMHS_STATUS = :ADMHS_STATUS, ADMHS_DATE = :ADMHS_DATE, ADMHS_PROC_DATE = :ADMHS_PROC_DATE,
        STUD_ID = :STUD_ID WHERE ADMHS_ID = :ADMHS_ID";
        $params = $this->AdmissionHistoryParameter($AdmissionHistory);
        $this->repository->executeQuery($query, $params);
    }

    public function deleteAdmissionHistory($id): void
    {
        $query = "DELETE FROM Admission_History where ADMHS_ID = :id";
        $params = [":id" => $id];
        $this->repository->executeQuery($query, $params);
    }
    private function AdmissionHistoryParameter($AdmissionHistory){
        $params = [
            ":ADMHS_DATE" =>$AdmissionHistory->admhs_date,
            ":ADMHS_STATUS" =>$AdmissionHistory->admhs_status,
            ":STUD_ID" =>$AdmissionHistory->stud_id
        ];
        if (!empty($AdmissionHistory->admhs_id)) {
            $params[":ADMHS_ID"] = $AdmissionHistory->admhs_id;
        }
        if(!empty($AdmissionHistory->admhs_proc_date)){
            $params[":ADMHS_PROC_DATE"] = $AdmissionHistory->admhs_proc_date;
        }
        return $params;
    }
    }
?>