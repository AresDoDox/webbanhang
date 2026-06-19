<?php

namespace App\Models;

use PDO;

class Product extends Model
{
    protected string $table = 'products';
    protected array $searchable = ['name', 'description'];
    protected array $fillable = ['name', 'description', 'price', 'image'];

    public function monthlyProducts()
    {
        $query = "SELECT
                MONTH(created_at) month,
                COUNT(*) total
            FROM {$this->table}
            GROUP BY MONTH(created_at)
        ";
        $stmt = $this->db->query($query);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
