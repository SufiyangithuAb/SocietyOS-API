<?php

require_once "../config/database.php";

try {


    $database = new Database();
    $db = $database->connect();

    $sql = "CREATE TABLE backup_history (

id INT AUTO_INCREMENT PRIMARY KEY,

file_name VARCHAR(255),

file_size BIGINT,

storage ENUM('SERVER','GOOGLE_DRIVE','BOTH'),

status ENUM('SUCCESS','FAILED'),

created_by INT,

created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP

);";

    $db->exec($sql);

    echo "table created successfully.";

} catch (PDOException $e) {

    die($e->getMessage());

}
