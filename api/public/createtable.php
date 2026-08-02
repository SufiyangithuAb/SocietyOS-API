<?php

require_once "../config/database.php";

try {


    $database = new Database();
    $db = $database->connect();

    $sql = "CREATE TABLE backup_history (

    id INT AUTO_INCREMENT PRIMARY KEY,

    file_name VARCHAR(255) NOT NULL,

    file_size BIGINT NOT NULL,

    storage_type ENUM('SERVER','GOOGLE_DRIVE','BOTH')
        DEFAULT 'SERVER',

    backup_hash CHAR(64) NOT NULL,

    drive_file_id VARCHAR(255) NULL,

    status ENUM('SUCCESS','FAILED')
        DEFAULT 'SUCCESS',

    created_by INT NULL,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP

);";

    $db->exec($sql);

    echo "table created successfully.";

} catch (PDOException $e) {

    die($e->getMessage());

}
