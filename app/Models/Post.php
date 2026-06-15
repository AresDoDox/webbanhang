<?php

namespace App\Models;

use PDO;

class Post extends Model
{
    public function getAll()
    {
        $query = "SELECT * FROM posts
            ORDER BY id DESC
        ";
        $stmt = $this->db->prepare($query);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get list post theo user (người tạo)
    public function getByUser(int $userId)
    {
        $query = "SELECT * FROM posts
            WHERE user_id = :user_id
            ORDER BY id DESC
        ";
        $stmt = $this->db->prepare($query);

        $stmt->execute([
            'user_id' => $userId
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find(int $id)
    {
        $query = "SELECT * FROM posts
            WHERE id = :id
        ";
        $stmt = $this->db->prepare($query);
        $stmt->execute([
            'id' => $id
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findOrFail(int $id): array
    {
        $post = $this->find($id);

        if (!$post) {
            throw new \Exception('Post not found');
        }

        return $post;
    }

    public function create(array $data)
    {
        $query = "INSERT INTO posts (
            user_id,
            title,
            content
        )
        VALUES (
            :user_id,
            :title,
            :content
        )";
        $stmt = $this->db->prepare($query);

        return $stmt->execute($data);
    }

    public function update(int $id, array $request)
    {
        $query = "UPDATE posts
            SET
            user_id = :user_id,
            title = :title,
            content = :content
        WHERE id = :id
        ";

        $stmt = $this->db->prepare($query);

        return $stmt->execute([
            ...$request,
            'id' => $id
        ]);
    }

    public function delete(int $id)
    {
        $query = "DELETE FROM posts WHERE id = :id";

        $stmt = $this->db->prepare($query);

        return $stmt->execute([
            'id' => $id
        ]);
    }
}
