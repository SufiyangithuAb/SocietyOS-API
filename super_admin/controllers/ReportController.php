<?php

require_once __DIR__ . "/../config/database.php";
require_once __DIR__ . "/../models/Report.php";

class ReportController
{
    private Report $report;

    public function __construct()
    {
        $db = (new Database())->connect();
        $this->report = new Report($db);
    }

    public function dashboard()
    {
        return $this->report->dashboard();
    }
}