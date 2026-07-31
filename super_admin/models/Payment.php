<?php

class Payment
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
                p.id,
                s.name AS society_name,
                u.name AS paid_by,
                p.plan_name,
                p.amount,
                p.payment_method,
                p.razorpay_payment_id,
                p.status,
                p.paid_at
            FROM payments p
            LEFT JOIN societies s
                ON p.society_id = s.id
            LEFT JOIN users u
                ON p.user_id = u.id
        ";

        $conditions = [];
        $params = [];

        if (!empty($search)) {
            $conditions[] = "(s.name LIKE ? OR u.name LIKE ?)";
            $params[] = "%{$search}%";
            $params[] = "%{$search}%";
        }

        if (!empty($status)) {
            $conditions[] = "p.status = ?";
            $params[] = $status;
        }

        if ($conditions) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }

        $sql .= " ORDER BY p.id DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}