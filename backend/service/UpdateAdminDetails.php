<?php
require_once "api/Controller/AdminController.php";
class UpdateAdminDetails{
    private AdminController $adminController;
    public function __construct()
    {
        $this->adminController = new AdminController();
    }

    public function updateAdmin($request)
    {
        if(password_verify($request["confirm_password"],$request["admin_old_password"])){
            if (!$this->isBcrypt($request["admin_password"])) {
                $request["admin_password"] = password_hash($request["admin_password"],PASSWORD_DEFAULT);
            }
            $this->adminController->updateAdmin($request);
        }else{
            throw new Exception("Incorrect Password");
        }
    }
    public function isBcrypt($hash) {
        return preg_match('/^\$2[aby]?\$\d{2}\$[\.\/A-Za-z0-9]{53}$/', $hash);
    }
}
?>