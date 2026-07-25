<?php

require_once "../models/Plan.php";
require_once "../helpers/response.php";

class PlanController
{
    private $plan;

    public function __construct($db)
    {
        $this->plan = new Plan($db);
    }

    /*
    |--------------------------------------------------------------------------
    | GET ALL PLANS
    |--------------------------------------------------------------------------
    */

    public function list()
    {
        $plans = $this->plan->getAll();

        response(
            true,
            "Plans fetched successfully",
            $plans
        );
    }

    /*
    |--------------------------------------------------------------------------
    | GET SINGLE PLAN
    |--------------------------------------------------------------------------
    */

    public function details()
    {
        $name = $_GET['name'] ?? "";

        if (empty($name)) {

            response(
                false,
                "Plan name required"
            );
        }

        $plan = $this->plan->getByName($name);

        if (!$plan) {

            response(
                false,
                "Plan not found"
            );
        }

        response(
            true,
            "Plan fetched successfully",
            $plan
        );
    }
}