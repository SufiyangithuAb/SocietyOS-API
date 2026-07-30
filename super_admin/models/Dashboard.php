<?php

class Dashboard
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function getStats(): array
    {
        return [

            'societies'      => $this->countTable('societies'),

            'residents'      => $this->countTable('residents'),

            'subscriptions'  => $this->countTable('subscriptions'),

            'complaints'     => $this->countWhere(
                'complaints',
                "status='pending'"
            )

        ];
    }

    private function countTable($table)
    {
        return (int)$this->db
            ->query("SELECT COUNT(*) FROM {$table}")
            ->fetchColumn();
    }

    private function countWhere($table,$where)
    {
        return (int)$this->db
            ->query("SELECT COUNT(*) FROM {$table} WHERE {$where}")
            ->fetchColumn();
    }

    public function totalRevenue()
    {
        try{

            return (float)$this->db
                ->query("
                    SELECT COALESCE(SUM(amount),0)
                    FROM payments
                ")
                ->fetchColumn();

        }catch(Exception $e){

            return 0;

        }
    }

}