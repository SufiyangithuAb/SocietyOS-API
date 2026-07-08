<?php

class ResidentStatistics
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getStatistics($societyId)
    {
        $query = $this->conn->prepare(

            "SELECT

            COUNT(*) total_residents,

            SUM(CASE
                WHEN resident_type='OWNER'
                THEN 1
                ELSE 0
            END) owners,

            SUM(CASE
                WHEN resident_type='TENANT'
                THEN 1
                ELSE 0
            END) tenants,

            COUNT(DISTINCT tower) towers

            FROM residents

            WHERE society_id=?"

        );

        $query->execute([$societyId]);

        return $query->fetch(PDO::FETCH_ASSOC);
    }
}