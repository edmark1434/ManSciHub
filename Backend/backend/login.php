<?php
require_once "api/Repository/AdminRepository.php";
class Login{
    private AdminRepository $adminRepository;
    public function __construct()
    {
        $this->adminRepository = new AdminRepository();
    }

    public function login($username, $password): void{
        $admin = $this->adminRepository->getAdminByUsername($username);
        $admin_password = isset($admin['admin_password']) ? $admin['admin_password'] : null;
        $admin_username = isset($admin['admin_username']) ? $admin['admin_username'] : null;
        $hash_pass = password_hash($admin_password, PASSWORD_DEFAULT);
        if (!empty($username || $password)) {
            if($admin_username === $username && password_verify($password,$hash_pass)){
                echo json_encode(["message"=> "Login Successfully!","data" => $admin]);
            }else{
                http_response_code(400);
                echo json_encode(["message"=> "Incorrect Credentials!"]);
            }
        }else{
            http_response_code(400);
            echo json_encode(["message"=> "Fields is Empty, Please Input"]);
        }
    }
}

?>