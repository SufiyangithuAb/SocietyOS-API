<?php

require_once "../config/database.php";

try {


    $database = new Database();
    $db = $database->connect();

    $sql = "
    INSERT INTO plans
(name, amount, duration_days, description)
VALUES
('BASIC', 999, 365, 'Basic Society Plan'),

('PREMIUM', 1999, 365, 'Premium Society Plan'),

('ENTERPRISE', 4999, 365, 'Enterprise Society Plan');
    ";

    $db->exec($sql);

    echo "Payments table created successfully.";

} catch (PDOException $e) {

    die($e->getMessage());

}
