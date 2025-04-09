<?php
require_once "api/Service/AdminService.php";
require_once "api/Service/StudentService.php";
    class AdminController{
        private StudentService $studentService;
        private AdminService $adminService;

        public function __construct(){
            $this->studentService = new StudentService();
            $this->adminService = new AdminService();
        }

        public function getAllAdmin(){
            try{
            $Admin = $this->adminService->getAllAdmin();
            echo json_encode(["Status" => "Success","data" => $Admin]);
            } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(["Status" => "Error","message" => $e->getMessage()]);
            }
        }

    public function getAdminByID($id)
    {
        try{
            $Admin = $this->adminService->getAdminByID($id);
            echo json_encode(["Status" => "Success","data" => $Admin]);
            } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(["Status" => "Error","message" => $e->getMessage()]);
        }
    }

    public function addAdmin($admin){
        try {
            $this->adminService->addAdmin($admin);
            echo json_encode(["message" => "Successfully Added Admin ".$admin['admin_fname']]);
        } catch(Exception $e) {
            http_response_code(400);
            echo json_encode(["message" => $e->getMessage()]);
        }   
    }

    public function updateAdmin($admin)
    {   
        try{
            $this->adminService->updateAdmin($admin);
            echo json_encode(["message" => "Successfully updated Admin ".$admin['admin_fname']]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(["message" => $e->getMessage()]);
        }        
    }
    public function deleteAdmin($id)
    {
        try{
            $this->adminService->deleteAdmin($id);
            echo json_encode(["message" => "Successfully deleted admin". $id]);
        }catch(Exception $e){
            http_response_code(400);
            echo json_encode(["message" => $e->getMessage()]);
        }
    }
    

    }
?>