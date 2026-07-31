<?php

require_once "../config/database.php";

try {


    $database = new Database();
    $db = $database->connect();

    $sql = "INSERT INTO settings
(
site_name,
company_name,
support_email,
support_phone
)

VALUES
(
'SocietyOS',
'SocietyOS Technologies',
'admin@societyos.in',
'9876543210'
);";

    $db->exec($sql);

    echo "table created successfully.";

} catch (PDOException $e) {

    die($e->getMessage());

}
