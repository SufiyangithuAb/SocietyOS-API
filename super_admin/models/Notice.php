<?php

class Notice
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function getAll($search = '')
    {
        $sql = "
            SELECT
                n.id,
                s.name AS society_name,
                u.name AS created_by,
                n.title,
                n.description,
                n.created_at
            FROM notices n

            LEFT JOIN societies s
                ON n.society_id = s.id

            LEFT JOIN users u
                ON n.created_by = u.id
        ";

        $params = [];

        if (!empty($search)) {

            $sql .= " WHERE (
                n.title LIKE ?
                OR s.name LIKE ?
            )";

            $params[] = "%{$search}%";
            $params[] = "%{$search}%";
        }

        $sql .= " ORDER BY n.id DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}