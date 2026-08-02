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
        $folder = __DIR__ . "/../storage/backups/";

        if (!is_dir($folder)) {
            return [];
        }

        $files = glob($folder . "*.sql");

        $backups = [];

        foreach ($files as $file) {

            $backups[] = [

                'name' => basename($file),

                'size' => filesize($file),

                'date' => filemtime($file)

            ];

        }

        usort($backups, function ($a, $b) {

            return $b['date'] - $a['date'];

        });

        return $backups;
    }
}