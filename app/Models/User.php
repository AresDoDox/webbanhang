<?php

namespace App\Models;

use PDO;

class User extends Model
{
    public function getAll()
    {
        $query = "SELECT * FROM users ORDER BY id DESC";
        $stmt = $this->db->query($query);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function search(string $keyword)
    {
        $query = "SELECT * FROM users
        WHERE
            name LIKE :keyword
            OR email LIKE :keyword
        ORDER BY id DESC";
        $stmt = $this->db->prepare($query);

        $stmt->execute([
            'keyword' => "%{$keyword}%"
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function paginate(
        int $page,
        int $limit = 10
    ) {
        $offset = ($page - 1) * $limit;

        $query = "SELECT * FROM users
        ORDER BY id DESC
        LIMIT :limit
        OFFSET :offset
        ";

        $stmt = $this->db->prepare($query);

        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, \PDO::PARAM_INT);

        $stmt->execute();

        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $total = $this->db->query("SELECT COUNT(*) FROM users")->fetchColumn();

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

        $countQuery = "SELECT COUNT(*) as total FROM users WHERE name LIKE :keyword OR email LIKE :keyword";
        $countStmt = $this->db->prepare($countQuery);
        $countStmt->execute(['keyword' => "%$keyword%"]);
        $total = $countStmt->fetch()['total'];

        $query = "SELECT * FROM users 
            WHERE name LIKE :keyword OR email LIKE :keyword
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

    public function create(array $request)
    {
        $query = "INSERT INTO users (name, email, password, role) VALUES (:name, :email, :password, :role)";
        $stmt = $this->db->prepare($query);

        return $stmt->execute([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => password_hash($request['password'], PASSWORD_DEFAULT),
            'role' => 'user'
        ]);
    }

    public function findByEmail(string $email)
    {
        $query = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->db->prepare($query);

        $stmt->execute(['email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findById(int $id)
    {
        $query = "SELECT * FROM users WHERE id = :id";
        $stmt = $this->db->prepare($query);

        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function emailExists(string $email): bool
    {
        $stmt = $this->db->prepare(
            "SELECT id FROM users WHERE email = :email"
        );

        $stmt->execute([
            'email' => $email
        ]);

        return $stmt->fetch() !== false;
    }

    public function update(
        int $id,
        array $data
    ) {
        $query = "UPDATE users
        SET
            name = :name,
            email = :email,
            role = :role
        WHERE id = :id";
        $stmt = $this->db->prepare($query);

        return $stmt->execute([
            ...$data,
            'id' => $id
        ]);
    }

    public function delete(
        int $id
    ) {
        $query = "DELETE FROM users WHERE id = :id";
        $stmt = $this->db->prepare($query);

        return $stmt->execute([
            'id' => $id
        ]);
    }

    public function countAdmins()
    {
        $query = "SELECT COUNT(*) as total FROM users
        WHERE role = 'admin'
        ";
        $stmt = $this->db->query($query);

        return $stmt->fetch()['total'];
    }
}
