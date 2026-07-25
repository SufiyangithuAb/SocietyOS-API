<?php

require_once "../models/Payment.php";
require_once "../models/Plan.php";
require_once "../helpers/RazorpayHelper.php";
require_once "../helpers/response.php";
require_once "../models/Subscription.php";
require_once "../helpers/FirebaseNotification.php";

class PaymentController
{
    private $payment;
    private $plan;
    private $razorpay;
    private $subscription;
    private $notification;

    public function __construct($db)
    {
        $this->payment = new Payment($db);
        $this->plan = new Plan($db);
        $this->subscription = new Subscription($db);
        $this->notification = new FirebaseNotification($db);
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

    public function verify()
    {
        $user = $GLOBALS["auth_user"];

        $data = json_decode(
            file_get_contents("php://input"),
            true
        );

        if (
            empty($data["razorpay_order_id"]) ||
            empty($data["razorpay_payment_id"]) ||
            empty($data["razorpay_signature"])
        ) {
            response(false, "Missing payment details");
        }

        try {

            $this->razorpay->verifySignature([
                "razorpay_order_id"   => $data["razorpay_order_id"],
                "razorpay_payment_id" => $data["razorpay_payment_id"],
                "razorpay_signature"  => $data["razorpay_signature"]
            ]);

            $payment = $this->payment->getByOrderId(
                $data["razorpay_order_id"]
            );

            if (!$payment) {
                response(false, "Payment not found");
            }

            $plan = $this->plan->getByName(
                $payment["plan_name"]
            );

            if (!$plan) {
                response(false, "Plan not found");
            }

            $this->payment->markSuccess(
                $data["razorpay_order_id"],
                $data["razorpay_payment_id"],
                $data["razorpay_signature"]
            );

            $this->subscription->activatePremium(
                $payment["society_id"],
                $payment["plan_name"],
                $payment["amount"],
                $plan["duration_days"]
            );

            try {

                $this->notification->notifySocietyAdmins(

                    $payment["society_id"],

                    "🎉 Premium Activated",

                    "Your " .
                    $payment["plan_name"] .
                    " subscription has been activated successfully.",

                    [
                        "type" => "PREMIUM",
                        "screen" => "SUBSCRIPTION"
                    ]
                );

            } catch (Throwable $e) {

                error_log(
                    "PREMIUM FCM ERROR: " .
                    $e->getMessage()
                );
            }

            response(
                true,
                "Payment verified successfully"
            );

        } catch (Throwable $e) {

            $this->payment->markFailed(
                $data["razorpay_order_id"]
            );

            response(
                false,
                "Payment verification failed"
            );
        }
    }
}