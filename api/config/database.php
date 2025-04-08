<?php

class database{
    private $conn;
    private $db_host = "localhost";
    private $db_port = 5432;
    private $db_user = "postgres";
    private $db_pass = "F1R3eX17";
    private $db_name = "ManSci";
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