<?php

require_once "../models/User.php";
require_once "../models/Resident.php";
require_once "../helpers/response.php";

class ResidentController
{
    private $resident;
    private $user;
    private $db;

    public function __construct($db)
    {
        $this->db = $db;

        $this->resident = new Resident($db);

        $this->user = new User($db);
    }

    public function create()
    {
        $admin = $GLOBALS['auth_user'];

        $data = json_decode(
            file_get_contents("php://input"),
            true
        );

        if (
            empty($data['name']) ||
            empty($data['email']) ||
            empty($data['flat_number'])
        ) {
            response(false, "Required fields missing");
        }

        try {

            $this->db->beginTransaction();

            // Prevent duplicate login accounts
            if ($this->user->findByEmail($data['email'])) {

                $this->db->rollBack();

                response(false, "Email already exists");

            }

            // Temporary password
            $temporaryPassword = password_hash(
                "Welcome@123",
                PASSWORD_DEFAULT
            );

            // Create user account
            $userId = $this->user->createResident(

                $admin['society_id'],

                $data['name'],

                $data['email'],

                $data['phone'] ?? '',

                $temporaryPassword

            );

            // Create resident
            $resident = $this->resident->create(

                $admin['society_id'],

                $userId,

                $data['name'],

                $data['email'],

                $data['phone'] ?? '',

                $data['flat_number'],

                $data['tower'] ?? '',

                $data['resident_type'] ?? 'OWNER'

            );

            if (!$resident) {

                throw new Exception(
                    "Unable to create resident."
                );

            }

            $this->db->commit();

            response(
                true,
                "Resident created successfully. Temporary password: Welcome@123"
            );

        }
        catch (Exception $e) {

            $this->db->rollBack();

            response(
                false,
                $e->getMessage()
            );

        }
    }

    public function list()
    {
        $user = $GLOBALS['auth_user'];

        $residents = $this->resident->getAll(
            $user['society_id']
        );

        response(
            true,
            "Residents fetched successfully",
            $residents
        );
    }

    public function details()
    {
        $user = $GLOBALS['auth_user'];

        $id = $_GET['id'] ?? 0;

        $resident = $this->resident->getById(
            $id,
            $user['society_id']
        );

        if (!$resident) {
            response(false, "Resident not found");
        }

        response(
            true,
            "Resident found",
            $resident
        );
    }

    public function delete()
    {
        $user = $GLOBALS['auth_user'];

        $id = $_GET['id'] ?? 0;

        $result = $this->resident->delete(
            $id,
            $user['society_id']
        );

        if ($result) {
            response(
                true,
                "Resident deleted successfully"
            );
        }

        response(
            false,
            "Failed to delete resident"
        );
    }
}
