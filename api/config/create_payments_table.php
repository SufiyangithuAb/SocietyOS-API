<?php

require_once "../config/database.php";

try {

    $db = Database::connect();

    $sql = "
    CREATE TABLE IF NOT EXISTS payments (

        id INT AUTO_INCREMENT PRIMARY KEY,

        society_id INT NOT NULL,

        user_id INT NOT NULL,

        plan_name VARCHAR(100) NOT NULL,

        amount DECIMAL(10,2) NOT NULL,

        currency VARCHAR(10) NOT NULL DEFAULT 'INR',

        razorpay_order_id VARCHAR(100) NOT NULL UNIQUE,

        razorpay_payment_id VARCHAR(100) DEFAULT NULL,

        razorpay_signature TEXT,

        payment_method VARCHAR(50) DEFAULT NULL,

        status ENUM(
            'CREATED',
            'SUCCESS',
            'FAILED',
            'REFUNDED'
        ) DEFAULT 'CREATED',

        paid_at DATETIME DEFAULT NULL,

        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ON UPDATE CURRENT_TIMESTAMP,

        CONSTRAINT fk_payment_society
            FOREIGN KEY (society_id)
            REFERENCES societies(id)
            ON DELETE CASCADE,

        CONSTRAINT fk_payment_user
            FOREIGN KEY (user_id)
            REFERENCES users(id)
            ON DELETE CASCADE

    );
    ";

    $db->exec($sql);

    echo "Payments table created successfully.";

} catch (PDOException $e) {

    die($e->getMessage());

}
