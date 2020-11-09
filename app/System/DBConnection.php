<?php

namespace App\System;

class DBConnection {

    private $db;

    public function __construct()
    {
        $this->db = new \mysqli($_ENV['DB_HOST'], $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD'], $_ENV['DB_DATABASE']);

        if ($this->db->connect_error) {
            die(sprintf('Failed to connect to db: %s', $this->db->connect_error));
        }
    }

    public function getConnection() {
        return $this->db;
    }
}
