<?php

require_once "../config/database.php";

try {


    $database = new Database();
    $db = $database->connect();

    $sql = "CREATE TABLE settings (
    id INT AUTO_INCREMENT PRIMARY KEY,

    site_name VARCHAR(150) NOT NULL DEFAULT 'SocietyOS',

    company_name VARCHAR(150) DEFAULT NULL,

    support_email VARCHAR(150) DEFAULT NULL,

    support_phone VARCHAR(30) DEFAULT NULL,

    currency VARCHAR(10) DEFAULT 'INR',

    timezone VARCHAR(100) DEFAULT 'Asia/Kolkata',

    maintenance_mode TINYINT(1) DEFAULT 0,

    logo VARCHAR(255) DEFAULT NULL,

    favicon VARCHAR(255) DEFAULT NULL,

    address TEXT,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ON UPDATE CURRENT_TIMESTAMP
);";

    $db->exec($sql);

    echo "table created successfully.";

} catch (PDOException $e) {

    die($e->getMessage());

}
