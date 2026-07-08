<?php

class Resident
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function create(
        $societyId,
        $userId,
        $name,
        $email,
        $phone,
        $flatNumber,
        $tower,
        $residentType
    )
    {
        $query = $this->conn->prepare(
            "INSERT INTO residents
            (
                society_id,
                user_id,
                name,
                email,
                phone,
                flat_number,
                tower,
                resident_type
            )
            VALUES
            (?, ?, ?, ?, ?, ?, ?, ?)"
        );

        return $query->execute([
            $societyId,
            $userId,
            $name,
            $email,
            $phone,
            $flatNumber,
            $tower,
            $residentType
        ]);
    }

    public function getAll($societyId)
    {
        $query = $this->conn->prepare(
            "SELECT *
             FROM residents
             WHERE society_id = ?
             ORDER BY id DESC"
        );

        $query->execute([$societyId]);

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id, $societyId)
    {
        $query = $this->conn->prepare(
            "SELECT *
             FROM residents
             WHERE id = ?
             AND society_id = ?"
        );

        $query->execute([$id, $societyId]);

        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function delete($id, $societyId)
    {
        $query = $this->conn->prepare(
            "DELETE FROM residents
             WHERE id = ?
             AND society_id = ?"
        );

        return $query->execute([
            $id,
            $societyId
        ]);
    }
}