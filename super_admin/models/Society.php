<?php

class Society
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
                s.id,
                s.name,
                s.city,
                s.total_flats,
                sub.plan_name,
                sub.status
            FROM societies s

            LEFT JOIN subscriptions sub
                ON sub.society_id = s.id
        ";

        $conditions = [];
        $params = [];

        if (!empty($search)) {
            $conditions[] = "(s.name LIKE ? OR s.city LIKE ?)";
            $params[] = "%{$search}%";
            $params[] = "%{$search}%";
        }

        if (!empty($status)) {
            $conditions[] = "sub.status = ?";
            $params[] = $status;
        }

        if (!empty($conditions)) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }

        $sql .= " ORDER BY s.id DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}