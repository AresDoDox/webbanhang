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

        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return [
            'data'       => $data,
            'total'      => $data ? count($data) : 0,
            'page'       => $data ? 1 : 0,
            'limit'      => $data ? count($data) : 0,
            'totalPages' => $data ? 1 : 0,
        ];
    }

    public function update(int $id, array $request)
    {
        $query = "UPDATE products
            SET
            name = :name,
            description = :description,
            price = :price,
            image = :image
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
        $query = "DELETE FROM products WHERE id = :id";

        $stmt = $this->db->prepare($query);

        return $stmt->execute([
            'id' => $id
        ]);
    }

    public function paginate(
        int $page,
        int $limit = 10
    ) {
        $offset = ($page - 1) * $limit;

        $query = "SELECT * FROM products
        ORDER BY id DESC
        LIMIT :limit
        OFFSET :offset
        ";

        $stmt = $this->db->prepare($query);

        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, \PDO::PARAM_INT);

        $stmt->execute();

        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $total = $this->db->query("SELECT COUNT(*) FROM products")->fetchColumn();

        return [
            'data'       => $data,
            'total'      => $total,
            'page'       => $page,
            'limit'      => $limit,
            'totalPages' => ceil($total / $limit)
        ];
    }

    public function searchPaginate(
        string $keyword,
        int $page,
        int $limit = 10
    ) {
        $offset = ($page - 1) * $limit;

        $countQuery = "SELECT COUNT(*) as total FROM products WHERE name LIKE :keyword OR description LIKE :keyword";
        $countStmt = $this->db->prepare($countQuery);
        $countStmt->execute(['keyword' => "%$keyword%"]);
        $total = $countStmt->fetch()['total'];

        $query = "SELECT * FROM products 
            WHERE name LIKE :keyword OR description LIKE :keyword
            LIMIT :limit OFFSET :offset";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':keyword', "%$keyword%");
        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, \PDO::PARAM_INT);
        $stmt->execute();
        $data = $stmt->fetchAll();

        return [
            'data'       => $data,
            'total'      => $total,
            'page'       => $page,
            'limit'      => $limit,
            'totalPages' => ceil($total / $limit)
        ];
    }

    public function count(): int
    {
        $query = "SELECT COUNT(*) total FROM products";
        $stmt = $this->db->query($query);

        return (int) $stmt->fetch()['total'];
    }

    public function monthlyProducts()
    {
        $query = "SELECT
                MONTH(created_at) month,
                COUNT(*) total
            FROM products
            GROUP BY MONTH(created_at)
        ";
        $stmt = $this->db->query($query);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
