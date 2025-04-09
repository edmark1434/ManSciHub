<?php
require_once "api/Service/StudentService.php";

class StudentController{
    private StudentService $studentService;
    public function __construct()
    {
        $this->studentService = new StudentService();
    }

    public function getAllStudent(){
        try{
            $student = $this->studentService->getAllStudent();
            echo json_encode(["message" => "Successfully get student", "data" => $student]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(["message" => $e->getMessage()]);
        }
    }
    public function getStudentById($id){
        try{
            $student = $this->studentService->getStudentByID($id);
            echo json_encode(["message" => "Successfully get student", "data" => $student]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(["message" => $e->getMessage()]);
        }
    }    public function addStudent($student): void{
        try{
            $this->studentService->addStudent($student);
            echo json_encode(["message" => "Successfully added student {$student['stud_lrn']}"]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(["message" => $e->getMessage()]);
        }
    }
    public function updateStudent($student){
        try{
            $this->studentService->updateStudent($student);
            echo json_encode(["message" => "Successfully updated student {$student['stud_id']}"]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(["message" => $e->getMessage()]);
        }
    }

    public function deleteStudent($id)
    {
        try{
            $this->studentService->deleteStudent($id);
            echo json_encode(["message" => "Successfully deleted student {$id}"]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(["message" => $e->getMessage()]);
        }
    }
}

?>