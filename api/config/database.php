<?php
require 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__,2));
$dotenv->load();
class database{
    
    private $conn;
    private $db_host;
    private $db_port;
    private $db_user;
    private $db_pass;
    private $db_name;
    public function __construct()
    {
        $this->db_host = $_ENV["DB_HOST"];
        $this->db_port = $_ENV["DB_PORT"];
        $this->db_user = $_ENV["DB_USER"];
        $this->db_pass = $_ENV["DB_PASS"];
        $this->db_name = $_ENV["DB_NAME"];
    }
    public function getConnection():PDO
    {
        try{
            $this->conn = new PDO(
                "pgsql:host={$this->db_host};port={$this->db_port};dbname={$this->db_name}",
                $this->db_user,
                $this->db_pass  
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->conn;
        }catch(PDOException $e){
            die("Connection Failed: ". $e->getMessage());
        }
    }

}
?>