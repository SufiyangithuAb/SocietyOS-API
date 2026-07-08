<?php

class User
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function findByEmail($email)
    {
        $query = $this->conn->prepare(
            "SELECT * FROM users WHERE email = ?"
        );

        $query->execute([$email]);

        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function createAdmin(
        $societyId,
        $name,
        $email,
        $phone,
        $password
    )
    {
        $query = $this->conn->prepare(
            "INSERT INTO users
            (
                society_id,
                name,
                email,
                phone,
                password,
                role,
                status
            )
            VALUES
            (?, ?, ?, ?, ?, 'ADMIN', 'ACTIVE')"
        );

        $query->execute([
            $societyId,
            $name,
            $email,
            $phone,
            $password
        ]);

        return $this->conn->lastInsertId();
    }

    public function createResident(
        $societyId,
        $name,
        $email,
        $phone,
        $password
    )
    {
        $query = $this->conn->prepare(
            "INSERT INTO users
            (
                society_id,
                name,
                email,
                phone,
                password,
                role,
                status
            )
            VALUES
            (?, ?, ?, ?, ?, 'RESIDENT', 'ACTIVE')"
        );

        $query->execute([
            $societyId,
            $name,
            $email,
            $phone,
            $password
        ]);

        return $this->conn->lastInsertId();
    }
}