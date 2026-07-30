<?php

class Admin
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    /**
     * Get admin by email
     */
    public function findByEmail(string $email)
    {
        $stmt = $this->db->prepare("
            SELECT *
            FROM super_admins
            WHERE email = ?
            LIMIT 1
        ");

        $stmt->execute([$email]);

        return $stmt->fetch();
    }

    /**
     * Get admin by ID
     */
    public function findById(int $id)
    {
        $stmt = $this->db->prepare("
            SELECT *
            FROM super_admins
            WHERE id = ?
            LIMIT 1
        ");

        $stmt->execute([$id]);

        return $stmt->fetch();
    }

    /**
     * Update Last Login
     */
    public function updateLastLogin(int $id)
    {
        $stmt = $this->db->prepare("
            UPDATE super_admins
            SET last_login = NOW()
            WHERE id = ?
        ");

        return $stmt->execute([$id]);
    }
}