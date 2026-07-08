<?php

require_once "../models/ResidentApp.php";
require_once "../helpers/response.php";

class ResidentAppController
{
    private $resident;

    public function __construct($db)
    {
        $this->resident = new ResidentApp($db);
    }

    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */

    public function dashboard()
    {
        $user = $GLOBALS['auth_user'];

        $data = $this->resident->getDashboard(
            $user['id']
        );

        response(
            true,
            "Resident Dashboard Loaded",
            $data
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Resident Profile
    |--------------------------------------------------------------------------
    */

    public function profile()
    {
        $user = $GLOBALS['auth_user'];

        $data = $this->resident->getProfile(
            $user['id']
        );

        response(
            true,
            "Resident Profile Loaded",
            $data
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Bills
    |--------------------------------------------------------------------------
    */

    public function bills()
    {
        $user = $GLOBALS['auth_user'];

        $data = $this->resident->getBills(
            $user['id']
        );

        response(
            true,
            "Bills Loaded",
            $data
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Notices
    |--------------------------------------------------------------------------
    */

    public function notices()
    {
        $user = $GLOBALS['auth_user'];

        $data = $this->resident->getNotices(
            $user['id']
        );

        response(
            true,
            "Notices Loaded",
            $data
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Complaints
    |--------------------------------------------------------------------------
    */

    public function complaints()
    {
        $user = $GLOBALS['auth_user'];

        $data = $this->resident->getComplaints(
            $user['id']
        );

        response(
            true,
            "Complaints Loaded",
            $data
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Create Complaint
    |--------------------------------------------------------------------------
    */

    public function createComplaint()
    {
        $user = $GLOBALS['auth_user'];

        $data = json_decode(
            file_get_contents("php://input"),
            true
        );

        if(empty($data['title']))
        {
            response(false,"Complaint title required");
        }

        $result = $this->resident->createComplaint(

            $user['id'],

            $data['title'],

            $data['description'] ?? '',

            $data['category'] ?? 'OTHER'

        );

        if($result)
        {
            response(
                true,
                "Complaint Submitted Successfully"
            );
        }

        response(
            false,
            "Unable to Submit Complaint"
        );
    }
}