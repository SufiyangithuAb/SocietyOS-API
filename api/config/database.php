<?php

require_once __DIR__ . "/../helpers/response.php";

class Database
{
    private $conn;

    public function connect()
    {
        $this->conn = null;

        try {

            $host = getenv("MYSQLHOST");
            $port = getenv("MYSQLPORT");
            $db   = getenv("MYSQLDATABASE");
            $user = getenv("MYSQLUSER");
            $pass = getenv("MYSQLPASSWORD");

            $dsn = "mysql:host={$host};port={$port};dbname={$db};charset=utf8mb4";

            $this->conn = new PDO(
                $dsn,
                $user,
                $pass
            );

            $this->conn->setAttribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION
            );

            $this->conn->setAttribute(
                PDO::ATTR_DEFAULT_FETCH_MODE,
                PDO::FETCH_ASSOC
            );

        } catch (PDOException $e) {

            response(
                false,
                "Database Connection Failed",
                [
                    "error" => $e->getMessage()
                ]
            );

        }

        return $this->conn;
    }
}
