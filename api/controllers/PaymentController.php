<?php

require_once "../models/Payment.php";
require_once "../models/Plan.php";
require_once "../helpers/RazorpayHelper.php";
require_once "../helpers/response.php";

class PaymentController
{
    private $payment;
    private $plan;
    private $razorpay;

    public function __construct($db)
    {
        $this->payment = new Payment($db);
        $this->plan = new Plan($db);
        $this->razorpay = new RazorpayHelper();
    }

    /*
    |--------------------------------------------------------------------------
    | Create Razorpay Order
    |--------------------------------------------------------------------------
    */

    public function createOrder()
    {
        $user = $GLOBALS["auth_user"];

        $data = json_decode(
            file_get_contents("php://input"),
            true
        );

        if (empty($data["plan"])) {

            response(
                false,
                "Plan is required"
            );
        }

        $plan = $this->plan->getByName(
            $data["plan"]
        );

        if (!$plan) {

            response(
                false,
                "Invalid plan"
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Razorpay amount is in paise
        |--------------------------------------------------------------------------
        */

        $amount = $plan["amount"] * 100;

        $receipt =
            "SOC_" .
            $user["society_id"] .
            "_" .
            time();

        try {

            $order =
                $this->razorpay->createOrder(
                    $amount,
                    $receipt
                );

            $this->payment->create([

                "society_id" =>
                    $user["society_id"],

                "user_id" =>
                    $user["id"],

                "plan_name" =>
                    $plan["name"],

                "amount" =>
                    $plan["amount"],

                "currency" =>
                    "INR",

                "razorpay_order_id" =>
                    $order["id"]

            ]);

            response(
                true,
                "Order created successfully",
                [
                    "key" => getenv("RAZORPAY_KEY_ID"),

                    "order_id" => $order["id"],

                    "amount" => $amount,

                    "currency" => "INR",

                    "plan" => $plan
                ]
            );

        }
        catch (Throwable $e) {

            response(
                false,
                $e->getMessage()
            );
        }
    }
}