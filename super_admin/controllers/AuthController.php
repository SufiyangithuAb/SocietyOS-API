<?php

require_once "../config/config.php";
require_once "../config/database.php";
require_once "../models/Admin.php";

class AuthController
{
    private PDO $db;
    private Admin $admin;

    public function __construct()
    {
        $this->db = (new Database())->connect();
        $this->admin = new Admin($this->db);
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: ../login.php");
            exit;
        }

        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');

        if (empty($email) || empty($password)) {
            setFlash("danger", "Please enter email and password.");
            header("Location: ../login.php");
            exit;
        }

        $user = $this->admin->findByEmail($email);

        if (!$user) {
            setFlash("danger", "Invalid email or password.");
            header("Location: ../login.php");
            exit;
        }

        if ($user['status'] !== 'active') {
            setFlash("danger", "Your account has been disabled.");
            header("Location: ../login.php");
            exit;
        }

        if (!password_verify($password, $user['password'])) {
            setFlash("danger", "Invalid email or password.");
            header("Location: ../login.php");
            exit;
        }

        $this->admin->updateLastLogin($user['id']);

        session_regenerate_id(true);

        $_SESSION['super_admin'] = [
            'id'    => $user['id'],
            'name'  => $user['name'],
            'email' => $user['email']
        ];

        setFlash("success", "Welcome back, {$user['name']}!");

        header("Location: ../index.php");
        exit;
    }

    public function logout()
    {
        $_SESSION = [];

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();

            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }

        session_destroy();

        header("Location: ../login.php");
        exit;
    }
}

$auth = new AuthController();

$action = $_GET['action'] ?? 'login';

switch ($action) {

    case 'logout':
        $auth->logout();
        break;

    default:
        $auth->login();
        break;
}