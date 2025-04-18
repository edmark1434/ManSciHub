<?php
require_once "api/Repository/RepositoryLogic.php";

class AdminRepository {
    private RepositoryLogic $repositoryLogic;

    public function __construct() {
        $this->repositoryLogic = new RepositoryLogic();
    }

    public function getAllAdmin(): array {
        $query = "SELECT * FROM ADMIN";
        return  $this->repositoryLogic->executeQuery($query, []);
    }

    public function getAdminByID(int $id): ?array {
        $query = "SELECT * FROM ADMIN WHERE ADMIN_ID = :ADMIN_ID";
        $params = [":ADMIN_ID" => $id];
        $result = $this->repositoryLogic->executeQuery($query, $params);
        return $this->repositoryLogic->BuildResultQuery($result);
    }

    // public function SearchAdmin($username = null,$userLname = null, $userFname = null){
    //     $query = "SELECT * FROM ADMIN WHERE";
    //     if (!empty($username)) {
    //         $query .= "UPPER(ADMIN_USER)";
    //     }

    // }

    public function getAdminByFilter($params){
        $username = isset( $params["admin_username"] ) ? $params["admin_username"] :null;
        $admin_fname = isset( $params["admin_fname"] ) ? $params["admin_fname"] :null;
        $params = [];
        $query = "SELECT * FROM ADMIN WHERE 1=1 ";
        if(!empty($username)){
            $query .= "AND ADMIN_USERNAME = :ADMIN_USERNAME";
            $params[":ADMIN_USERNAME"] = $username;
        }
        if(!empty($admin_fname)){
            $query .= "AND ADMIN_FNAME = :ADMIN_FNAME";
            $params[":ADMIN_FNAME"] = $admin_fname;
        }
        $result = $this->repositoryLogic->executeQuery($query, $params);
        return $this->repositoryLogic->BuildResultQuery($result);
    }
    public function addAdmin($admin) {
        $query = "INSERT INTO ADMIN (ADMIN_USERNAME, ADMIN_PASSWORD, ADMIN_FNAME, ADMIN_LNAME)
                VALUES (:ADMIN_USERNAME, :ADMIN_PASSWORD, :ADMIN_FNAME, :ADMIN_LNAME)";
        $params = $this->AdminParameter($admin);
        $params[":ADMIN_PASSWORD"] =  password_hash( $admin->admin_password, PASSWORD_DEFAULT );
        $this->repositoryLogic->executeQuery($query, $params);
        
    }

    public function updateAdmin($admin) {
        $query = "UPDATE ADMIN 
                SET ADMIN_USERNAME = :ADMIN_USERNAME, 
                    ADMIN_PASSWORD = :ADMIN_PASSWORD,
                    ADMIN_FNAME = :ADMIN_FNAME, 
                    ADMIN_LNAME = :ADMIN_LNAME,
                    ADMIN_IS_ACTIVE = :ADMIN_IS_ACTIVE 
                WHERE ADMIN_ID = :ADMIN_ID";
        $params = $this->AdminParameter($admin);
        $this->repositoryLogic->executeQuery($query, $params);
    }

    public function deleteAdmin(int $id) {
        $query = "DELETE FROM ADMIN WHERE ADMIN_ID = :ADMIN_ID";
        $params = [":ADMIN_ID" => $id];
        $this->repositoryLogic->executeQuery($query, $params);
    }

        public function AdminParameter($admin):array{
        $params = [
            ":ADMIN_USERNAME" => $admin->admin_username,
            ":ADMIN_PASSWORD" => $admin->admin_password,
            ":ADMIN_FNAME" => $admin->admin_fname,
            ":ADMIN_LNAME" => $admin->admin_lname
        ];
        if (!empty($admin->admin_id)) {
            $params[":ADMIN_ID"] = $admin->admin_id;
        }
        if($admin->admin_is_active !== null){
            $params[":ADMIN_IS_ACTIVE"] = $admin->admin_is_active;
        }
        return $params;
    }

}
?>
