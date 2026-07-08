<?php

require_once "../models/Dashboard.php";
require_once "../helpers/response.php";

class DashboardController
{
    private $dashboard;

    public function __construct($db)
    {
        $this->dashboard =
            new Dashboard($db);
    }

    public function stats()
    {
        $user = $GLOBALS['auth_user'];

        $stats =
            $this->dashboard->getStats(
                $user['society_id']
            );

        response(
            true,
            "Dashboard loaded",
            $stats
        );
    }
}