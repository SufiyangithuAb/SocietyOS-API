<?php

class Society
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function getAll()
    {
        $stmt = $this->db->query("
            SELECT
                s.id,
                s.name,
                s.city,
                s.total_flats,
                p.name AS plan_name,
                u.name AS admin_name
            FROM societies s
            LEFT JOIN plans p
                ON s.plan_id = p.id
            LEFT JOIN users u
                ON s.admin_user_id = u.id
            ORDER BY s.id DESC
        ");

        return $stmt->fetchAll();
    }
}