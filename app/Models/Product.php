<?php

namespace App\Models;

use PDO;

class Product extends Model
{
    public function getAll()
    {
        $query = "SELECT *
            FROM products
            ORDER BY id DESC";

        $stmt = $this->db->prepare($query);

        if ($stmt->execute()) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        return [];
    }

    public function create(array $request)
    {
        $query = "INSERT INTO products
            (
                name,
                description,
                price,
                image
            )
            VALUES
            (
                :name,
                :description,
                :price,
                :image
            )";
        $stmt = $this->db->prepare($query);

        return $stmt->execute($request);
    }

    public function find(int $id)
    {
        $query = "SELECT *
            FROM products
            WHERE id = :id";

        $stmt = $this->db->prepare($query);

        $stmt->execute([
            'id' => $id
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findOrFail(int $id): array
    {
        $product = $this->find($id);

        if (!$product) {
            throw new \Exception('Product not found');
        }

        return $product;
    }

    public function search(
        string $keyword
    ) {
        $query = "SELECT *
        FROM products
        WHERE name LIKE :keyword";

        $stmt = $this->db->prepare($query);

        $stmt->execute([
            'keyword' => "%$keyword%"
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
