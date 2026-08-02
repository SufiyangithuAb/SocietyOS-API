<?php

class Database
{
    private $host;
    private $db;
    private $user;
    private $pass;

    public function __construct()
    {
        $this->host = getenv('MYSQLHOST') ?: 'mysql.railway.internal';
        $this->db   = getenv('MYSQLDATABASE') ?: 'railway';
        $this->user = getenv('MYSQLUSER') ?: 'root';
        $this->pass = getenv('MYSQLPASSWORD') ?: '';
    }

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