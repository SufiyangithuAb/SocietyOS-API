<?php

class MaintenanceBill
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function create(
        $societyId,
        $residentId,
        $billMonth,
        $amount
    )
    {
        $query = $this->conn->prepare(
            "INSERT INTO maintenance_bills
            (
                society_id,
                resident_id,
                bill_month,
                amount
            )
            VALUES
            (?, ?, ?, ?)"
        );

        return $query->execute([
            $societyId,
            $residentId,
            $billMonth,
            $amount
        ]);
    }

    public function getAll($societyId)
    {
        $query = $this->conn->prepare(
            "SELECT
                mb.*,
                r.name
            FROM maintenance_bills mb
            LEFT JOIN residents r
                ON mb.resident_id = r.id
            WHERE mb.society_id = ?
            ORDER BY mb.id DESC"
        );

        $query->execute([$societyId]);

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function markPaid(
        $id,
        $societyId
    )
    {
        $query = $this->conn->prepare(
            "UPDATE maintenance_bills
             SET status='PAID'
             WHERE id=?
             AND society_id=?"
        );

        $query->execute([
            $id,
            $societyId
        ]);

        return $query->rowCount();
    }
}