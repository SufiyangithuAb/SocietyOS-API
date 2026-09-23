<?php

require_once "../config/database.php";

try {

    $database = new Database();
    $db = $database->connect();

    $db->exec("SET FOREIGN_KEY_CHECKS = 0;");

    $sql = START TRANSACTION;

DELETE FROM complaints
WHERE resident_id = 61;

DELETE FROM maintenance_bills
WHERE resident_id = 61;

DELETE FROM payments
WHERE user_id = 26;

DELETE FROM user_devices
WHERE user_id = 26;

DELETE FROM residents
WHERE id = 61
AND user_id = 26
AND society_id = 7;

DELETE FROM users
WHERE id = 26
AND society_id = 7;

-- Check the transaction's result
SELECT * FROM residents WHERE id = 61;
SELECT * FROM users WHERE id = 26;
SELECT * FROM complaints WHERE resident_id = 61;
SELECT * FROM maintenance_bills WHERE resident_id = 61;
SELECT * FROM user_devices WHERE user_id = 26;

-- If everything looks correct:
COMMIT;

    $db->exec($sql);

    $db->exec("SET FOREIGN_KEY_CHECKS = 1;");

    echo "Tables created successfully.";

} catch (PDOException $e) {

    try {
        if (isset($db)) {
            $db->exec("SET FOREIGN_KEY_CHECKS = 1;");
        }
    } catch (Exception $ignored) {
    }

    die($e->getMessage());
}
