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

        SubscriptionMiddleware::requireActive(
            $this->db,
            $user["society_id"]
        );

        $data =
            json_decode(
                file_get_contents("php://input"),
                true
            );

        /*
        |--------------------------------------------------------------------------
        | Validate fields
        |--------------------------------------------------------------------------
        */

        if(
            empty($data['resident_id']) ||
            empty($data['bill_month']) ||
            empty($data['amount'])
        )
        {
            response(
                false,
                "Required fields missing"
            );
        }

        $residentId =
            $data['resident_id'];

        $billMonth =
            trim($data['bill_month']);

        $amount =
            $data['amount'];

        /*
        |--------------------------------------------------------------------------
        | Create bill first
        |--------------------------------------------------------------------------
        */

        $result =
            $this->bill->create(

                $user['society_id'],

                $residentId,

                $billMonth,

                $amount
            );

        if (!$result)
        {
            response(
                false,
                "Failed to create bill"
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Bill created successfully
        | Send notification ONLY to that resident
        |--------------------------------------------------------------------------
        */

        try {

            $notificationTitle =
                "💳 New Maintenance Bill";

            $notificationBody =
                "A maintenance bill of ₹" .
                $amount .
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
                            (string) $residentId,

                        "bill_month" =>
                            (string) $billMonth
                    ]
                );

        } catch (Throwable $e) {

            /*
            |--------------------------------------------------------------------------
            | Bill must remain successfully created even if FCM fails
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

        $result =
            $this->bill->markPaid(
                $id,
                $user['society_id']
            );

        if($result > 0)
        {
            response(
                true,
                "Bill marked as paid"
            );
        }

        response(
            false,
            "Bill not found"
        );
    }
}
