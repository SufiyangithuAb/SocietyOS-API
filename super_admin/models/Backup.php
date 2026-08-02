<?php

class Backup
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function getTables()
    {
        return $this->db->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
    }

    public function getCreateTable($table)
    {
        return $this->db
            ->query("SHOW CREATE TABLE `$table`")
            ->fetch(PDO::FETCH_ASSOC);
    }

    public function getRows($table)
    {
        return $this->db
            ->query("SELECT * FROM `$table`")
            ->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getBackups()
    {
        $stmt = $this->db->query("
            SELECT *
            FROM backup_history
            ORDER BY created_at DESC
        ");

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}