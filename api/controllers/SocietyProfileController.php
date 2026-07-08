<?php

require_once "../models/SocietyProfile.php";
require_once "../helpers/response.php";

class SocietyProfileController
{
    private $profile;

    public function __construct($db)
    {
        $this->profile =
                new SocietyProfile($db);
    }

    public function get()
    {
        $user =
                $GLOBALS['auth_user'];

        $data =
                $this->profile->get(
                        $user['society_id']
                );

        response(
                true,
                "Profile Loaded",
                $data
        );
    }

    public function update()
    {
        $user =
                $GLOBALS['auth_user'];

        $data =
                json_decode(
                        file_get_contents("php://input"),
                        true
                );

        if(
                $this->profile->update(
                        $user['society_id'],
                        $data
                )
        )
        {
            response(
                    true,
                    "Profile Updated"
            );
        }

        response(
                false,
                "Update Failed"
        );
    }
}