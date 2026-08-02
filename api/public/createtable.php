<?php

require_once "../config/database.php";

try {


    $database = new Database();
    $db = $database->connect();

    $sql = "DROP TABLE backup_history;";

    $db->exec($sql);

    echo "table created successfully.";

} catch (PDOException $e) {

    die($e->getMessage());

}
