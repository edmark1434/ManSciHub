<?php
require_once "api/Repository/AdminRepository.php";
class Login{
    private AdminRepository $adminRepository;
    public function __construct()
    {
        $this->adminRepository = new AdminRepository();
    }

    public function login($username, $password): array{
        $admin = $this->adminRepository->getAdminByFilter(["admin_username" => $username]);
        $admin_password = isset($admin['admin_password']) ? $admin['admin_password'] : null;
        $admin_username = isset($admin['admin_username']) ? $admin['admin_username'] : null;
        if (!empty($username || $password)) {
            if($admin_username === $username && password_verify($password,$admin_password)){
                return $admin;
            }else{
                throw new Exception("Incorrect Credentials");
            }
        }else{
            throw new Exception("Empty Fields");
        }
    }
}

?>