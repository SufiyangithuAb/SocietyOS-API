<?php

class Plan
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getByName($name)
    {
        $query = $this->db->prepare("
            SELECT *
            FROM plans
            WHERE name = ?
            AND is_active = 1
            LIMIT 1
        ");

        $query->execute([
            strtoupper($name)
        ]);

        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function getAll()
    {
        $query = $this->db->prepare("
            SELECT *
            FROM plans
            WHERE is_active = 1
            ORDER BY amount ASC
        ");

        $query->execute();

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}