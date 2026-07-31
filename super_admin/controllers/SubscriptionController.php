<?php

require_once __DIR__ . "/../config/database.php";
require_once __DIR__ . "/../models/Subscription.php";

class SubscriptionController
{
    private Subscription $subscription;

    public function __construct()
    {
        $db = (new Database())->connect();
        $this->subscription = new Subscription($db);
    }

    public function index()
    {
        $search = trim($_GET['search'] ?? '');
        $status = trim($_GET['status'] ?? '');

        return $this->subscription->getAll($search, $status);
    }
}