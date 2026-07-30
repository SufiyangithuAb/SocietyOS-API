<?php

require_once "../models/Admin.php";

class AuthController
{
    private $admin;

    public function __construct($db)
    {
        $this->admin = new Admin($db);
    }

    public function login()
    {

        if ($_SERVER["REQUEST_METHOD"] != "POST")
            return;

        $email = trim($_POST["email"]);
        $password = $_POST["password"];

        $user = $this->admin->login($email);

        if (!$user) {

            $_SESSION["error"] = "Invalid credentials";

            header("Location: ../index.php");
            exit;
        }

        if (
            !password_verify(
                $password,
                $user["password"]
            )
        ) {

            $_SESSION["error"] = "Invalid credentials";

            header("Location: ../index.php");
            exit;
        }

        if ($user["status"] != "ACTIVE") {

            $_SESSION["error"] = "Account blocked";

            header("Location: ../index.php");
            exit;
        }

        $_SESSION["super_admin"] = $user;

        header("Location: views/dashboard/index.php");
        exit;
    }
}