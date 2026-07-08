<?php

class SocietyProfile
{
    private $conn;

    private $table = "society_profile";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function get($societyId)
    {
        $query = $this->conn->prepare(
            "SELECT *
             FROM {$this->table}
             WHERE society_id=?"
        );

        $query->execute([$societyId]);

        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function update($societyId,$data)
    {
        $query = $this->conn->prepare(
            "UPDATE {$this->table}

            SET

            society_name=?,
            address=?,
            city=?,
            state=?,
            country=?,
            pincode=?,
            phone=?,
            email=?,
            maintenance_amount=?

            WHERE society_id=?"
        );

        return $query->execute([

            $data['society_name'],
            $data['address'],
            $data['city'],
            $data['state'],
            $data['country'],
            $data['pincode'],
            $data['phone'],
            $data['email'],
            $data['maintenance_amount'],

            $societyId

        ]);
    }
}