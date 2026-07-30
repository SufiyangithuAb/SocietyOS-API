<?php

require_once "config/config.php";
require_once "config/database.php";

$db = (new Database())->connect();

echo "Database Connected Successfully ✅";