<?php
require_once "api/Repository/RepositoryLogic.php";

class AdminControlsRepository{
    private RepositoryLogic $repositoryLogic;

    public function __construct(){
        $this->repositoryLogic = new RepositoryLogic();
    }

    public function getAllAdminControls()
    {
        $query = "SELECT * FROM Admin_Controls";
        return $this->repositoryLogic->executeQuery( $query ,[]);
    }
        public function getAdminControlsByKey($key)
    {
        $query = "SELECT * FROM Admin_Controls WHERE CTRL_KEY = :CTRL_KEY";
        $params = [":CTRL_KEY" => $key];
        $result = $this->repositoryLogic->executeQuery( $query , $params );
        return $this->repositoryLogic->BuildResultQuery($result);
    }
    public function getAdminControlsByFilter($params){
        $ctrl_key = isset($params["ctrl_key"]) ? $params["ctrl_key"] :null;
        if (!empty($ctrl_key)) {
            return $this->getAdminControlsByKey( $ctrl_key );
        }
    }
    public function addAdminControls($adminControls){
        $query = "INSERT INTO Admin_Controls (CTRL_KEY,CTRL_VALUE) VALUES (:CTRL_KEY,:CTRL_VALUE)";
        $params = $this->AdminControlsParameter($adminControls);
        $this->repositoryLogic->executeQuery( $query , $params );
    }
    public function updateAdminControls($adminControls){
        $query = "UPDATE Admin_Controls SET  CTRL_VALUE = :CTRL_VALUE WHERE CTRL_KEY = :CTRL_KEY";
        $params = $this->AdminControlsParameter($adminControls);
        $this->repositoryLogic->executeQuery( $query , $params );
    }
    public function deleteAdminControls($key)
    {
        $query = "DELETE FROM Admin_Controls WHERE CTRL_KEY = :CTRL_KEY";
        $params = [":CTRL_KEY" => $key];
        $this->repositoryLogic->executeQuery( $query , $params );
    }
    public function AdminControlsParameter($adminControls){
        $params =[
            ":CTRL_KEY" => $adminControls->ctrl_key,
            ":CTRL_VALUE" => $adminControls->ctrl_value
        ];
        return $params;
    }

}
?>