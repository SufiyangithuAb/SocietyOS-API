<?php

require_once __DIR__ . "/../config/database.php";
require_once __DIR__ . "/../models/Society.php";

class SocietyController
{
    private Society $society;

    public function __construct()
    {
        $db = (new Database())->connect();
        $this->society = new Society($db);
    }

    public function index()
    {
        $search = trim($_GET['search'] ?? '');
        $status = trim($_GET['status'] ?? '');

        return $this->society->getAll($search, $status);
    }
}