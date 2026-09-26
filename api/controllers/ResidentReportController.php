private function buildReportHtml($report)
{
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

            @page {
                margin: 30px;
            }

            body {
                font-family: DejaVu Sans, sans-serif;
                color: #222;
                font-size: 11px;
            }

            h1 {
                color: #21755A;
                margin-bottom: 5px;
            }

            h2 {
                color: #21755A;
                border-bottom: 1px solid #21755A;
                padding-bottom: 5px;
                margin-top: 25px;
            }

            .subtitle {
                color: #666;
                margin-bottom: 20px;
            }

            .summary-table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 15px;
            }

            .summary-table td {
                border: 1px solid #ddd;
                padding: 8px;
            }

            .summary-title {
                font-weight: bold;
                background: #f2f5f4;
            }

            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 10px;
            }

            th {
                background: #21755A;
                color: white;
                padding: 7px;
                border: 1px solid #ddd;
            }

            td {
                padding: 7px;
                border: 1px solid #ddd;
            }

            tr {
                page-break-inside: avoid;
            }

            .success {
                color: #16834A;
                font-weight: bold;
            }

            .warning {
                color: #C47A00;
                font-weight: bold;
            }

            .danger {
                color: #C62828;
                font-weight: bold;
            }

            .footer {
                margin-top: 30px;
                color: #777;
                font-size: 9px;
                text-align: center;
            }

        </style>

    </head>

    <body>

        <h1>SocietyOS</h1>

        <div class="subtitle">
            Monthly Society Management Report
            <br>
            Month: ' .
            htmlspecialchars($report['report_month']) .
            '
            <br>
            Generated: ' .
            htmlspecialchars($report['generated_at']) .
            '
        </div>

        <h2>Resident Overview</h2>

        <table class="summary-table">

            <tr>
                <td class="summary-title">
                    Total Residents
                </td>

                <td>
                    ' .
                    (int)$residents['total_residents'] .
                    '
                </td>

                <td class="summary-title">
                    Owners
                </td>

                <td>
                    ' .
                    (int)$residents['owners'] .
                    '
                </td>
            </tr>

            <tr>

                <td class="summary-title">
                    Tenants
                </td>

                <td>
                    ' .
                    (int)$residents['tenants'] .
                    '
                </td>

                <td class="summary-title">
                    Towers
                </td>

                <td>
                    ' .
                    (int)$residents['towers'] .
                    '
                </td>

            </tr>

        </table>


        <h2>Billing Summary</h2>

        <table class="summary-table">

            <tr>

                <td class="summary-title">
                    Total Bills
                </td>

                <td>
                    ' .
                    (int)$billing['total_bills'] .
                    '
                </td>

                <td class="summary-title">
                    Paid Bills
                </td>

                <td>
                    ' .
                    (int)$billing['paid_bills'] .
                    '
                </td>

            </tr>

            <tr>

                <td class="summary-title">
                    Pending Bills
                </td>

                <td>
                    ' .
                    (int)$billing['pending_bills'] .
                    '
                </td>

                <td class="summary-title">
                    Overdue Bills
                </td>

                <td>
                    ' .
                    (int)$billing['overdue_bills'] .
                    '
                </td>

            </tr>

            <tr>

                <td class="summary-title">
                    Total Billed
                </td>

                <td>
                    ₹' .
                    number_format(
                        (float)$billing['total_billed'],
                        2
                    ) .
                    '
                </td>

                <td class="summary-title">
                    Paid Amount
                </td>

                <td>
                    ₹' .
                    number_format(
                        (float)$billing['paid_amount'],
                        2
                    ) .
                    '
                </td>

            </tr>

            <tr>

                <td class="summary-title">
                    Outstanding
                </td>

                <td>
                    ₹' .
                    number_format(
                        (float)$billing['outstanding_amount'],
                        2
                    ) .
                    '
                </td>

                <td class="summary-title">
                    Collection
                </td>

                <td>
                    ' .
                    number_format(
                        (float)$billing['collection_percentage'],
                        2
                    ) .
                    '%
                </td>

            </tr>

        </table>


        <h2>Resident Bills</h2>

        <table>

            <tr>

                <th>Resident</th>
                <th>Flat</th>
                <th>Tower</th>
                <th>Month</th>
                <th>Amount</th>
                <th>Status</th>

            </tr>
    ';

    foreach (
        $report['resident_bills']
        as $bill
    ) {

        $html .= '

            <tr>

                <td>' .
                    htmlspecialchars(
                        $bill['name'] ?? '-'
                    ) .
                '</td>

                <td>' .
                    htmlspecialchars(
                        $bill['flat_number'] ?? '-'
                    ) .
                '</td>

                <td>' .
                    htmlspecialchars(
                        $bill['tower'] ?? '-'
                    ) .
                '</td>

                <td>' .
                    htmlspecialchars(
                        $bill['bill_month'] ?? '-'
                    ) .
                '</td>

                <td>
                    ₹' .
                    number_format(
                        (float)$bill['amount'],
                        2
                    ) .
                '</td>

                <td>' .
                    htmlspecialchars(
                        $bill['status'] ?? '-'
                    ) .
                '</td>

            </tr>

        ';
    }

    $html .= '

        </table>


        <h2>Tower Statistics</h2>

        <table>

            <tr>

                <th>Tower</th>
                <th>Residents</th>
                <th>Bills</th>
                <th>Billed</th>
                <th>Paid</th>
                <th>Outstanding</th>

            </tr>

    ';

    foreach (
        $report['tower_statistics']
        as $tower
    ) {

        $html .= '

            <tr>

                <td>' .
                    htmlspecialchars(
                        $tower['tower'] ?? '-'
                    ) .
                '</td>

                <td>' .
                    (int)$tower['residents'] .
                '</td>

                <td>' .
                    (int)$tower['total_bills'] .
                '</td>

                <td>
                    ₹' .
                    number_format(
                        (float)$tower['total_billed'],
                        2
                    ) .
                '</td>

                <td>
                    ₹' .
                    number_format(
                        (float)$tower['paid_amount'],
                        2
                    ) .
                '</td>

                <td>
                    ₹' .
                    number_format(
                        (float)$tower['outstanding_amount'],
                        2
                    ) .
                '</td>

            </tr>

        ';
    }

    $html .= '

        </table>


        <h2>Complaint Summary</h2>

        <table class="summary-table">

            <tr>

                <td class="summary-title">
                    Total
                </td>

                <td>
                    ' .
                    (int)$complaints['total_complaints'] .
                '</td>

                <td class="summary-title">
                    Open
                </td>

                <td>
                    ' .
                    (int)$complaints['open_complaints'] .
                '</td>

            </tr>

            <tr>

                <td class="summary-title">
                    Assigned
                </td>

                <td>
                    ' .
                    (int)$complaints['assigned_complaints'] .
                '</td>

                <td class="summary-title">
                    In Progress
                </td>

                <td>
                    ' .
                    (int)$complaints['in_progress_complaints'] .
                '</td>

            </tr>

            <tr>

                <td class="summary-title">
                    Resolved
                </td>

                <td>
                    ' .
                    (int)$complaints['resolved_complaints'] .
                '</td>

                <td class="summary-title">
                    Resolution Rate
                </td>

                <td>
                    ' .
                    number_format(
                        (float)$complaints['resolution_percentage'],
                        2
                    ) .
                    '%
                </td>

            </tr>

        </table>


        <h2>Complaint Details</h2>

        <table>

            <tr>

                <th>ID</th>
                <th>Title</th>
                <th>Category</th>
                <th>Status</th>
                <th>Created</th>

            </tr>

    ';

    foreach (
        $report['complaint_list']
        as $complaint
    ) {

        $html .= '

            <tr>

                <td>' .
                    (int)$complaint['id'] .
                '</td>

                <td>' .
                    htmlspecialchars(
                        $complaint['title'] ?? '-'
                    ) .
                '</td>

                <td>' .
                    htmlspecialchars(
                        $complaint['category'] ?? '-'
                    ) .
                '</td>

                <td>' .
                    htmlspecialchars(
                        $complaint['status'] ?? '-'
                    ) .
                '</td>

                <td>' .
                    htmlspecialchars(
                        $complaint['created_at'] ?? '-'
                    ) .
                '</td>

            </tr>

        ';
    }

    $html .= '

        </table>


        <div class="footer">

            Generated by SocietyOS

        </div>

    </body>

    </html>

    ';

    return $html;
}
