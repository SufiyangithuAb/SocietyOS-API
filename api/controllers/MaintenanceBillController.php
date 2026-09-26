<?php

require_once "../models/MaintenanceBill.php";
require_once "../helpers/response.php";
require_once "../helpers/FirebaseNotification.php";
require_once "../helpers/SubscriptionMiddleware.php";

class MaintenanceBillController
{
    private $bill;
    private $notification;
    private $db;

    public function __construct($db)
    {
        $this->db = $db;

        $this->bill =
            new MaintenanceBill($db);

        $this->notification =
            new FirebaseNotification($db);
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE MAINTENANCE BILL
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        $user =
            $GLOBALS['auth_user'];

        /*
        |--------------------------------------------------------------------------
        | Subscription check
        |--------------------------------------------------------------------------
        */

        SubscriptionMiddleware::requireActive(
            $this->db,
            $user["society_id"]
        );

        /*
        |--------------------------------------------------------------------------
        | Read request
        |--------------------------------------------------------------------------
        */

        $data =
            json_decode(
                file_get_contents("php://input"),
                true
            );

        /*
        |--------------------------------------------------------------------------
        | Validate required fields
        |--------------------------------------------------------------------------
        */

        if (
            empty($data['resident_id']) ||
            empty($data['bill_month']) ||
            !isset($data['amount'])
        ) {
            response(
                false,
                "Required fields missing"
            );

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Resident ID validation
        |--------------------------------------------------------------------------
        */

        $residentId =
            $data['resident_id'];

        if (
            !is_numeric($residentId) ||
            (int)$residentId <= 0
        ) {
            response(
                false,
                "Invalid resident ID"
            );

            return;
        }

        $residentId =
            (int)$residentId;

        /*
        |--------------------------------------------------------------------------
        | Bill month
        |
        | New format:
        | YYYY-MM
        |
        | Example:
        | 2026-09
        |--------------------------------------------------------------------------
        */

        $billMonth =
            trim($data['bill_month']);

        if (
            !preg_match(
                '/^\d{4}-(0[1-9]|1[0-2])$/',
                $billMonth
            )
        ) {
            response(
                false,
                "Invalid bill month. Use YYYY-MM format, for example 2026-09."
            );

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Amount validation
        |--------------------------------------------------------------------------
        */

        $amount =
            $data['amount'];

        if (
            !is_numeric($amount) ||
            (float)$amount <= 0
        ) {
            response(
                false,
                "Invalid amount"
            );

            return;
        }

        $amount =
            (float)$amount;

        /*
        |--------------------------------------------------------------------------
        | Create bill
        |--------------------------------------------------------------------------
        */

        $result =
            $this->bill->create(

                $user['society_id'],

                $residentId,

                $billMonth,

                $amount
            );

        if (!$result) {

            response(
                false,
                "Failed to create bill"
            );

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Bill created successfully
        |
        | Send notification ONLY to that resident
        |--------------------------------------------------------------------------
        */

        try {

            $notificationTitle =
                "💳 New Maintenance Bill";

            $notificationBody =
                "A maintenance bill of ₹" .
                number_format($amount, 2) .
                " has been generated for " .
                $billMonth .
                ".";

            $this->notification
                ->notifyResident(

                    $user['society_id'],

                    $residentId,

                    $notificationTitle,

                    $notificationBody,

                    [
                        "type" =>
                            "BILL",

                        "screen" =>
                            "BILLS",

                        "resident_id" =>
                            (string)$residentId,

                        "bill_month" =>
                            (string)$billMonth
                    ]
                );

        } catch (Throwable $e) {

            /*
            |--------------------------------------------------------------------------
            | FCM failure must NOT cancel the bill
            |--------------------------------------------------------------------------
            */

            error_log(
                "BILL FCM ERROR: " .
                $e->getMessage()
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Return success
        |--------------------------------------------------------------------------
        */

        response(
            true,
            "Bill created successfully"
        );
    }

    /*
    |--------------------------------------------------------------------------
    | LIST BILLS
    |--------------------------------------------------------------------------
    */

    public function list()
    {
        $user =
            $GLOBALS['auth_user'];

        $bills =
            $this->bill->getAll(
                $user['society_id']
            );

        response(
            true,
            "Bills fetched successfully",
            $bills
        );
    }

    /*
    |--------------------------------------------------------------------------
    | MARK BILL PAID
    |--------------------------------------------------------------------------
    */

    public function markPaid()
    {
        $user =
            $GLOBALS['auth_user'];

        $id =
            $_GET['id'] ?? 0;

        /*
        |--------------------------------------------------------------------------
        | Validate bill ID
        |--------------------------------------------------------------------------
        */

        if (
            empty($id) ||
            !is_numeric($id) ||
            (int)$id <= 0
        ) {
            response(
                false,
                "Invalid bill ID"
            );

            return;
        }

        $id =
            (int)$id;

        /*
        |--------------------------------------------------------------------------
        | Mark bill paid
        |--------------------------------------------------------------------------
        */

        $result =
            $this->bill->markPaid(
                $id,
                $user['society_id']
            );

        if ($result > 0) {

            response(
                true,
                "Bill marked as paid"
            );

            return;
        }

        response(
            false,
            "Bill not found or already paid"
        );
    }
}
