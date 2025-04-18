<?php
require_once "api/controller/AdminController.php";

class CreateAdmin{
    private AdminController $adminController;
    public function __construct()
    {
        $this->adminController = new AdminController();
    }

    public function CreateAdmin($request)
    {
        if(password_verify($request["confirm_password"],$request["admin_old_password"])){
            $this->adminController->addAdmin($request);
        }else{
            throw new Exception("Incorrect Password");
        }
    }
}
?>