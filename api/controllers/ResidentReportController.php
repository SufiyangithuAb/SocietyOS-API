<?php

require_once "../models/ResidentReport.php";
require_once "../helpers/response.php";
require_once "../helpers/SubscriptionMiddleware.php";

require_once "../vendor/autoload.php";

use Dompdf\Dompdf;
use Dompdf\Options;

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
    | BUILD MONTHLY REPORT DATA
    |--------------------------------------------------------------------------
    */

    private function buildMonthlyReport($societyId, $month)
    {
        return [

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
    }


    /*
    |--------------------------------------------------------------------------
    | MONTHLY JSON REPORT
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

        $month =
            $_GET['month'] ?? '';

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

        $report =
            $this->buildMonthlyReport(
                $societyId,
                $month
            );

        response(
            true,
            "Monthly report generated successfully",
            $report
        );
    }


    /*
    |--------------------------------------------------------------------------
    | PDF REPORT
    |--------------------------------------------------------------------------
    */

    public function pdf()
    {
        $user =
            $GLOBALS['auth_user'];

        SubscriptionMiddleware::requireActive(
            $this->db,
            $user["society_id"]
        );

        $month =
            $_GET['month'] ?? '';

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
        | Get report data
        |--------------------------------------------------------------------------
        */

        $report =
            $this->buildMonthlyReport(
                $societyId,
                $month
            );


        /*
        |--------------------------------------------------------------------------
        | Create HTML
        |--------------------------------------------------------------------------
        */

        $html = $this->buildPdfHtml(
            $report
        );


        /*
        |--------------------------------------------------------------------------
        | Configure Dompdf
        |--------------------------------------------------------------------------
        */

        $options =
            new Options();

        $options->set(
            'isRemoteEnabled',
            true
        );

        $options->set(
            'defaultFont',
            'DejaVu Sans'
        );

        $dompdf =
            new Dompdf($options);


        $dompdf->loadHtml(
            $html
        );

        $dompdf->setPaper(
            'A4',
            'portrait'
        );

        $dompdf->render();


        /*
        |--------------------------------------------------------------------------
        | Send PDF
        |--------------------------------------------------------------------------
        */

        $filename =
            "SocietyOS_Report_" .
            $month .
            ".pdf";

        header(
            "Content-Type: application/pdf"
        );

        header(
            "Content-Disposition: inline; filename=\"" .
            $filename .
            "\""
        );

        echo $dompdf->output();

        exit;
    }


    /*
    |--------------------------------------------------------------------------
    | BUILD PDF HTML
    |--------------------------------------------------------------------------
    */

    private function buildPdfHtml($report)
    {
        $month =
            htmlspecialchars(
                $report['report_month']
            );

        $generatedAt =
            htmlspecialchars(
                $report['generated_at']
            );

        $residents =
            $report['residents'];

        $billing =
            $report['billing'];

        $complaints =
            $report['complaints'];

        $html = '

        <!DOCTYPE html>

        <html>

        <head>

        <meta charset="UTF-8">

        <style>

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
            color: #222;
            margin: 25px;
        }

        h1 {
            font-size: 22px;
            margin-bottom: 5px;
        }

        h2 {
            font-size: 15px;
            margin-top: 25px;
            border-bottom: 1px solid #444;
            padding-bottom: 5px;
        }

        .subtitle {
            color: #666;
            margin-bottom: 20px;
        }

        .summary-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .summary-table td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        .summary-label {
            font-weight: bold;
            width: 70%;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th {
            background: #21755A;
            color: white;
            padding: 6px;
            text-align: left;
        }

        td {
            border: 1px solid #ddd;
            padding: 6px;
        }

        .page-break {
            page-break-before: always;
        }

        .footer {
            margin-top: 30px;
            font-size: 8px;
            color: #777;
            text-align: center;
        }

        </style>

        </head>

        <body>

        <h1>SocietyOS</h1>

        <div class="subtitle">
            Monthly Society Report — ' .
            $month .
            '<br>
            Generated: ' .
            $generatedAt .
            '
        </div>


        <h2>Resident Statistics</h2>

        <table class="summary-table">

            <tr>
                <td class="summary-label">
                    Total Residents
                </td>
                <td>' .
                ($residents['total_residents'] ?? 0) .
                '</td>
            </tr>

            <tr>
                <td class="summary-label">
                    Owners
                </td>
                <td>' .
                ($residents['owners'] ?? 0) .
                '</td>
            </tr>

            <tr>
                <td class="summary-label">
                    Tenants
                </td>
                <td>' .
                ($residents['tenants'] ?? 0) .
                '</td>
            </tr>

            <tr>
                <td class="summary-label">
                    Towers
                </td>
                <td>' .
                ($residents['towers'] ?? 0) .
                '</td>
            </tr>

        </table>


        <h2>Billing Summary</h2>

        <table class="summary-table">

            <tr>
                <td class="summary-label">
                    Total Bills
                </td>
                <td>' .
                ($billing['total_bills'] ?? 0) .
                '</td>
            </tr>

            <tr>
                <td class="summary-label">
                    Paid Bills
                </td>
                <td>' .
                ($billing['paid_bills'] ?? 0) .
                '</td>
            </tr>

            <tr>
                <td class="summary-label">
                    Pending Bills
                </td>
                <td>' .
                ($billing['pending_bills'] ?? 0) .
                '</td>
            </tr>

            <tr>
                <td class="summary-label">
                    Overdue Bills
                </td>
                <td>' .
                ($billing['overdue_bills'] ?? 0) .
                '</td>
            </tr>

            <tr>
                <td class="summary-label">
                    Total Billed
                </td>
                <td>₹' .
                number_format(
                    (float)($billing['total_billed'] ?? 0),
                    2
                ) .
                '</td>
            </tr>

            <tr>
                <td class="summary-label">
                    Paid Amount
                </td>
                <td>₹' .
                number_format(
                    (float)($billing['paid_amount'] ?? 0),
                    2
                ) .
                '</td>
            </tr>

            <tr>
                <td class="summary-label">
                    Outstanding Amount
                </td>
                <td>₹' .
                number_format(
                    (float)($billing['outstanding_amount'] ?? 0),
                    2
                ) .
                '</td>
            </tr>

            <tr>
                <td class="summary-label">
                    Collection Percentage
                </td>
                <td>' .
                ($billing['collection_percentage'] ?? 0) .
                '%
                </td>
            </tr>

        </table>


        <div class="page-break"></div>

        <h2>Resident Bills</h2>

        <table>

            <thead>

                <tr>
                    <th>Resident</th>
                    <th>Flat</th>
                    <th>Tower</th>
                    <th>Type</th>
                    <th>Amount</th>
                    <th>Status</th>
                </tr>

            </thead>

            <tbody>
        ';


        foreach (
            $report['resident_bills']
            as $bill
        ) {

            $html .= '

                <tr>

                    <td>' .
                    htmlspecialchars(
                        $bill['name'] ?? ''
                    ) .
                    '</td>

                    <td>' .
                    htmlspecialchars(
                        $bill['flat_number'] ?? ''
                    ) .
                    '</td>

                    <td>' .
                    htmlspecialchars(
                        $bill['tower'] ?? ''
                    ) .
                    '</td>

                    <td>' .
                    htmlspecialchars(
                        $bill['resident_type'] ?? ''
                    ) .
                    '</td>

                    <td>₹' .
                    number_format(
                        (float)($bill['amount'] ?? 0),
                        2
                    ) .
                    '</td>

                    <td>' .
                    htmlspecialchars(
                        $bill['status'] ?? ''
                    ) .
                    '</td>

                </tr>

            ';
        }


        $html .= '

            </tbody>

        </table>


        <h2>Tower Statistics</h2>

        <table>

            <thead>

                <tr>

                    <th>Tower</th>
                    <th>Residents</th>
                    <th>Bills</th>
                    <th>Billed</th>
                    <th>Paid</th>
                    <th>Outstanding</th>

                </tr>

            </thead>

            <tbody>

        ';


        foreach (
            $report['tower_statistics']
            as $tower
        ) {

            $html .= '

                <tr>

                    <td>' .
                    htmlspecialchars(
                        $tower['tower'] ?? ''
                    ) .
                    '</td>

                    <td>' .
                    ($tower['residents'] ?? 0) .
                    '</td>

                    <td>' .
                    ($tower['total_bills'] ?? 0) .
                    '</td>

                    <td>₹' .
                    number_format(
                        (float)($tower['total_billed'] ?? 0),
                        2
                    ) .
                    '</td>

                    <td>₹' .
                    number_format(
                        (float)($tower['paid_amount'] ?? 0),
                        2
                    ) .
                    '</td>

                    <td>₹' .
                    number_format(
                        (float)($tower['outstanding_amount'] ?? 0),
                        2
                    ) .
                    '</td>

                </tr>

            ';
        }


        $html .= '

            </tbody>

        </table>


        <div class="page-break"></div>

        <h2>Complaint Summary</h2>

        <table class="summary-table">

            <tr>
                <td class="summary-label">
                    Total Complaints
                </td>
                <td>' .
                ($complaints['total_complaints'] ?? 0) .
                '</td>
            </tr>

            <tr>
                <td class="summary-label">
                    Open
                </td>
                <td>' .
                ($complaints['open_complaints'] ?? 0) .
                '</td>
            </tr>

            <tr>
                <td class="summary-label">
                    Assigned
                </td>
                <td>' .
                ($complaints['assigned_complaints'] ?? 0) .
                '</td>
            </tr>

            <tr>
                <td class="summary-label">
                    In Progress
                </td>
                <td>' .
                ($complaints['in_progress_complaints'] ?? 0) .
                '</td>
            </tr>

            <tr>
                <td class="summary-label">
                    Resolved
                </td>
                <td>' .
                ($complaints['resolved_complaints'] ?? 0) .
                '</td>
            </tr>

            <tr>
                <td class="summary-label">
                    Closed
                </td>
                <td>' .
                ($complaints['closed_complaints'] ?? 0) .
                '</td>
            </tr>

            <tr>
                <td class="summary-label">
                    Resolution Percentage
                </td>
                <td>' .
                ($complaints['resolution_percentage'] ?? 0) .
                '%
                </td>
            </tr>

        </table>


        <h2>Complaint Details</h2>

        <table>

            <thead>

                <tr>

                    <th>ID</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th>Created</th>

                </tr>

            </thead>

            <tbody>

        ';


        foreach (
            $report['complaint_list']
            as $complaint
        ) {

            $html .= '

                <tr>

                    <td>' .
                    ($complaint['id'] ?? '') .
                    '</td>

                    <td>' .
                    htmlspecialchars(
                        $complaint['title'] ?? ''
                    ) .
                    '</td>

                    <td>' .
                    htmlspecialchars(
                        $complaint['category'] ?? ''
                    ) .
                    '</td>

                    <td>' .
                    htmlspecialchars(
                        $complaint['status'] ?? ''
                    ) .
                    '</td>

                    <td>' .
                    htmlspecialchars(
                        $complaint['created_at'] ?? ''
                    ) .
                    '</td>

                </tr>

            ';
        }


        $html .= '

            </tbody>

        </table>


        <div class="footer">
            SocietyOS — Monthly Society Report
        </div>

        </body>

        </html>

        ';


        return $html;
    }
}