<?php

require_once __DIR__ . "/../config/database.php";

class Payment
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function create($data)
    {
        $query = $this->db->prepare("
            INSERT INTO payments
            (
                society_id,
                user_id,
                plan_name,
                amount,
                currency,
                razorpay_order_id,
                status
            )
            VALUES
            (
                ?, ?, ?, ?, ?, ?, 'CREATED'
            )
        ");

        return $query->execute([
            $data["society_id"],
            $data["user_id"],
            $data["plan_name"],
            $data["amount"],
            $data["currency"],
            $data["razorpay_order_id"]
        ]);
    }

    public function getByOrderId($orderId)
    {
        $query = $this->db->prepare(
            "SELECT * FROM payments WHERE razorpay_order_id=?"
        );

        $query->execute([$orderId]);

        return $query->fetch();
    }

    public function markSuccess(
        $orderId,
        $paymentId,
        $signature,
        $method
    )
    {
        $query = $this->db->prepare("
            UPDATE payments
            SET
                razorpay_payment_id=?,
                razorpay_signature=?,
                payment_method=?,
                status='SUCCESS',
                paid_at=NOW()
            WHERE razorpay_order_id=?
        ");

        return $query->execute([
            $paymentId,
            $signature,
            $method,
            $orderId
        ]);
    }

    public function markFailed($orderId)
    {
        $query = $this->db->prepare("
            UPDATE payments
            SET status='FAILED'
            WHERE razorpay_order_id=?
        ");

        return $query->execute([$orderId]);
    }
}