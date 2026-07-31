<?php

class Report
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function dashboard()
    {
        return [

            'societies' => $this->db->query("SELECT COUNT(*) FROM societies")->fetchColumn(),

            'residents' => $this->db->query("SELECT COUNT(*) FROM users WHERE role='RESIDENT'")->fetchColumn(),

            'revenue' => $this->db->query("SELECT IFNULL(SUM(amount),0) FROM payments WHERE status='SUCCESS'")->fetchColumn(),

            'activePlans' => $this->db->query("SELECT COUNT(*) FROM subscriptions WHERE status='ACTIVE'")->fetchColumn(),

            'complaints' => $this->db->query("SELECT COUNT(*) FROM complaints")->fetchColumn(),

            'resolved' => $this->db->query("SELECT COUNT(*) FROM complaints WHERE status='RESOLVED'")->fetchColumn(),

            'open' => $this->db->query("SELECT COUNT(*) FROM complaints WHERE status='OPEN'")->fetchColumn()

        ];
    }
}