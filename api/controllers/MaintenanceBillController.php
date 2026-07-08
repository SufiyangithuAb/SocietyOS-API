<?php

require_once "../models/MaintenanceBill.php";
require_once "../helpers/response.php";

class MaintenanceBillController
{
    private $bill;

    public function __construct($db)
    {
        $this->bill = new MaintenanceBill($db);
    }

    public function create()
    {
        $user = $GLOBALS['auth_user'];

        $data = json_decode(
            file_get_contents("php://input"),
            true
        );

        if(
            empty($data['resident_id']) ||
            empty($data['bill_month']) ||
            empty($data['amount'])
        )
        {
            response(false, "Required fields missing");
        }

        $result = $this->bill->create(
            $user['society_id'],
            $data['resident_id'],
            $data['bill_month'],
            $data['amount']
        );

        if($result)
        {
            response(
                true,
                "Bill created successfully"
            );
        }

        response(
            false,
            "Failed to create bill"
        );
    }

    public function list()
    {
        $user = $GLOBALS['auth_user'];

        $bills = $this->bill->getAll(
            $user['society_id']
        );

        response(
            true,
            "Bills fetched successfully",
            $bills
        );
    }

    public function markPaid()
    {
        $user = $GLOBALS['auth_user'];

        $id = $_GET['id'] ?? 0;

        $result = $this->bill->markPaid(
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