<?php

class Database
{
    private $host = "mysql.railway.internal";
    private $db = "railway";
    private $user = "root";
    private $pass = "KInyvkFHRxEzXDzBEmQbDXoRvyyNitaz";

    public function connect()
    {
        try {

            return new PDO(
                "mysql:host={$this->host};dbname={$this->db};charset=utf8mb4",
                $this->user,
                $this->pass,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]
            );

        } catch (PDOException $e) {

            die($e->getMessage());

        }
    }
}