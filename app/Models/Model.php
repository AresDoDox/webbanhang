<?php

namespace App\Models;

use PDO;
use Database;

class Model
{
    protected PDO $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }
}
