<?php
require_once "api/config/database.php";
require_once "api/Repository/RepositoryLogic.php";

class StudentRepository{

    private RepositoryLogic $repository;

    public function __construct()
    {
        $this->repository = new RepositoryLogic();
    }

    public function getAllStudent(): array
    {
        $query = "SELECT * FROM Student";
        $result = $this->repository->executeQuery($query, []);
        return $result;
    }

    public function getStudentById($id): ?array
    {
        $query = "SELECT * FROM Student WHERE stud_id = :id";
        $params = [":id" => $id];
        $result = $this->repository->executeQuery($query, $params);
        return $this->repository->BuildResultQuery($result);
    }

    public function addStudent(Student $student): void
    {
        $query = "INSERT INTO Student (stud_fname, stud_lname, stud_mname, stud_suffix, stud_add, stud_lrn, stud_email, stud_dob)
                VALUES (:STUD_FNAME, :STUD_LNAME, :STUD_MNAME, :STUD_SUFFIX, :STUD_ADD, :STUD_LRN, :STUD_EMAIL, :STUD_DOB)";
        $params = $this->StudentParameter($student);
        $this->repository->executeQuery($query, $params);
    }

    public function updateStudent(Student $student): void
    {
        $query = "UPDATE Student SET  
                stud_fname = :STUD_FNAME, 
                stud_lname = :STUD_LNAME, 
                stud_mname = :STUD_MNAME, 
                stud_suffix = :STUD_SUFFIX, 
                stud_add = :STUD_ADD, 
                stud_lrn = :STUD_LRN, 
                stud_email = :STUD_EMAIL, 
                stud_dob = :STUD_DOB 
                WHERE stud_id = :STUD_ID";
        $params = $this->StudentParameter($student);
        $this->repository->executeQuery($query, $params);
    }

    public function deleteStudent($id): void
    {
        $query = "DELETE FROM Student WHERE stud_id = :id";
        $params = [":id" => $id];
        $this->repository->executeQuery($query, $params);
    }

    public function getStudentByFilter($entity){
        $email = isset($entity["stud_email"]) ? $entity["stud_email"] : null;
        $lrn = isset($entity["stud_lrn"]) ? $entity["stud_lrn"] : null;
        $params =[];
        $query = "SELECT * FROM Student WHERE 1=1 ";
        if(!empty($email)){
            $query .= 'AND STUD_EMAIL = :STUD_EMAIL ';
            $params[":STUD_EMAIL"] = $email;
        }
        if(!empty($lrn)){
            $query .= 'AND STUD_LRN = :STUD_LRN ';
            $params[":STUD_LRN"] = $lrn;
        }
        $result = $this->repository->executeQuery($query, $params);
        return $this->repository->BuildResultQuery($result);
    }

    private function StudentParameter($student)
    {
        $params = [
            ":STUD_FNAME" => $student->stud_fname,
            ":STUD_LNAME" => $student->stud_lname,
            ":STUD_MNAME" => $student->stud_mname,
            ":STUD_SUFFIX" => $student->stud_suffix,
            ":STUD_ADD" => $student->stud_add,
            ":STUD_LRN" => $student->stud_lrn,
            ":STUD_EMAIL" => $student->stud_email,
            ":STUD_DOB" => $student->stud_dob
        ];
        
        if (!empty($student->stud_id)) {
            $params[":STUD_ID"] = $student->stud_id;
        }

        return $params;
    }
}
?>
