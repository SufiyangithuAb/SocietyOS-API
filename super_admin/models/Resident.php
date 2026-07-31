<?php

class Resident
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function getAll($search = '', $society = '', $status = '')
    {
        $sql = "
            SELECT
                u.id,
                u.name,
                u.email,
                u.phone,
                u.role,
                u.status,
                s.name AS society_name
            FROM users u
            LEFT JOIN societies s
                ON u.society_id = s.id
            WHERE u.role = 'RESIDENT'
        ";

        $params = [];

        if (!empty($search)) {
            $sql .= " AND (
                u.name LIKE ?
                OR u.email LIKE ?
                OR u.phone LIKE ?
            )";

            $params[] = "%{$search}%";
            $params[] = "%{$search}%";
            $params[] = "%{$search}%";
        }

        if (!empty($society)) {
            $sql .= " AND u.society_id = ?";
            $params[] = $society;
        }

        if (!empty($status)) {
            $sql .= " AND u.status = ?";
            $params[] = $status;
        }

        $sql .= " ORDER BY u.id DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}