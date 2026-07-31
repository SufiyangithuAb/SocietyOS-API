<?php

require_once __DIR__ . "/../config/database.php";
require_once __DIR__ . "/../models/Complaint.php";

class ComplaintController
{
    private Complaint $complaint;

    public function __construct()
    {
        $db = (new Database())->connect();
        $this->complaint = new Complaint($db);
    }

    public function index()
    {
        $search = trim($_GET['search'] ?? '');
        $status = trim($_GET['status'] ?? '');

        return $this->complaint->getAll($search, $status);
    }
}