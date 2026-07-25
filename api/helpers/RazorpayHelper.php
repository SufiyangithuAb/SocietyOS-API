<?php

require_once __DIR__ . "/../../vendor/autoload.php";

use Razorpay\Api\Api;

class RazorpayHelper
{
    private $api;

    public function __construct()
    {
        $keyId = getenv("RAZORPAY_KEY_ID");
        $keySecret = getenv("RAZORPAY_KEY_SECRET");

        if (!$keyId || !$keySecret) {
            throw new Exception("Razorpay credentials are missing.");
        }

        $this->api = new Api($keyId, $keySecret);
    }

    public function createOrder($amount, $receipt)
    {
        return $this->api->order->create([
            "receipt" => $receipt,
            "amount" => $amount,
            "currency" => "INR",
            "payment_capture" => 1
        ]);
    }

    public function verifySignature($attributes)
    {
        $this->api->utility->verifyPaymentSignature($attributes);
        return true;
    }
}