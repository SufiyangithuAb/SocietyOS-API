<?php

require_once "Subscription.php";

class Dashboard
{
    private $conn;
    private $subscription;

    public function __construct($db)
    {
        $this->conn = $db;

        $this->subscription =
                new Subscription($db);
    }

    private function getCount($table, $societyId)
    {
        $query = $this->conn->prepare(
            "SELECT COUNT(*) total
             FROM $table
             WHERE society_id = ?"
        );

        $query->execute([$societyId]);

        return $query->fetch(PDO::FETCH_ASSOC)['total'];
    }

    public function getStats($societyId)
    {
        $data = [];

        $data['total_residents'] =
            $this->getCount('residents', $societyId);

        $data['total_notices'] =
            $this->getCount('notices', $societyId);

        $data['total_complaints'] =
            $this->getCount('complaints', $societyId);

        $data['open_complaints'] =
            $this->getComplaintCount(
                $societyId,
                'OPEN'
            );

        $data['total_bills'] =
            $this->getCount(
                'maintenance_bills',
                $societyId
            );

        $data['paid_bills'] =
            $this->getBillCount(
                $societyId,
                'PAID'
            );

        $data['total_collection'] =
            $this->getCollection(
                $societyId,
                'PAID'
            );

        $data['unpaid_bills'] =
            $this->getBillCount(
                $societyId,
                'PENDING'
            );

        $data['pending_collection'] =
            $this->getCollection(
                $societyId,
                'PENDING'
            );

        $data['subscription'] =
            $this->subscription
                    ->getCurrentSubscription(
                            $societyId
                    );
                    
        return $data;
    }

    private function getComplaintCount(
        $societyId,
        $status
    )
    {
        $query = $this->conn->prepare(
            "SELECT COUNT(*) total
             FROM complaints
             WHERE society_id = ?
             AND status = ?"
        );

        $query->execute([
            $societyId,
            $status
        ]);

        return $query->fetch(PDO::FETCH_ASSOC)['total'];
    }

    private function getBillCount(
        $societyId,
        $status
    )
    {
        $query = $this->conn->prepare(
            "SELECT COUNT(*) total
             FROM maintenance_bills
             WHERE society_id = ?
             AND status = ?"
        );

        $query->execute([
            $societyId,
            $status
        ]);

        return $query->fetch(PDO::FETCH_ASSOC)['total'];
    }

    private function getCollection(
        $societyId,
        $status
    )
    {
        $query = $this->conn->prepare(
            "SELECT SUM(amount) total
             FROM maintenance_bills
             WHERE society_id = ?
             AND status = ?"
        );

        $query->execute([
            $societyId,
            $status
        ]);

        $result =
            $query->fetch(PDO::FETCH_ASSOC);

        return $result['total'] ?? 0;
    }
}