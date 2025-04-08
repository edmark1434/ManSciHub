<?php
require_once "api/config/database.php";

class RepositoryLogic{
    private $connection;
    public function __construct()
    {
        $db = new database();
        $this->connection = $db->getConnection();
    }
    public function BuildResultQuery($result):?array{
        if(!isset($result[0]) || empty($result[0])){
            return null;
        }
        return $result[0];
    }
    public function executeQuery($query, $param) :?array
    {
        $stmt = $this->connection->prepare($query);
        $stmt->execute($param);
        if (stripos($query, "SELECT") === 0) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        return null;
    }


}
?>