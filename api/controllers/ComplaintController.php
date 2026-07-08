<?php

require_once "../models/Complaint.php";
require_once "../helpers/response.php";

class ComplaintController
{
    private $complaint;

    public function __construct($db)
    {
        $this->complaint = new Complaint($db);
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
        $user = $GLOBALS['auth_user'];

        $id = $_GET['id'] ?? 0;

        $data = json_decode(
            file_get_contents("php://input"),
            true
        );

        if(empty($data['status']))
        {
            response(false, "Status required");
        }

        $result = $this->complaint->updateStatus(
            $id,
            $user['society_id'],
            $data['status']
        );

        if($result > 0)
        {
            response(
                true,
                "Status updated successfully"
            );
        }

        response(
            false,
            "Complaint not found"
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