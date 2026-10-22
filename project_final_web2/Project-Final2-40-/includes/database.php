<?php
class Database
{
    private $host = "gonggang.net";
    private $user = "u910454988_eventrpj";
    private $pass = "LLBdtIR~4zlkoP5&";
    private $dbname = "u910454988_eventrpj";
    public $conn;

    public function getConnection()
    {
        $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->dbname);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }

        if (!$this->conn->set_charset("utf8mb4")) {
            die("Error loading character set utf8mb4: " . $this->conn->error);
        }

        $this->conn->query("SET NAMES 'utf8mb4' COLLATE 'utf8mb4_unicode_ci'");

        return $this->conn;
    }
}
