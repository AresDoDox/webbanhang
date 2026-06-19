<?php

namespace App\Models;

use PDO;

class Post extends Model
{
    protected string $table = 'posts';
    protected array $searchable = ['title', 'content'];
    protected array $fillable = ['user_id', 'title', 'content'];

    // Get list post theo user (người tạo)
    public function getByUser(int $userId)
    {
        $query = "SELECT * FROM {$this->table}
            WHERE user_id = :user_id
            ORDER BY {$this->defaultOrder}
        ";
        $stmt = $this->db->prepare($query);

        $stmt->execute([
            'user_id' => $userId
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function monthlyPosts()
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
