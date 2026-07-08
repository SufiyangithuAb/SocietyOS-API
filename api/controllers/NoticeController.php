<?php

require_once "../models/Notice.php";
require_once "../helpers/response.php";

class NoticeController
{
    private $notice;

    public function __construct($db)
    {
        $this->notice = new Notice($db);
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
            response(false,"Title is required");
        }

        $result = $this->notice->create(
            $user['society_id'],
            $user['id'],
            $data['title'],
            $data['description'] ?? ''
        );

        if($result)
        {
            response(
                true,
                "Notice created successfully"
            );
        }

        response(
            false,
            "Failed to create notice"
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
