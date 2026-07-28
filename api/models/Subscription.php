<?php

class Subscription
{
    private $conn;
    private $db;

    public function __construct($db)
    {
        $this->conn = $db;
        $this->db = $db;
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

    public function activatePremium(
        $societyId,
        $planName,
        $amount,
        $durationDays
    )
    {
        $query = $this->conn->prepare("
            UPDATE subscriptions
            SET
                plan_name = ?,
                amount = ?,
                start_date = CURDATE(),
                expiry_date = DATE_ADD(CURDATE(), INTERVAL ? DAY),
                status = 'ACTIVE'
            WHERE society_id = ?
        ");

        return $query->execute([
            $planName,
            $amount,
            $durationDays,
            $societyId
        ]);
    }

    public function isActive($societyId)
    {
        $query = $this->db->prepare("
            SELECT *
            FROM subscriptions
            WHERE society_id = ?
            LIMIT 1
        ");

        $query->execute([$societyId]);

        $subscription = $query->fetch(PDO::FETCH_ASSOC);

        if (!$subscription) {
            return false;
        }

        if ($subscription["status"] !== "ACTIVE") {
            return false;
        }

        if (strtotime($subscription["expiry_date"]) < strtotime(date("Y-m-d"))) {

            $update = $this->db->prepare("
                UPDATE subscriptions
                SET status='EXPIRED'
                WHERE society_id=?
            ");

            $update->execute([$societyId]);

            return false;
        }

        return true;
    }
}
