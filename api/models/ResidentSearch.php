<?php

class ResidentSearch
{
    private $conn;

    private $table = "residents";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function search($societyId, $keyword)
    {
        $keyword = "%".$keyword."%";

        $query = $this->conn->prepare(

            "SELECT *

            FROM {$this->table}

            WHERE society_id = ?

            AND (

                name LIKE ?

                OR email LIKE ?

                OR phone LIKE ?

                OR flat_number LIKE ?

                OR tower LIKE ?

            )

            ORDER BY name ASC"

        );

        $query->execute([

            $societyId,

            $keyword,
            $keyword,
            $keyword,
            $keyword,
            $keyword

        ]);

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}