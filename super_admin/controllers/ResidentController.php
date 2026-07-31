<?php

require_once __DIR__ . "/../config/database.php";
require_once __DIR__ . "/../models/Resident.php";

class ResidentController
{
    private Resident $resident;

    public function __construct()
    {
        $db = (new Database())->connect();
        $this->resident = new Resident($db);
    }

    public function index()
    {
        $search = trim($_GET['search'] ?? '');
        $society = trim($_GET['society'] ?? '');
        $status = trim($_GET['status'] ?? '');

        return $this->resident->getAll($search, $society, $status);
    }
}