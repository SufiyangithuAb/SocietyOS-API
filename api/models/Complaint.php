<?php

class Complaint
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function create(
        $societyId,
        $title,
        $description,
        $category
    )
    {
        $query = $this->conn->prepare(
            "INSERT INTO complaints
            (
                society_id,
                title,
                description,
                category
            )
            VALUES
            (?, ?, ?, ?)"
        );

        return $query->execute([
            $societyId,
            $title,
            $description,
            $category
        ]);
    }

    public function getAll($societyId)
    {
        $query = $this->conn->prepare(
            "SELECT *
             FROM complaints
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
             FROM complaints
             WHERE id = ?
             AND society_id = ?"
        );

        $query->execute([
            $id,
            $societyId
        ]);

        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function updateStatus(
        $id,
        $societyId,
        $status
    )
    {
        $query = $this->conn->prepare(
            "UPDATE complaints
             SET status = ?
             WHERE id = ?
             AND society_id = ?"
        );

        $query->execute([
            $status,
            $id,
            $societyId
        ]);

        return $query->rowCount();
    }

    public function delete($id, $societyId)
    {
        $query = $this->conn->prepare(
            "DELETE FROM complaints
             WHERE id = ?
             AND society_id = ?"
        );

        $query->execute([
            $id,
            $societyId
        ]);

        return $query->rowCount();
    }
}