<?php

require_once __DIR__ . "/../config/database.php";
require_once __DIR__ . "/../models/Payment.php";

class PaymentController
{
    private Payment $payment;

    public function __construct()
    {
        $db = (new Database())->connect();
        $this->payment = new Payment($db);
    }

    public function index()
    {
        $search = trim($_GET['search'] ?? '');
        $status = trim($_GET['status'] ?? '');

        return $this->payment->getAll($search, $status);
    }
}