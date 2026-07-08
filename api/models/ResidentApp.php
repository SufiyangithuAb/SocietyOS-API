<?php

class ResidentApp
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Resident Profile
    public function getProfile($userId)
    {
        $query = $this->conn->prepare("
            SELECT
                r.*,
                s.society_name
            FROM residents r
            INNER JOIN society_profile s
                ON s.society_id = r.society_id
            WHERE r.user_id = ?
        ");

        $query->execute([$userId]);

        return $query->fetch(PDO::FETCH_ASSOC);
    }

    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */

    public function getDashboard($userId)
    {
        /*
        |--------------------------------------------------------------------------
        | Resident Profile
        |--------------------------------------------------------------------------
        */

        $profileQuery = $this->conn->prepare(
            "SELECT
                r.id,
                r.user_id,
                r.society_id,
                r.name,
                r.flat_number,
                r.tower,
                r.resident_type,
                s.society_name
            FROM residents r
            INNER JOIN society_profile s
                ON s.society_id = r.society_id
            WHERE r.user_id = ?"
        );

        $profileQuery->execute([$userId]);

        $profile = $profileQuery->fetch(PDO::FETCH_ASSOC);

        if (!$profile) {
            return [];
        }

        /*
        |--------------------------------------------------------------------------
        | Latest Maintenance Bill
        |--------------------------------------------------------------------------
        */

        $billQuery = $this->conn->prepare(
            "SELECT
                bill_month,
                amount,
                due_date,
                status
            FROM maintenance_bills
            WHERE resident_id = ?
            ORDER BY id DESC
            LIMIT 1"
        );

        $billQuery->execute([
            $profile['id']
        ]);

        $bill = $billQuery->fetch(PDO::FETCH_ASSOC);

        /*
        |--------------------------------------------------------------------------
        | Complaint Summary
        |--------------------------------------------------------------------------
        */

        $complaintQuery = $this->conn->prepare(
            "SELECT
                COUNT(*) total,
                SUM(status='OPEN') open,
                SUM(status='RESOLVED') resolved
            FROM complaints
            WHERE resident_id = ?"
        );

        $complaintQuery->execute([
            $profile['id']
        ]);

        $complaints = $complaintQuery->fetch(PDO::FETCH_ASSOC);

        /*
        |--------------------------------------------------------------------------
        | Latest Notices
        |--------------------------------------------------------------------------
        */

        $noticeQuery = $this->conn->prepare(
            "SELECT
                id,
                title,
                description,
                created_at
            FROM notices
            WHERE society_id = ?
            ORDER BY id DESC
            LIMIT 5"
        );

        $noticeQuery->execute([
            $profile['society_id']
        ]);

        $notices = $noticeQuery->fetchAll(PDO::FETCH_ASSOC);

        /*
        |--------------------------------------------------------------------------
        | Dashboard Response
        |--------------------------------------------------------------------------
        */

        return [

            "profile" => $profile,

            "summary" => [

                "latest_bill" => $bill,

                "complaints" => $complaints

            ],

            "latest_notices" => $notices

        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Bills
    |--------------------------------------------------------------------------
    */

    public function getBills($userId)
    {
        /*
        |--------------------------------------------------------------------------
        | Get Resident Details
        |--------------------------------------------------------------------------
        */

        $residentQuery = $this->conn->prepare(
            "SELECT
                id,
                society_id
            FROM residents
            WHERE user_id = ?"
        );

        $residentQuery->execute([
            $userId
        ]);

        $resident = $residentQuery->fetch(PDO::FETCH_ASSOC);

        if (!$resident) {
            return [];
        }

        /*
        |--------------------------------------------------------------------------
        | Resident Bills
        |--------------------------------------------------------------------------
        */

        $billQuery = $this->conn->prepare(
            "SELECT
                id,
                bill_month,
                amount,
                due_date,
                status,
                created_at
            FROM maintenance_bills
            WHERE resident_id = ?
            ORDER BY id DESC"
        );

        $billQuery->execute([
            $resident['id']
        ]);

        return $billQuery->fetchAll(PDO::FETCH_ASSOC);
    }

    /*
    |--------------------------------------------------------------------------
    | Notices
    |--------------------------------------------------------------------------
    */

    public function getNotices($userId)
    {
        return [];
    }

    /*
    |--------------------------------------------------------------------------
    | Complaints
    |--------------------------------------------------------------------------
    */

    public function getComplaints($userId)
    {
        /*
        |--------------------------------------------------------------------------
        | Get Resident Information
        |--------------------------------------------------------------------------
        */

        $residentQuery = $this->conn->prepare(
            "SELECT
                id,
                society_id
            FROM residents
            WHERE user_id = ?"
        );

        $residentQuery->execute([
            $userId
        ]);

        $resident = $residentQuery->fetch(PDO::FETCH_ASSOC);

        if (!$resident) {
            return [];
        }

        /*
        |--------------------------------------------------------------------------
        | Get Complaints
        |--------------------------------------------------------------------------
        | Show:
        | 1. Resident's own complaints
        | 2. Society-wide complaints created by Admin
        |--------------------------------------------------------------------------
        */

        $query = $this->conn->prepare(
            "SELECT
                id,
                title,
                description,
                category,
                status,
                created_at,
                resident_id
            FROM complaints
            WHERE society_id = ?
            AND (
                    resident_id = ?
                    OR resident_id IS NULL
            )
            ORDER BY id DESC"
        );

        $query->execute([
            $resident['society_id'],
            $resident['id']
        ]);

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    /*
    |--------------------------------------------------------------------------
    | Create Complaint
    |--------------------------------------------------------------------------
    */

    public function createComplaint(
        $userId,
        $title,
        $description,
        $category
    )
    {
        /*
        |--------------------------------------------------------------------------
        | Get Resident
        |--------------------------------------------------------------------------
        */

        $residentQuery = $this->conn->prepare(
            "SELECT
                id,
                society_id
            FROM residents
            WHERE user_id = ?"
        );

        $residentQuery->execute([
            $userId
        ]);

        $resident = $residentQuery->fetch(PDO::FETCH_ASSOC);

        if(!$resident){
            return false;
        }

        /*
        |--------------------------------------------------------------------------
        | Create Complaint
        |--------------------------------------------------------------------------
        */

        $query = $this->conn->prepare(
            "INSERT INTO complaints
            (
                society_id,
                resident_id,
                title,
                description,
                category,
                status
            )
            VALUES
            (?, ?, ?, ?, ?, 'OPEN')"
        );

        return $query->execute([
            $resident['society_id'],
            $resident['id'],
            $title,
            $description,
            $category
        ]);
    }

    // Visitors
    public function getVisitors($userId)
    {
        // Future
    }

    // Payments
    public function getPayments($userId)
    {
        // Future
    }

    // Family Members
    public function getFamily($userId)
    {
        // Future
    }
}
