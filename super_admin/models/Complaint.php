<?php

class Complaint
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function getAll($search = '', $status = '')
    {
        $sql = "
            SELECT
                c.id,
                s.name AS society_name,
                u.name AS resident_name,
                c.title,
                c.category,
                c.status,
                c.created_at
            FROM complaints c
            LEFT JOIN societies s
                ON c.society_id = s.id
            LEFT JOIN users u
                ON c.resident_id = u.id
        ";

        $conditions = [];
        $params = [];

        if (!empty($search)) {
            $conditions[] = "(c.title LIKE ? OR u.name LIKE ?)";
            $params[] = "%{$search}%";
            $params[] = "%{$search}%";
        }

        if (!empty($status)) {
            $conditions[] = "c.status = ?";
            $params[] = $status;
        }

        if (!empty($conditions)) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }

        $sql .= " ORDER BY c.id DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}