<?php

require_once "../models/User.php";
require_once "../helpers/response.php";
require_once "../models/Subscription.php";

class AuthController
{
    private $conn;
    private $user;
    private $subscription;

    public function __construct($db)
    {
        $this->conn = $db;

        $this->user = new User($db);

        $this->subscription = new Subscription($db);
    }

    public function registerSociety()
    {
        $data = json_decode(
            file_get_contents("php://input"),
            true
        );

        if(
            empty($data['society_name']) ||
            empty($data['admin_name']) ||
            empty($data['email']) ||
            empty($data['password'])
        ){
            response(false,"Required fields missing");
        }

        if($this->user->findByEmail($data['email'])){
            response(false,"Email already exists");
        }

        $society = $this->conn->prepare(
            "INSERT INTO societies
            (
                name,
                city,
                state,
                country
            )
            VALUES
            (?, ?, ?, ?)"
        );

        $society->execute([
            $data['society_name'],
            $data['city'] ?? '',
            $data['state'] ?? '',
            $data['country'] ?? ''
        ]);

        $societyId = $this->conn->lastInsertId();

        $profile = $this->conn->prepare(
            "INSERT INTO society_profile
            (
                society_id,
                society_name,
                address,
                city,
                state,
                country,
                pincode,
                phone,
                email,
                maintenance_amount
            )
            VALUES
            (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
        );

        $profile->execute([
            $societyId,
            $data['society_name'],
            "",
            $data['city'] ?? "",
            $data['state'] ?? "",
            $data['country'] ?? "",
            "",
            $data['phone'] ?? "",
            $data['email'],
            0
        ]);

        $hashedPassword = password_hash(
            $data['password'],
            PASSWORD_DEFAULT
        );

        $this->user->createAdmin(
            $societyId,
            $data['admin_name'],
            $data['email'],
            $data['phone'] ?? '',
            $hashedPassword
        );

        $this->subscription->createTrial(
            $societyId
        );

        response(
            true,
            "Society registered successfully"
        );
    }

    public function login()
    {
        $data = json_decode(
            file_get_contents("php://input"),
            true
        );

        if (
            empty($data['email']) ||
            empty($data['password'])
        ) {
            response(false, "Email and password required");
        }

        $user = $this->user->findByEmail(
            $data['email']
        );

        if (!$user) {
            response(false, "User not found");
        }

        if (!password_verify($data['password'], $user['password'])) {
            response(false, "Invalid password");
        }

        $token = bin2hex(random_bytes(32));

        $update = $this->conn->prepare(
            "UPDATE users
            SET api_token = ?
            WHERE id = ?"
        );

        $update->execute([
            $token,
            $user['id']
        ]);

        response(
            true,
            "Login successful",
            [
                "user_id" => $user['id'],
                "society_id" => $user['society_id'],
                "name" => $user['name'],
                "email" => $user['email'],
                "role" => $user['role'],
                "token" => $token
            ]
        );
    }
}
