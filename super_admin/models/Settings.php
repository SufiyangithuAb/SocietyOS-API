<?php

class Settings
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function get()
    {
        return $this->db
            ->query("SELECT * FROM settings LIMIT 1")
            ->fetch(PDO::FETCH_ASSOC);
    }

    public function update($data)
    {
        $stmt = $this->db->prepare("
            UPDATE settings SET

            site_name=?,
            company_name=?,
            support_email=?,
            support_phone=?,
            currency=?,
            timezone=?,
            maintenance_mode=?,
            address=?

            WHERE id=1
        ");

        return $stmt->execute([

            $data['site_name'],
            $data['company_name'],
            $data['support_email'],
            $data['support_phone'],
            $data['currency'],
            $data['timezone'],
            $data['maintenance_mode'],
            $data['address']

        ]);
    }
}