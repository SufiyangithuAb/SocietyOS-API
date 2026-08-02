<?php

require_once __DIR__ . "/../config/database.php";
require_once __DIR__ . "/../models/Backup.php";

class BackupController
{
    private PDO $db;
    private Backup $backup;

    public function __construct()
    {
        $this->db = (new Database())->connect();
        $this->backup = new Backup($this->db);
    }

    public function createBackup()
    {
        $tables = $this->backup->getTables();

        $sql = "";

        $sql .= "-- SocietyOS Database Backup\n";
        $sql .= "-- Generated : " . date("Y-m-d H:i:s") . "\n\n";

        foreach ($tables as $table) {

            $create = $this->backup->getCreateTable($table);

            $sql .= "\nDROP TABLE IF EXISTS `$table`;\n";

            $sql .= $create['Create Table'] . ";\n\n";

            $rows = $this->backup->getRows($table);

            foreach ($rows as $row) {

                $columns = array_map(fn($c) => "`$c`", array_keys($row));

                $values = array_map(function ($v) {

                    if ($v === null) {
                        return "NULL";
                    }

                    return "'" . addslashes($v) . "'";

                }, array_values($row));

                $sql .= "INSERT INTO `$table` (" .
                    implode(",", $columns) .
                    ") VALUES (" .
                    implode(",", $values) .
                    ");\n";

            }

            $sql .= "\n\n";
        }

        $folder = __DIR__ . "/../storage/backups/";

        if (!is_dir($folder)) {
            mkdir($folder, 0777, true);
        }

        $file = "societyos_backup_" .
            date("Y_m_d_H_i_s") .
            ".sql";

        file_put_contents($folder . $file, $sql);

        $fullPath = $folder . $file;

        $fileSize = filesize($fullPath);

        $fileHash = hash_file('sha256', $fullPath);

        $stmt = $this->db->prepare("
        INSERT INTO backup_history
        (
        file_name,
        file_size,
        backup_hash,
        storage_type,
        status
        )

        VALUES
        (
        ?,
        ?,
        ?,
        'SERVER',
        'SUCCESS'
        )
        ");

        $stmt->execute([
            $file,
            $fileSize,
            $fileHash
        ]);

        return [
            'name' => $file,
            'path' => $folder . $file
        ];

        $this->cleanupOldBackups();
    }

    public function getBackups()
    {
        return $this->backup->getBackups();
    }

    private function cleanupOldBackups()
    {
        $days = $this->db
            ->query("SELECT retention_days FROM backup_settings LIMIT 1")
            ->fetchColumn();

        $folder = __DIR__ . "/../storage/backups/";

        $files = glob($folder . "*.sql");

        foreach($files as $file){

            if(filemtime($file) < strtotime("-{$days} days")){

                unlink($file);

                $stmt = $this->db->prepare(
                    "DELETE FROM backup_history WHERE file_name=?"
                );

                $stmt->execute([
                    basename($file)
                ]);
            }
        }
    }
}