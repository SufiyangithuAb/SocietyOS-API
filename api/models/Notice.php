<?php

class Notice
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function create(
        $societyId,
        $createdBy,
        $title,
        $description
    )
    {
        $query = $this->conn->prepare(
            "INSERT INTO notices
            (
                society_id,
                created_by,
                title,
                description
            )
            VALUES
            (?, ?, ?, ?)"
        );

        return $query->execute([
            $societyId,
            $createdBy,
            $title,
            $description
        ]);
    }

    public function getAll($societyId)
    {
        $query = $this->conn->prepare(
            "SELECT *
             FROM notices
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
             FROM notices
             WHERE id = ?
             AND society_id = ?"
        );

        $query->execute([
            $id,
            $societyId
        ]);

        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function delete($id, $societyId)
    {
        $query = $this->conn->prepare(
            "DELETE FROM notices
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