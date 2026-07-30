<?php

require_once __DIR__ . "/../config/database.php";
require_once __DIR__ . "/../models/Dashboard.php";

class DashboardController
{
    private Dashboard $dashboard;

    public function __construct()
    {
        $db = (new Database())->connect();

        $this->dashboard = new Dashboard($db);
    }

    public function index(): array
    {
        $stats = $this->dashboard->getStats();

        $stats['revenue'] = $this->dashboard->totalRevenue();

        return $stats;
    }
}