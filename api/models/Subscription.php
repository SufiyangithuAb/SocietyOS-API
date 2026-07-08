<?php

class Subscription
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function createTrial($societyId)
    {
        $query = $this->conn->prepare(
            "INSERT INTO subscriptions
            (
                society_id,
                plan_name,
                amount,
                start_date,
                expiry_date,
                status
            )
            VALUES
            (
                ?,
                'TRIAL',
                0,
                CURDATE(),
                DATE_ADD(CURDATE(), INTERVAL 30 DAY),
                'ACTIVE'
            )"
        );

        return $query->execute([$societyId]);
    }

    public function getCurrentSubscription($societyId)
    {
        $query = $this->conn->prepare(
            "SELECT
                plan_name,
                amount,
                start_date,
                expiry_date,
                status,
                DATEDIFF(expiry_date, CURDATE()) AS days_left
             FROM subscriptions
             WHERE society_id = ?
             AND status = 'ACTIVE'
             ORDER BY id DESC
             LIMIT 1"
        );

        $query->execute([$societyId]);

        $subscription = $query->fetch(PDO::FETCH_ASSOC);

        if (!$subscription) {

            return null;

        }

        return $subscription;
    }
}