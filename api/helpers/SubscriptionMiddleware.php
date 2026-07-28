<?php

require_once __DIR__ . "/../models/Subscription.php";
require_once __DIR__ . "/response.php";

class SubscriptionMiddleware
{
    public static function requireActive($db, $societyId)
    {
        $subscription = new Subscription($db);

        if (!$subscription->isActive($societyId)) {

            response(
                false,
                "Your subscription has expired. Please renew to continue."
            );

        }
    }
}