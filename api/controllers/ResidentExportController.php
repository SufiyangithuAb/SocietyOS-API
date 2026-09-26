<?php

require_once "../models/ResidentReport.php";
require_once "../models/ResidentStatistics.php";
require_once "../helpers/SubscriptionMiddleware.php";

require_once "../vendor/autoload.php";

use Dompdf\Dompdf;
use Dompdf\Options;


class ResidentExportController
{
    private $db;
    private $report;
    private $statistics;

    public function __construct($db)
    {
        $this->db = $db;

        $this->report = new ResidentReport($db);

        $this->statistics = new ResidentStatistics($db);
    }


    public function monthlyPdf()
    {
        $admin = $GLOBALS['auth_user'];

        SubscriptionMiddleware::requireActive(
            $this->db,
            $admin["society_id"]
        );

        $societyId = $admin["society_id"];

        $month = $_GET['month'] ?? date('Y-m');


        if (!preg_match('/^\d{4}-\d{2}$/', $month)) {

            http_response_code(400);

            echo "Invalid month format";

            return;
        }


        $startDate = $month . "-01";

        $endDate = date(
            'Y-m-d',
            strtotime(
                $startDate . " +1 month"
            )
        );


        try {

            $residents =
                $this->report->getAllResidents(
                    $societyId
                );

            $newResidents =
                $this->report->getResidents(
                    $societyId,
                    $startDate,
                    $endDate
                );

            $bills =
                $this->report->getBills(
                    $societyId,
                    $startDate,
                    $endDate
                );

            $complaints =
                $this->report->getComplaints(
                    $societyId,
                    $startDate,
                    $endDate
                );

            $payments =
                $this->report->getPayments(
                    $societyId,
                    $startDate,
                    $endDate
                );

            $residentStats =
                $this->statistics->getStatistics(
                    $societyId
                );

            $billStats =
                $this->report->getBillStatistics(
                    $societyId,
                    $startDate,
                    $endDate
                );

            $complaintStats =
                $this->report->getComplaintStatistics(
                    $societyId,
                    $startDate,
                    $endDate
                );


            $html = $this->buildHtml(
                $month,
                $residents,
                $newResidents,
                $bills,
                $complaints,
                $payments,
                $residentStats,
                $billStats,
                $complaintStats
            );


            $options = new Options();

            $options->set(
                'isRemoteEnabled',
                true
            );

            $options->set(
                'defaultFont',
                'DejaVu Sans'
            );


            $dompdf = new Dompdf($options);

            $dompdf->loadHtml($html);

            $dompdf->setPaper(
                'A4',
                'portrait'
            );

            $dompdf->render();


            $filename =
                "SocietyOS_Report_" .
                $month .
                ".pdf";


            $dompdf->stream(
                $filename,
                [
                    "Attachment" => true
                ]
            );


        } catch (Exception $e) {

            http_response_code(500);

            echo $e->getMessage();
        }
    }


    private function buildHtml(
        $month,
        $residents,
        $newResidents,
        $bills,
        $complaints,
        $payments,
        $residentStats,
        $billStats,
        $complaintStats
    ) {

        $monthName = date(
            'F Y',
            strtotime($month . "-01")
        );


        $html = "

        <!DOCTYPE html>

        <html>

        <head>

        <meta charset='UTF-8'>

        <style>

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
            color: #222;
        }

        h1 {
            text-align: center;
            margin-bottom: 5px;
        }

        h2 {
            margin-top: 25px;
            border-bottom: 1px solid #999;
            padding-bottom: 5px;
        }

        .subtitle {
            text-align: center;
            color: #666;
            margin-bottom: 20px;
        }

        .stats {
            width: 100%;
            margin-bottom: 20px;
        }

        .stats td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        .number {
            font-size: 18px;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }

        th {
            background: #21755A;
            color: white;
            padding: 6px;
            border: 1px solid #ddd;
        }

        td {
            padding: 5px;
            border: 1px solid #ddd;
        }

        .page-break {
            page-break-before: always;
        }

        .right {
            text-align: right;
        }

        </style>

        </head>

        <body>

        <h1>SocietyOS</h1>

        <div class='subtitle'>
            Monthly Society Report — {$monthName}
        </div>


        <h2>Society Statistics</h2>

        <table class='stats'>

        <tr>

        <td>
            <div class='number'>
                " . ($residentStats['total_residents'] ?? 0) . "
            </div>
            Total Residents
        </td>

        <td>
            <div class='number'>
                " . ($residentStats['owners'] ?? 0) . "
            </div>
            Owners
        </td>

        <td>
            <div class='number'>
                " . ($residentStats['tenants'] ?? 0) . "
            </div>
            Tenants
        </td>

        <td>
            <div class='number'>
                " . ($residentStats['towers'] ?? 0) . "
            </div>
            Towers
        </td>

        </tr>

        </table>


        <h2>Maintenance Bills</h2>

        <table class='stats'>

        <tr>

        <td>
            <div class='number'>
                " . ($billStats['total_bills'] ?? 0) . "
            </div>
            Total Bills
        </td>

        <td>
            <div class='number'>
                ₹" . number_format(
                    $billStats['total_amount'] ?? 0,
                    2
                ) . "
            </div>
            Total Amount
        </td>

        <td>
            <div class='number'>
                ₹" . number_format(
                    $billStats['paid_amount'] ?? 0,
                    2
                ) . "
            </div>
            Paid
        </td>

        <td>
            <div class='number'>
                ₹" . number_format(
                    $billStats['pending_amount'] ?? 0,
                    2
                ) . "
            </div>
            Pending
        </td>

        </tr>

        </table>


        <h2>Complaint Statistics</h2>

        <table>

        <tr>

        <th>Total</th>
        <th>Open</th>
        <th>In Progress</th>
        <th>Resolved</th>
        <th>Closed</th>

        </tr>

        <tr>

        <td>
            " . ($complaintStats['total_complaints'] ?? 0) . "
        </td>

        <td>
            " . ($complaintStats['open_complaints'] ?? 0) . "
        </td>

        <td>
            " . ($complaintStats['in_progress_complaints'] ?? 0) . "
        </td>

        <td>
            " . ($complaintStats['resolved_complaints'] ?? 0) . "
        </td>

        <td>
            " . ($complaintStats['closed_complaints'] ?? 0) . "
        </td>

        </tr>

        </table>
        ";


        /*
         * New Residents
         */

        $html .= "

        <div class='page-break'></div>

        <h2>Residents</h2>

        <table>

        <tr>

        <th>Name</th>
        <th>Flat</th>
        <th>Tower</th>
        <th>Type</th>
        <th>Phone</th>

        </tr>
        ";


        foreach ($residents as $resident) {

            $html .= "

            <tr>

            <td>" .
                htmlspecialchars(
                    $resident['name']
                ) .
            "</td>

            <td>" .
                htmlspecialchars(
                    $resident['flat_number']
                ) .
            "</td>

            <td>" .
                htmlspecialchars(
                    $resident['tower']
                ) .
            "</td>

            <td>" .
                htmlspecialchars(
                    $resident['resident_type']
                ) .
            "</td>

            <td>" .
                htmlspecialchars(
                    $resident['phone']
                ) .
            "</td>

            </tr>";
        }


        $html .= "

        </table>


        <h2>Monthly New Residents</h2>

        <table>

        <tr>

        <th>Name</th>
        <th>Flat</th>
        <th>Tower</th>
        <th>Type</th>
        <th>Created</th>

        </tr>
        ";


        foreach ($newResidents as $resident) {

            $html .= "

            <tr>

            <td>" .
                htmlspecialchars(
                    $resident['name']
                ) .
            "</td>

            <td>" .
                htmlspecialchars(
                    $resident['flat_number']
                ) .
            "</td>

            <td>" .
                htmlspecialchars(
                    $resident['tower']
                ) .
            "</td>

            <td>" .
                htmlspecialchars(
                    $resident['resident_type']
                ) .
            "</td>

            <td>" .
                htmlspecialchars(
                    $resident['created_at']
                ) .
            "</td>

            </tr>";
        }


        $html .= "</table>";


        /*
         * Bills
         */

        $html .= "

        <div class='page-break'></div>

        <h2>Maintenance Bills — {$month}</h2>

        <table>

        <tr>

        <th>Resident</th>
        <th>Flat</th>
        <th>Bill Month</th>
        <th>Amount</th>
        <th>Status</th>

        </tr>
        ";


        foreach ($bills as $bill) {

            $html .= "

            <tr>

            <td>" .
                htmlspecialchars(
                    $bill['resident_name'] ?? '-'
                ) .
            "</td>

            <td>" .
                htmlspecialchars(
                    $bill['flat_number'] ?? '-'
                ) .
            "</td>

            <td>" .
                htmlspecialchars(
                    $bill['bill_month'] ?? '-'
                ) .
            "</td>

            <td class='right'>
                ₹" .
                number_format(
                    $bill['amount'] ?? 0,
                    2
                ) .
            "</td>

            <td>" .
                htmlspecialchars(
                    $bill['status'] ?? '-'
                ) .
            "</td>

            </tr>";
        }


        $html .= "</table>";


        /*
         * Complaints
         */

        $html .= "

        <div class='page-break'></div>

        <h2>Complaints — {$month}</h2>

        <table>

        <tr>

        <th>Resident</th>
        <th>Flat</th>
        <th>Title</th>
        <th>Category</th>
        <th>Status</th>

        </tr>
        ";


        foreach ($complaints as $complaint) {

            $html .= "

            <tr>

            <td>" .
                htmlspecialchars(
                    $complaint['resident_name'] ?? '-'
                ) .
            "</td>

            <td>" .
                htmlspecialchars(
                    $complaint['flat_number'] ?? '-'
                ) .
            "</td>

            <td>" .
                htmlspecialchars(
                    $complaint['title'] ?? '-'
                ) .
            "</td>

            <td>" .
                htmlspecialchars(
                    $complaint['category'] ?? '-'
                ) .
            "</td>

            <td>" .
                htmlspecialchars(
                    $complaint['status'] ?? '-'
                ) .
            "</td>

            </tr>";
        }


        $html .= "</table>";


        /*
         * Footer
         */

        $html .= "

        <br><br>

        <p style='text-align:center;color:#777;'>
            Generated by SocietyOS
        </p>

        </body>

        </html>
        ";


        return $html;
    }
}
