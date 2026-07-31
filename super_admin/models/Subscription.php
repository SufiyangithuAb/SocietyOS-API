<?php

class Subscription
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
                sub.id,
                s.name AS society_name,
                sub.plan_name,
                sub.amount,
                sub.start_date,
                sub.expiry_date,
                sub.status
            FROM subscriptions sub
            INNER JOIN societies s
                ON sub.society_id = s.id
        ";

        $conditions = [];
        $params = [];

        if (!empty($search)) {
            $conditions[] = "s.name LIKE ?";
            $params[] = "%{$search}%";
        }

        if (!empty($status)) {
            $conditions[] = "sub.status = ?";
            $params[] = $status;
        }

        if (!empty($conditions)) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }

        $sql .= " ORDER BY sub.id DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}