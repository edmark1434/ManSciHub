<?php
require_once "api/Repository/StudentRepository.php";
require_once "api/Service/ServiceLogic.php";
require_once "api/Model/Student.php";
class StudentService{
    private StudentRepository $studentRepository;
    private  ServiceLogic $serviceLogic;

    public function __construct(){
        $this->studentRepository = new StudentRepository();
        $this->serviceLogic = new ServiceLogic();
    }

    public function getAllStudent(){
        $student = $this->studentRepository->getAllStudent();
        $student = $this->serviceLogic->checkGetMethod($student, "No data fetch");
        return $this->StudentObjectList($student);
    }
    public function getStudentByID($id){
        $student = $this->studentRepository->getStudentById($id);
        $student = $this->serviceLogic->checkGetMethod($student, "Student with {$id} Does not Exist!");
        return $this->StudentObject($student);
    }

    public function addStudent($student)
    {
        $this->serviceLogic->checkExistence(["stud_email" => $student["stud_email"]], $this->studentRepository, 'getStudentByFilter', "Email is already used");
        $this->serviceLogic->checkExistence(["stud_lrn" => $student["stud_lrn"]], $this->studentRepository, 'getStudentByFilter', "Lrn is already exist");
        $student = $this->StudentObject($student);
        $this->studentRepository->addStudent($student);
    }
    public function updateStudent($student){
        $this->serviceLogic->checkExistence($student["stud_id"],$this->studentRepository,'getStudentById',"Student with {$student["stud_id"]} Does not Exist!");
        $student = $this->StudentObject($student);
        $this->studentRepository->updateStudent($student);
    }

    public function deleteStudent($id){
        $this->serviceLogic->checkExistence($id,$this->studentRepository,'getStudentById',"Student with {$id} Does not Exist!");
        $this->studentRepository->deleteStudent($id);
    }

    private function StudentObject($entity){
        $student = new Student();
        $student->stud_id = $entity['stud_id'] ?? NULL;
        $student->stud_fname = $entity['stud_fname'] ?? NULL;
        $student->stud_lname = $entity['stud_lname'] ?? NULL;
        $student->stud_mname = $entity['stud_mname'] ?? NULL;
        $student->stud_suffix = $entity['stud_suffix'] ?? NULL;
        $student->stud_lrn = $entity['stud_lrn'] ?? NULL;
        $student->stud_email = $entity['stud_email'] ?? NULL;
        $student->stud_add = $entity['stud_add'] ?? NULL;
        $student->stud_dob = $entity['stud_dob'] ?? NULL;
        return $student;
    }

    private function StudentObjectList($student){
        $studentList = [];
        foreach ($student as $stud){
            $studentList[] = $this->StudentObject($stud);
        }
        return $studentList;
    }
}
?>