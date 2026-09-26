<?php

require_once "../models/ResidentReport.php";
require_once "../helpers/response.php";
require_once "../helpers/SubscriptionMiddleware.php";

class ResidentReportController
{
    private $report;
    private $db;

    public function __construct($db)
    {
        $this->db = $db;

        $this->report =
            new ResidentReport($db);
    }


    /*
    |--------------------------------------------------------------------------
    | MONTHLY REPORT
    |--------------------------------------------------------------------------
    */

    public function monthly()
    {
        $user =
            $GLOBALS['auth_user'];

        SubscriptionMiddleware::requireActive(
            $this->db,
            $user["society_id"]
        );

        /*
        |--------------------------------------------------------------------------
        | Get month
        |--------------------------------------------------------------------------
        */

        $month =
            $_GET['month'] ?? '';

        /*
        |--------------------------------------------------------------------------
        | Validate month
        |--------------------------------------------------------------------------
        */

        if (
            !preg_match(
                '/^\d{4}-(0[1-9]|1[0-2])$/',
                $month
            )
        ) {

            response(
                false,
                "Invalid month. Use YYYY-MM format."
            );

            return;
        }


        $societyId =
            $user['society_id'];


        /*
        |--------------------------------------------------------------------------
        | Build report
        |--------------------------------------------------------------------------
        */

        $report = [

            "report_month" =>
                $month,

            "generated_at" =>
                date("Y-m-d H:i:s"),

            "residents" =>
                $this->report
                    ->getResidentStatistics(
                        $societyId
                    ),

            "billing" =>
                $this->report
                    ->getBillSummary(
                        $societyId,
                        $month
                    ),

            "resident_bills" =>
                $this->report
                    ->getResidentBills(
                        $societyId,
                        $month
                    ),

            "tower_statistics" =>
                $this->report
                    ->getTowerStatistics(
                        $societyId,
                        $month
                    ),

            "complaints" =>
                $this->report
                    ->getComplaintSummary(
                        $societyId,
                        $month
                    ),

            "complaint_list" =>
                $this->report
                    ->getComplaints(
                        $societyId,
                        $month
                    )
        ];


        /*
        |--------------------------------------------------------------------------
        | Return report
        |--------------------------------------------------------------------------
        */

        response(
            true,
            "Monthly report generated successfully",
            $report
        );
    }
}
