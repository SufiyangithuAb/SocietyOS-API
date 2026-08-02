<?php

require_once "../config/database.php";

try {


    $database = new Database();
    $db = $database->connect();

    $sql = "CREATE TABLE backup_settings (

    id INT PRIMARY KEY,

    retention_days INT NOT NULL DEFAULT 90,

    auto_backup TINYINT(1) DEFAULT 1,

    google_drive_sync TINYINT(1) DEFAULT 0,

    compress_backup TINYINT(1) DEFAULT 1,

    backup_time TIME DEFAULT '02:00:00'

); INSERT INTO backup_settings
(
    id,
    retention_days,
    auto_backup,
    google_drive_sync,
    compress_backup,
    backup_time
)
VALUES
(
    1,
    90,
    1,
    0,
    1,
    '02:00:00'
);";

    $db->exec($sql);

    echo "table created successfully.";

} catch (PDOException $e) {

    die($e->getMessage());

}
