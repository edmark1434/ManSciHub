<?php
require_once "api/Service/AdminControlsService.php";
class AdminControlsController{
    private AdminControlsService $adminControlsService;
    public function __construct(){
        $this->adminControlsService = new AdminControlsService();
    }

    public function getAllAdminControls(){
        try{
            $adminControls = $this->adminControlsService->getAllAdminControls();
            echo json_encode(["message" => "Successfully get Admin Controls","data" => $adminControls]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(["message"=> $e->getMessage()]);
        }
    }
    public function getAdminControlsByKey($key){
        try{
            $adminControls = $this->adminControlsService->getAdminControlsByKey($key);
            echo json_encode(["message" => "Successfully get Admin Controls","data" => $adminControls]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(["message"=> $e->getMessage()]);
        }
    }
    public function addAdminControls($adminControls){
        try{
            $this->adminControlsService->addAdminControls($adminControls);
            echo json_encode(["message" => "Successfully added Admin Controls {$adminControls["ctrl_key"]}"]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(["message"=> $e->getMessage()]);
        }
    }
    public function updateAdminControls($adminControls){
        try{
            $this->adminControlsService->updateAdminControls($adminControls);
            echo json_encode(["message" => "Successfully updated Admin Controls {$adminControls["ctrl_key"]}"]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(["message"=> $e->getMessage()]);
        }
    }
    public function deleteAdminControls($key){
        try{
            $this->adminControlsService->deleteAdminControls($key);
            echo json_encode(["message" => "Successfully deleted Admin Controls {$key}"]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(["message"=> $e->getMessage()]);
        }
    }
}

?>