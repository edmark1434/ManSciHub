<?php
    require_once "api/Repository/AdminRepository.php";
    require_once "api/Service/ServiceLogic.php";
    require_once "api/Model/Admin.php";
class AdminService{
    private AdminRepository $adminRepository;
    private ServiceLogic $serviceLogic;
    public function __construct()
    {
        $this->adminRepository = new AdminRepository();
        $this->serviceLogic = new ServiceLogic();
    }
    public function getAllAdmin(): array{
        $Admin = $this->adminRepository->getAllAdmin();
        $result = $this->serviceLogic->checkGetMethod($Admin, "Admin Does not exist!");
        return $this->adminListObject($result);

    }
    public function getAdminByID(int $id){
        $Admin = $this->adminRepository->getAdminByID($id);
        $result = $this->serviceLogic->checkGetMethod($Admin, "Admin with {$id} Does not exist!");
        return $this->adminObject($result);
    }
    public function addAdmin($Admin){
        $this->serviceLogic->checkExistence(["admin_username" => $Admin["admin_username"]],  $this->adminRepository, 'getAdminByFilter', 'Username is already exist!');
        $Admin = $this->adminObject($Admin);
        $this->adminRepository->addAdmin($Admin);
    }
    public function updateAdmin($Admin){
        $this->serviceLogic->checkExistence($Admin["admin_id"],$this->adminRepository,'getAdminByID','Admin '.$Admin["admin_id"]. " Does not Exist!");
        $Admin = $this->adminObject($Admin);
        $this->adminRepository->updateAdmin($Admin);
    }
    public function deleteAdmin(int $id){
        $this->serviceLogic->checkExistence($id,$this->adminRepository,'getAdminByID','Admin '.$id. " Does not Exist!");
        $this->adminRepository->deleteAdmin($id);
    }

    public function adminObject($admin):Admin{
        $adminObject = new Admin();
        $adminObject->admin_id = $admin['admin_id'] ?? NULL;
        $adminObject->admin_fname = $admin['admin_fname'] ?? NULL;
        $adminObject->admin_lname = $admin['admin_lname'] ?? NULL;
        $adminObject->admin_username = $admin['admin_username'] ?? NULL;
        $adminObject->admin_password = $admin['admin_password'] ?? NULL;
        return $adminObject;
    }
    public function adminListObject($adminList): array
    {
        $adminObjects = [];
        foreach ($adminList as $admin) {
            $adminObjects[] = $this->adminObject($admin);
        }
        return $adminObjects;
    }

}
?>