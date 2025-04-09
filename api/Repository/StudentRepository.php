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

    public function addStudent(Student $student)
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
                stud_dob = :STUD_DOB,
                stud_enroll = :STUD_ENROLL
                WHERE stud_id = :STUD_ID";
        $params = $this->StudentParameter($student);
        $this->repository->executeQuery($query, $params);
    }

    public function updateRejectedStudent(){
    $query = "UPDATE Student
    SET stud_enroll = false
    WHERE stud_id IN (
        SELECT stud_id
        FROM Admission_History
        WHERE admhs_status != 'ACCEPTED')";
    $this->repository->executeQuery($query, []);
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
        $stud_fname = isset($entity["stud_fname"]) ? $entity["stud_fname"] : null;
        $stud_lname = isset($entity["stud_lname"]) ? $entity["stud_lname"] : null;
        $stud_mname = isset($entity["stud_mname"]) ? $entity["stud_mname"] : null;
        $stud_suffix = isset($entity["stud_suffix"]) ? $entity["stud_suffix"] : null;
        $stud_suffix = isset($entity["stud_enroll"]) ? $entity["stud_enroll"] : null;
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
        if(!empty($stud_enroll)){
            $query .= "AND STUD_ENROLL = :STUD_ENROLL ";
            $params["STUD_ENROLL"] = $stud_enroll;
        }
        if (!empty($stud_fname) && !empty($stud_lname)) {
            $query .= "AND STUD_FNAME = :STUD_FNAME AND STUD_LNAME = :STUD_LNAME ";
            $params[":STUD_FNAME"] = $stud_fname;
            $params[":STUD_LNAME"] = $stud_lname;
            if(!empty($stud_mname)){
                $query .= "AND STUD_MNAME = :STUD_MNAME ";
                $params[":STUD_MNAME"] = $stud_mname;
            }
            if (!empty($stud_suffix)) {
                $query .= "AND STUD_SUFFIX = :STUD_SUFFIX";
                $params[":STUD_SUFFIX"] = $stud_suffix;
            }
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
