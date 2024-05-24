<?php
require_once ROOT_PATH . "/bootstrap.php";

class Database
{
    private $servername;
    private $username;
    private $password;
    private $dbname;
    private $conn;

    public function __construct()
    {
        $this->servername = SERVER;
        $this->username = USER;
        $this->password = PASSWORD;
        $this->dbname = DATABASE;

        try {
            $this->conn = new PDO("mysql:host=$this->servername;dbname=$this->dbname", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            die("Conexión fallida: " . $e->getMessage());
        }
    }

    public function getConnection()
    {
        return $this->conn;
    }
}
