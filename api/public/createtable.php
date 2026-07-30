<?php

require_once "../config/database.php";

try {


    $database = new Database();
    $db = $database->connect();

    $sql = "INSERT INTO super_admins
(
name,
email,
password
)
VALUES
(
'Sufiyan',
'admin@societyos.in',
'PASTE_HASH_HERE'
);";

    $db->exec($sql);

    echo "table created successfully.";

} catch (PDOException $e) {

    die($e->getMessage());

}
