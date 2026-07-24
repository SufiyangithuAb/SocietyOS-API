<?php

require_once "../models/ResidentApp.php";
require_once "../helpers/response.php";
require_once "../helpers/FirebaseNotification.php";

class ResidentAppController
{
    private $resident;
    private $notification;

    public function __construct($db)
    {
        $this->resident =
            new ResidentApp($db);

        $this->notification =
            new FirebaseNotification($db);
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

    public function createComplaint()
    {
        $user =
            $GLOBALS['auth_user'];

        $data =
            json_decode(
                file_get_contents("php://input"),
                true
            );

        /*
        |--------------------------------------------------------------------------
        | Validate
        |--------------------------------------------------------------------------
        */

        if(empty($data['title']))
        {
            response(
                false,
                "Complaint title required"
            );
        }

        $title =
            trim($data['title']);

        $description =
            trim(
                $data['description'] ?? ''
            );

        $category =
            trim(
                $data['category'] ?? 'OTHER'
            );

        /*
        |--------------------------------------------------------------------------
        | Create complaint first
        |--------------------------------------------------------------------------
        */

        $result =
            $this->resident->createComplaint(

                $user['id'],

                $title,

                $description,

                $category

            );

        if (!$result)
        {
            response(
                false,
                "Unable to Submit Complaint"
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Complaint created successfully
        | Notify ADMIN(s) of the same society
        |--------------------------------------------------------------------------
        */

        try {

            $notificationBody =
                !empty($description)
                    ? $description
                    : "A resident has submitted a new complaint.";

            if (
                strlen($notificationBody) > 150
            ) {

                $notificationBody =
                    substr(
                        $notificationBody,
                        0,
                        147
                    ) . "...";
            }

            $this->notification
                ->notifyAdmins(

                    $user['society_id'],

                    "⚠️ New Complaint: " . $title,

                    $notificationBody,

                    [
                        "type" =>
                            "COMPLAINT",

                        "screen" =>
                            "COMPLAINTS",

                        "category" =>
                            (string) $category
                    ]
                );

        } catch (Throwable $e) {

            /*
            | Complaint is already saved.
            | FCM failure must not make complaint submission fail.
            */

            error_log(
                "COMPLAINT FCM ERROR: " .
                $e->getMessage()
            );
        }

        response(
            true,
            "Complaint Submitted Successfully"
        );
    }
}
