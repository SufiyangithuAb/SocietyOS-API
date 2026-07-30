<?php

require_once "config/config.php";
require_once "config/database.php";

$db = (new Database())->connect();

echo "<h2>Super Admin Working ✅</h2>";

echo "<br>";

echo "Session Started : ";

echo session_id();

echo "<br><br>";

echo "Database Connected Successfully";