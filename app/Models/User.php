<?php

namespace App\Models;

use PDO;

class User extends Model
{
    protected string $table = 'users';
    protected array $searchable = ['name', 'email'];
    protected array $fillable = ['name', 'email', 'password', 'role'];

    public function register(array $request)
    {
        return parent::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => password_hash($request['password'], PASSWORD_DEFAULT),
            'role' => 'user'
        ]);
    }

    public function findByEmail(string $email): ?array
    {
        return $this->findBy('email', $email);
    }

    public function emailExists(string $email): bool
    {
        $stmt = $this->db->prepare(
            "SELECT id FROM {$this->table} WHERE email = :email"
        );

        $stmt->execute([
            'email' => $email
        ]);

        return $stmt->fetch() !== false;
    }

    public function countAdmins()
    {
        $query = "SELECT COUNT(*) as total FROM {$this->table}
        WHERE role = 'admin'
        ";
        $stmt = $this->db->query($query);

        return $stmt->fetch()['total'];
    }

    public function monthlyRegistrations()
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
