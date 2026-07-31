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
            AND sub.status='ACTIVE'

        ORDER BY s.id DESC
        ";

        return $this->db->query($sql)->fetchAll();
    }
}