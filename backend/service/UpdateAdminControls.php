<?php
require_once "api/Controller/AdminControlsController.php";
class UpdateAdminControls{
    private AdminControlsController $adminControlsController;
    public function __construct()
    {
        $this->adminControlsController = new AdminControlsController();
    }

    public function updateControls($request)
    {
        if(password_verify($request["confirm_password"],$request["admin_password"])){
            $this->adminControlsController->updateAdminControls($request);
        }else{
            throw new Exception("Incorrect Password");
        }
    }
}
?>