<?php

require_once __DIR__ . "/../config/database.php";
require_once __DIR__ . "/../models/Notice.php";

class NoticeController
{
    private Notice $notice;

    public function __construct()
    {
        $db = (new Database())->connect();
        $this->notice = new Notice($db);
    }

    public function index()
    {
        $search = trim($_GET['search'] ?? '');

        return $this->notice->getAll($search);
    }
}