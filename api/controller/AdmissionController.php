<?php
require_once "api/Service/AdmissionService.php";

class AdmissionController{
    private AdmissionService $admissionService;
    public function __construct()
    {
        $this->admissionService = new AdmissionService();
    }

    public function getAllAdmission(){
        try{
            $admission = $this->admissionService->getAllAdmission();
            echo json_encode(["message" => "Successfully get Admission", "data" => $admission]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(["message" => $e->getMessage()]);
        }
    }
    public function getAdmissionById($id){
        try{
            $admission = $this->admissionService->getAdmissionById($id);
            echo json_encode(["message" => "Successfully get admission", "data" => $admission]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(["message" => $e->getMessage()]);
        }
    }   
    public function addAdmission($admission){
        try{
            $admission = $this->admissionService->addAdmission($admission);
            echo json_encode(["message" => "Successfully added admission","data" => $admission]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(["message" => $e->getMessage()]);
        }
    }
    public function updateAdmission($admission){
        try{
            $this->admissionService->updateAdmission($admission);
            echo json_encode(["message" => "Successfully updated admission"]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(["message" => $e->getMessage()]);
        }
    }

    public function deleteAdmission($id)
    {
        try{
            $this->admissionService->deleteAdmission($id);
            echo json_encode(["message" => "Successfully deleted Admission {$id}"]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(["message" => $e->getMessage()]);
        }
    }
}
?>