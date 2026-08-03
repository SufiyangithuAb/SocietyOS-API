<?php

require_once "../config/database.php";

try {


    $database = new Database();
    $db = $database->connect();

    $sql = "CREATE TABLE google_tokens (

    id INT AUTO_INCREMENT PRIMARY KEY,

    email VARCHAR(255) NOT NULL,

    refresh_token TEXT NOT NULL,

    connected_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    last_used TIMESTAMP NULL

);";

    $db->exec($sql);

    echo "table created successfully.";

} catch (PDOException $e) {

    die($e->getMessage());

}
