<?php

require_once __DIR__ . "/../config/database.php";
require_once __DIR__ . "/../models/Settings.php";

class SettingsController
{
    private Settings $settings;

    public function __construct()
    {
        $db = (new Database())->connect();
        $this->settings = new Settings($db);
    }

    public function get()
    {
        return $this->settings->get();
    }

    public function save()
    {
        if($_SERVER['REQUEST_METHOD']=="POST")
        {
            $this->settings->update($_POST);

            header("Location:index.php?success=1");
            exit;
        }
    }
}