<?php

header("Content-Type: application/json");

require_once __DIR__ . "/../config/database.php";

try {

    $db = (new Database())->connect();

    $sql = "
        CREATE TABLE IF NOT EXISTS user_devices (

            id INT AUTO_INCREMENT PRIMARY KEY,

            user_id INT NOT NULL,
            society_id INT NOT NULL,

            fcm_token TEXT NOT NULL,

            device_type VARCHAR(20) DEFAULT 'ANDROID',

            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                ON UPDATE CURRENT_TIMESTAMP,

            CONSTRAINT fk_user_devices_user
                FOREIGN KEY (user_id)
                REFERENCES users(id)
                ON DELETE CASCADE,

            INDEX idx_user_id (user_id),
            INDEX idx_society_id (society_id)

        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    ";

    $db->exec($sql);

    echo json_encode([
        "success" => true,
        "message" => "user_devices table created successfully"
    ]);

} catch (PDOException $e) {

    http_response_code(500);

    echo json_encode([
        "success" => false,
        "message" => "Failed to create user_devices table",
        "error" => $e->getMessage()
    ]);
}
