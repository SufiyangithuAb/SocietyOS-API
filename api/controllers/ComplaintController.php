<?php

require_once "../models/Complaint.php";
require_once "../helpers/response.php";
require_once "../helpers/FirebaseNotification.php";
require_once "../helpers/SubscriptionMiddleware.php";

class ComplaintController
{
    private $complaint;
    private $notification;
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
        
        $this->complaint =
            new Complaint($db);

        $this->notification =
            new FirebaseNotification($db);
    }

    public function create()
    {
        $user = $GLOBALS['auth_user'];

        $data = json_decode(
            file_get_contents("php://input"),
            true
        );

        if(empty($data['title']))
        {
            response(false, "Title is required");
        }

        $result = $this->complaint->create(
            $user['society_id'],
            $data['title'],
            $data['description'] ?? '',
            $data['category'] ?? 'OTHER'
        );

        if($result)
        {
            response(
                true,
                "Complaint created successfully"
            );
        }

        response(
            false,
            "Failed to create complaint"
        );
    }

    public function list()
    {
        $user = $GLOBALS['auth_user'];

        $complaints = $this->complaint->getAll(
            $user['society_id']
        );

        response(
            true,
            "Complaints fetched successfully",
            $complaints
        );
    }

    public function details()
    {
        $user = $GLOBALS['auth_user'];

        $id = $_GET['id'] ?? 0;

        $complaint = $this->complaint->getById(
            $id,
            $user['society_id']
        );

        if(!$complaint)
        {
            response(false, "Complaint not found");
        }

        response(
            true,
            "Complaint found",
            $complaint
        );
    }

    public function updateStatus()
    {
        $user =
            $GLOBALS['auth_user'];

        SubscriptionMiddleware::requireActive(
            $this->db,
            $user["society_id"]
        );

        $id =
            $_GET['id'] ?? 0;

        $data =
            json_decode(
                file_get_contents("php://input"),
                true
            );

        /*
        |--------------------------------------------------------------------------
        | Validate Status
        |--------------------------------------------------------------------------
        */

        if(empty($data['status']))
        {
            response(
                false,
                "Status required"
            );
        }

        $status =
            strtoupper(
                trim($data['status'])
            );

        /*
        |--------------------------------------------------------------------------
        | Get Complaint BEFORE Updating
        |--------------------------------------------------------------------------
        |
        | We need resident_id so we know exactly
        | which resident should receive the notification.
        |
        */

        $complaint =
            $this->complaint->getById(
                $id,
                $user['society_id']
            );

        if(!$complaint)
        {
            response(
                false,
                "Complaint not found"
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Update Status
        |--------------------------------------------------------------------------
        */

        $result =
            $this->complaint->updateStatus(

                $id,

                $user['society_id'],

                $status
            );

        if($result > 0)
        {
            /*
            |--------------------------------------------------------------------------
            | Notify Resident
            |--------------------------------------------------------------------------
            |
            | Only notify if this complaint belongs
            | to a specific resident.
            |
            | Admin-created society complaints have
            | resident_id = NULL, so they are skipped.
            |
            */

            if(
                !empty($complaint['resident_id'])
            )
            {
                try {

                    $title =
                        $complaint['title']
                        ?? "Complaint";

                    $notificationTitle =
                        "🔄 Complaint Updated";

                    /*
                    |--------------------------------------------------------------------------
                    | Friendly message depending on status
                    |--------------------------------------------------------------------------
                    */

                    switch($status)
                    {
                        case "RESOLVED":

                            $notificationBody =
                                "Your complaint \"" .
                                $title .
                                "\" has been resolved.";

                            break;

                        case "IN_PROGRESS":

                            $notificationBody =
                                "Your complaint \"" .
                                $title .
                                "\" is now in progress.";

                            break;

                        case "OPEN":

                            $notificationBody =
                                "Your complaint \"" .
                                $title .
                                "\" status has been changed to Open.";

                            break;

                        default:

                            $notificationBody =
                                "Your complaint \"" .
                                $title .
                                "\" status has been updated to " .
                                $status .
                                ".";
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | Send ONLY to complaint owner
                    |--------------------------------------------------------------------------
                    */

                    $this->notification
                        ->notifyResident(

                            $user['society_id'],

                            $complaint['resident_id'],

                            $notificationTitle,

                            $notificationBody,

                            [
                                "type" =>
                                    "COMPLAINT_STATUS",

                                "screen" =>
                                    "COMPLAINTS",

                                "complaint_id" =>
                                    (string) $id,

                                "status" =>
                                    (string) $status
                            ]
                        );

                }
                catch(Throwable $e)
                {
                    /*
                    | Status is already updated.
                    | Notification failure must NOT
                    | make the API report failure.
                    */

                    error_log(
                        "COMPLAINT STATUS FCM ERROR: " .
                        $e->getMessage()
                    );
                }
            }

            response(
                true,
                "Status updated successfully"
            );
        }

        response(
            false,
            "Complaint status unchanged"
        );
    }

    public function delete()
    {
        $user = $GLOBALS['auth_user'];

        $id = $_GET['id'] ?? 0;

        $result = $this->complaint->delete(
            $id,
            $user['society_id']
        );

        if($result > 0)
        {
            response(
                true,
                "Complaint deleted successfully"
            );
        }

        response(
            false,
            "Complaint not found"
        );
    }
}
