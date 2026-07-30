<?php

class AuthMiddleware
{
    public static function check()
    {
        if (!isset($_SESSION['super_admin'])) {

            header("Location: login.php");
            exit;

        }
    }
}