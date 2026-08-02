<?php

session_start();

if(!isset($_SESSION['backup_file']))
{
    exit("Backup not found.");
}

$file = $_SESSION['backup_file'];

$name = $_SESSION['backup_name'];

if(!file_exists($file))
{
    exit("File missing.");
}

header("Content-Type: application/sql");

header("Content-Disposition: attachment; filename=".$name);

header("Content-Length: ".filesize($file));

readfile($file);

/*
Delete temporary file
*/

unlink($file);

unset($_SESSION['backup_file']);

unset($_SESSION['backup_name']);

exit;