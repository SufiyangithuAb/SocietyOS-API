<?php

require_once "../models/ResidentSearch.php";
require_once "../helpers/response.php";

class ResidentSearchController
{
    private $resident;

    public function __construct($db)
    {
        $this->resident =
                new ResidentSearch($db);
    }

    public function search()
    {
        $user =
                $GLOBALS['auth_user'];

        $keyword =
                $_GET['keyword'] ?? '';

        $data =
                $this->resident->search(

                        $user['society_id'],

                        $keyword

                );

        response(

                true,

                "Residents Found",

                $data

        );
    }
}