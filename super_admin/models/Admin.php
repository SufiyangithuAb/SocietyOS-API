<?php

class Admin
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function login($email)
    {
        $query = $this->db->prepare("
            SELECT *
            FROM super_admins
            WHERE email=?
            LIMIT 1
        ");

        $query->execute([$email]);

        return $query->fetch(PDO::FETCH_ASSOC);
    }
}