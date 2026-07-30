<?php

class Database
{
    private $host = "mysql.railway.internal";
    private $db_name = "railway";
    private $username = "root";
    private $password = "KInyvkFHRxEzXDzBEmQbDXoRvyyNitaz";

    public $conn;

    public function connect()
    {
        $this->conn = null;

        try {

            $this->conn = new PDO(
                "mysql:host={$this->host};dbname={$this->db_name};charset=utf8mb4",
                $this->username,
                $this->password
            );

            $this->conn->setAttribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION
            );

        } catch (PDOException $e) {

            die($e->getMessage());

        }

        return $this->conn;
    }
}