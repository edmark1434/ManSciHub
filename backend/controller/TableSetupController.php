<?php
require_once "backend/service/tableSetUp.php";

class LoginController extends TableSetup{
    public function createTablesIfNotExist(){
        try{
            $this->createTablesIfNotExist();
            echo json_encode(["message" => "Table created successfully"]);
        } catch (Exception $e) {
            http_response_code(401);
            echo json_encode(value: ["message" => $e->getMessage()]);
        }
    }
}
?>