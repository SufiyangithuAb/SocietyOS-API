<?php

class ResidentReport
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    /*
    |--------------------------------------------------------------------------
    | RESIDENT STATISTICS
    |--------------------------------------------------------------------------
    */

    public function getResidentStatistics($societyId)
    {
        $query = $this->conn->prepare(
            "SELECT

                COUNT(*) AS total_residents,

                SUM(
                    CASE
                        WHEN resident_type = 'OWNER'
                        THEN 1
                        ELSE 0
                    END
                ) AS owners,

                SUM(
                    CASE
                        WHEN resident_type = 'TENANT'
                        THEN 1
                        ELSE 0
                    END
                ) AS tenants,

                COUNT(
                    DISTINCT NULLIF(tower, '')
                ) AS towers

            FROM residents

            WHERE society_id = ?"
        );

        $query->execute([
            $societyId
        ]);

        $result =
            $query->fetch(PDO::FETCH_ASSOC);

        return [
            "total_residents" =>
                (int)($result['total_residents'] ?? 0),

            "owners" =>
                (int)($result['owners'] ?? 0),

            "tenants" =>
                (int)($result['tenants'] ?? 0),

            "towers" =>
                (int)($result['towers'] ?? 0)
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | BILL SUMMARY
    |--------------------------------------------------------------------------
    */

    public function getBillSummary(
        $societyId,
        $billMonth
    )
    {
        $query = $this->conn->prepare(
            "SELECT

                COUNT(*) AS total_bills,

                COALESCE(
                    SUM(amount),
                    0
                ) AS total_billed,

                SUM(
                    CASE
                        WHEN status = 'PAID'
                        THEN 1
                        ELSE 0
                    END
                ) AS paid_bills,

                SUM(
                    CASE
                        WHEN status IS NULL
                             OR status != 'PAID'
                        THEN 1
                        ELSE 0
                    END
                ) AS pending_bills,

                COALESCE(
                    SUM(
                        CASE
                            WHEN status = 'PAID'
                            THEN amount
                            ELSE 0
                        END
                    ),
                    0
                ) AS paid_amount,

                COALESCE(
                    SUM(
                        CASE
                            WHEN status IS NULL
                                 OR status != 'PAID'
                            THEN amount
                            ELSE 0
                        END
                    ),
                    0
                ) AS outstanding_amount

            FROM maintenance_bills

            WHERE society_id = ?

            AND bill_month = ?"
        );

        $query->execute([
            $societyId,
            $billMonth
        ]);

        $result =
            $query->fetch(PDO::FETCH_ASSOC);

        $totalBilled =
            (float)($result['total_billed'] ?? 0);

        $paidAmount =
            (float)($result['paid_amount'] ?? 0);

        $collectionPercentage = 0;

        if ($totalBilled > 0) {

            $collectionPercentage =
                ($paidAmount / $totalBilled) * 100;
        }

        return [
            "total_bills" =>
                (int)($result['total_bills'] ?? 0),

            "paid_bills" =>
                (int)($result['paid_bills'] ?? 0),

            "pending_bills" =>
                (int)($result['pending_bills'] ?? 0),

            "total_billed" =>
                $totalBilled,

            "paid_amount" =>
                $paidAmount,

            "outstanding_amount" =>
                (float)($result['outstanding_amount'] ?? 0),

            "collection_percentage" =>
                round($collectionPercentage, 2)
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | RESIDENT-WISE BILLS
    |--------------------------------------------------------------------------
    */

    public function getResidentBills(
        $societyId,
        $billMonth
    )
    {
        $query = $this->conn->prepare(
            "SELECT

                mb.id AS bill_id,

                mb.resident_id,

                r.name,

                r.flat_number,

                r.tower,

                r.resident_type,

                mb.bill_month,

                mb.amount,

                mb.status,

                mb.paid_at

            FROM maintenance_bills mb

            INNER JOIN residents r
                ON mb.resident_id = r.id

            WHERE mb.society_id = ?

            AND mb.bill_month = ?

            ORDER BY
                r.tower ASC,
                r.flat_number ASC,
                r.name ASC"
        );

        $query->execute([
            $societyId,
            $billMonth
        ]);

        return $query->fetchAll(
            PDO::FETCH_ASSOC
        );
    }


    /*
    |--------------------------------------------------------------------------
    | TOWER-WISE BILL SUMMARY
    |--------------------------------------------------------------------------
    */

    public function getTowerStatistics(
        $societyId,
        $billMonth
    )
    {
        $query = $this->conn->prepare(
            "SELECT

                COALESCE(r.tower, 'Unknown')
                    AS tower,

                COUNT(DISTINCT r.id)
                    AS residents,

                COUNT(mb.id)
                    AS total_bills,

                COALESCE(
                    SUM(mb.amount),
                    0
                ) AS total_billed,

                COALESCE(
                    SUM(
                        CASE
                            WHEN mb.status = 'PAID'
                            THEN mb.amount
                            ELSE 0
                        END
                    ),
                    0
                ) AS paid_amount,

                COALESCE(
                    SUM(
                        CASE
                            WHEN mb.status IS NULL
                                 OR mb.status != 'PAID'
                            THEN mb.amount
                            ELSE 0
                        END
                    ),
                    0
                ) AS outstanding_amount

            FROM residents r

            LEFT JOIN maintenance_bills mb

                ON mb.resident_id = r.id

                AND mb.society_id = r.society_id

                AND mb.bill_month = ?

            WHERE r.society_id = ?

            GROUP BY r.tower

            ORDER BY r.tower ASC"
        );

        $query->execute([
            $billMonth,
            $societyId
        ]);

        return $query->fetchAll(
            PDO::FETCH_ASSOC
        );
    }


    /*
    |--------------------------------------------------------------------------
    | COMPLAINT SUMMARY
    |--------------------------------------------------------------------------
    */

    public function getComplaintSummary(
        $societyId,
        $billMonth
    )
    {
        $query = $this->conn->prepare(
            "SELECT

                COUNT(*) AS total_complaints,

                SUM(
                    CASE
                        WHEN status = 'OPEN'
                        THEN 1
                        ELSE 0
                    END
                ) AS open_complaints,

                SUM(
                    CASE
                        WHEN status = 'IN_PROGRESS'
                        THEN 1
                        ELSE 0
                    END
                ) AS in_progress_complaints,

                SUM(
                    CASE
                        WHEN status = 'RESOLVED'
                        THEN 1
                        ELSE 0
                    END
                ) AS resolved_complaints,

                SUM(
                    CASE
                        WHEN status = 'CLOSED'
                        THEN 1
                        ELSE 0
                    END
                ) AS closed_complaints

            FROM complaints

            WHERE society_id = ?

            AND DATE_FORMAT(
                created_at,
                '%Y-%m'
            ) = ?"
        );

        $query->execute([
            $societyId,
            $billMonth
        ]);

        $result =
            $query->fetch(PDO::FETCH_ASSOC);

        return [
            "total_complaints" =>
                (int)($result['total_complaints'] ?? 0),

            "open_complaints" =>
                (int)($result['open_complaints'] ?? 0),

            "in_progress_complaints" =>
                (int)($result['in_progress_complaints'] ?? 0),

            "resolved_complaints" =>
                (int)($result['resolved_complaints'] ?? 0),

            "closed_complaints" =>
                (int)($result['closed_complaints'] ?? 0)
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | COMPLAINT LIST
    |--------------------------------------------------------------------------
    */

    public function getComplaints(
        $societyId,
        $billMonth
    )
    {
        $query = $this->conn->prepare(
            "SELECT

                c.id,

                c.resident_id,

                r.name AS resident_name,

                r.flat_number,

                r.tower,

                c.title,

                c.description,

                c.status,

                c.created_at,

                c.updated_at

            FROM complaints c

            LEFT JOIN residents r
                ON c.resident_id = r.id

            WHERE c.society_id = ?

            AND DATE_FORMAT(
                c.created_at,
                '%Y-%m'
            ) = ?

            ORDER BY c.created_at DESC"
        );

        $query->execute([
            $societyId,
            $billMonth
        ]);

        return $query->fetchAll(
            PDO::FETCH_ASSOC
        );
    }
}
