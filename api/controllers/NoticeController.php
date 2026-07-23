<?php

require_once "../models/Notice.php";
require_once "../helpers/response.php";
require_once "../helpers/FirebaseNotification.php";

class NoticeController
{
    private $notice;
    private $notification;

    public function __construct($db)
    {
        $this->notice =
            new Notice($db);

        $this->notification =
            new FirebaseNotification($db);
    }

    public function create()
    {
        $user =
            $GLOBALS['auth_user'];

        $data =
            json_decode(
                file_get_contents("php://input"),
                true
            );

        if (empty($data['title']))
        {
            response(
                false,
                "Title is required"
            );
        }

        $title =
            trim($data['title']);

        $description =
            trim(
                $data['description'] ?? ''
            );

        /*
        |--------------------------------------------------------------------------
        | Save notice first
        |--------------------------------------------------------------------------
        */

        $result =
            $this->notice->create(

                $user['society_id'],

                $user['id'],

                $title,

                $description
            );

        if (!$result)
        {
            response(
                false,
                "Failed to create notice"
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Notice saved successfully
        | Now notify residents.
        |--------------------------------------------------------------------------
        */

        try {

            $notificationBody =
                !empty($description)
                    ? $description
                    : "A new notice has been posted in your society.";

            /*
            | Keep notification text reasonably short.
            */

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
                ->notifyResidents(

                    $user['society_id'],

                    "📢 " . $title,

                    $notificationBody,

                    [
                        "type" =>
                            "NOTICE",

                        "screen" =>
                            "NOTICES"
                    ]
                );

        } catch (Throwable $e) {

            /*
            | VERY IMPORTANT:
            |
            | A notification failure must NOT undo or report
            | failure for an already-created notice.
            */

            error_log(
                "NOTICE FCM ERROR: " .
                $e->getMessage()
            );
        }

        response(
            true,
            "Notice created successfully"
        );
    }

    public function list()
    {
        $user = $GLOBALS['auth_user'];

        $notices = $this->notice->getAll(
            $user['society_id']
        );

        response(
            true,
            "Notices fetched successfully",
            $notices
        );
    }

    public function details()
    {
        $user = $GLOBALS['auth_user'];

        $id = $_GET['id'] ?? 0;

        $notice = $this->notice->getById(
            $id,
            $user['society_id']
        );

        if(!$notice)
        {
            response(false,"Notice not found");
        }

        response(
            true,
            "Notice found",
            $notice
        );
    }

    public function delete()
    {
        $user = $GLOBALS['auth_user'];

        $id = $_GET['id'] ?? 0;

        $result = $this->notice->delete(
            $id,
            $user['society_id']
        );

        if($result > 0)
        {
            response(
                true,
                "Notice deleted successfully"
            );
        }

        response(
            false,
            "Notice not found"
        );
    }
}
