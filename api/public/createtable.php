<?php

require_once "../config/database.php";

try {


    $database = new Database();
    $db = $database->connect();

    $sql = "
    CREATE TABLE plans (

    id INT AUTO_INCREMENT PRIMARY KEY,

    name VARCHAR(50),

    amount DECIMAL(10,2),

    duration_days INT,

    is_active TINYINT(1) DEFAULT 1
);
    ";

    $db->exec($sql);

    echo "Payments table created successfully.";

} catch (PDOException $e) {

    die($e->getMessage());

}
