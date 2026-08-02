<?php

session_start();

if (!isset($_SESSION['backup_file'], $_SESSION['backup_name'])) {
    exit("Backup not found.");
}

$file = $_SESSION['backup_file'];
$name = $_SESSION['backup_name'];

if (!file_exists($file)) {
    exit("Backup file does not exist on the server.");
}

header("Content-Type: application/octet-stream");
header('Content-Disposition: attachment; filename="' . basename($name) . '"');
header("Content-Length: " . filesize($file));
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: public");

readfile($file);

/*
IMPORTANT:
DO NOT delete the backup here.

Server backups are retained for 90 days.
*/

unset($_SESSION['backup_file']);
unset($_SESSION['backup_name']);

exit;