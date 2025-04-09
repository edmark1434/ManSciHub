<?php
    require_once "api/Repository/RepositoryLogic.php";
    class AdmissionRepository{
        private RepositoryLogic $repository;

        public function __construct(){
            $this->repository = new RepositoryLogic();
        }

        public function getAllAdmission(): array
    {
        $query = "SELECT ADMISSION.*, STUDENT.* FROM ADMISSION JOIN STUDENT ON
        STUDENT.STUD_ID = ADMISSION.STUD_ID";
        $result = $this->repository->executeQuery($query,[]);
        return $result;
    }

    public function getAdmissionById($id):? array{
        $query = "SELECT ADMISSION.*, STUDENT.* FROM ADMISSION JOIN STUDENT ON
        STUDENT.STUD_ID = ADMISSION.STUD_ID
        WHERE ADMS_ID = :id";
        $params = [":id" => $id];
        $result = $this->repository->executeQuery($query, $params);
        return $this->repository->BuildResultQuery($result);       
    }

        public function getAdmissionByFilter($request):? array{
        $query = "SELECT ADMISSION.*, STUDENT.* FROM ADMISSION JOIN STUDENT ON
        STUDENT.STUD_ID = ADMISSION.STUD_ID
        WHERE 1=1 ";
        $params = [];
        $stud_id = isset($request["stud_id"]) ? $request["stud_id"] : null;
        if(!empty($stud_id)){
            $query .= "AND ADMISSION.STUD_ID = :id";
            $params[":id"] = $stud_id;
        }
        $result = $this->repository->executeQuery($query, $params);
        return $this->repository->BuildResultQuery($result);       
    }

    public function addAdmission($admission): array{
        $query = "INSERT INTO Admission (ADMS_STATUS,STUD_ID) VALUES (:ADMS_STATUS,:STUD_ID) RETURNING * ";
        $params = $this->AdmissionParameter($admission);
        return $this->repository->executeQuery($query, $params);
    }

    public function updateAdmission($admission): void{
        $query = "UPDATE Admission SET ADMS_STATUS = :ADMS_STATUS, STUD_ID = :STUD_ID ,
        ADMS_DATE = :ADMS_DATE WHERE ADMS_ID = :ADMS_ID";
        $params = $this->AdmissionParameter($admission);
        $this->repository->executeQuery($query, $params);
    }
    public function getAllStudentWithLimits($offset){
        $query = "SELECT * FROM Admission LIMIT 1000 OFFSET :offset";
        $params = [":offset"=> $offset];
        $this->repository->executeQuery($query, $params);
    }

    public function deleteAdmission($id): void
    {
        $query = "DELETE FROM Admission where ADMS_ID = :id";
        $params = [":id" => $id];
        $this->repository->executeQuery($query, $params);
    }
    public function deleteAllAdmission(){
        $query = "DELETE FROM Admission";
        $this->repository->executeQuery($query, []);
    }
    private function AdmissionParameter($admission){
        $params = [
            ":ADMS_STATUS" =>$admission->adms_status,
            ":STUD_ID" =>$admission->stud_id
        ];
        if(!empty($admission->adms_id)){
            $params[":ADMS_ID"] = $admission->adms_id;
        }
        if(!empty($admission->adms_date)){
            $params[":ADMS_DATE"] = $admission->adms_date;
        }
        return $params;
    }
    }
?>