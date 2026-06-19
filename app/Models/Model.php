<?php

namespace App\Models;

use PDO;
use Database;

class Model
{
    protected PDO $db;
    protected string $table = '';
    protected string $primaryKey = 'id';
    protected string $defaultOrder = 'id DESC';
    protected array $searchable = [];
    protected array $fillable = [];

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function getAll(): array
    {
        $query = "SELECT * FROM {$this->table} ORDER BY {$this->defaultOrder}";

        return $this->db
            ->query($query)
            ->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find(int $id): ?array
    {
        $query = "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = :id";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['id' => $id]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result === false ? null : $result;
    }

    public function findOrFail(int $id): array
    {
        $record = $this->find($id);

        if (!$record) {
            throw new \Exception(ucfirst(rtrim($this->table, 's')) . ' not found');
        }

        return $record;
    }

    public function findBy(string $field, $value): ?array
    {
        $query = "SELECT * FROM {$this->table} WHERE {$field} = :value LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['value' => $value]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result === false ? null : $result;
    }

    public function delete(int $id): bool
    {
        $query = "DELETE FROM {$this->table} WHERE {$this->primaryKey} = :id";
        $stmt = $this->db->prepare($query);

        return $stmt->execute(['id' => $id]);
    }

    public function count(): int
    {
        $query = "SELECT COUNT(*) total FROM {$this->table}";
        $stmt = $this->db->query($query);

        return (int) $stmt->fetch()['total'];
    }

    public function paginate(int $page, int $limit = 10): array
    {
        $offset = ($page - 1) * $limit;
        $query = "SELECT * FROM {$this->table} ORDER BY {$this->defaultOrder} LIMIT :limit OFFSET :offset";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $total = $this->count();

        return [
            'data'       => $data,
            'total'      => $total,
            'page'       => $page,
            'limit'      => $limit,
            'totalPages' => ceil($total / $limit),
        ];
    }

    public function search(string $keyword): array
    {
        if (empty($this->searchable)) {
            return [];
        }

        $conditions = array_map(fn($column) => "{$column} LIKE :keyword", $this->searchable);
        $query = "SELECT * FROM {$this->table} WHERE " . implode(' OR ', $conditions);
        $stmt = $this->db->prepare($query);
        $stmt->execute(['keyword' => "%{$keyword}%"]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function searchPaginate(string $keyword, int $page, int $limit = 10): array
    {
        if (empty($this->searchable)) {
            return [
                'data'       => [],
                'total'      => 0,
                'page'       => $page,
                'limit'      => $limit,
                'totalPages' => 0,
            ];
        }

        $conditions = array_map(fn($column) => "{$column} LIKE :keyword", $this->searchable);
        $where = implode(' OR ', $conditions);

        $countQuery = "SELECT COUNT(*) as total FROM {$this->table} WHERE {$where}";
        $countStmt = $this->db->prepare($countQuery);
        $countStmt->execute(['keyword' => "%{$keyword}%"]);
        $total = (int) $countStmt->fetch()['total'];

        $offset = ($page - 1) * $limit;
        $query = "SELECT * FROM {$this->table} WHERE {$where} ORDER BY {$this->defaultOrder} LIMIT :limit OFFSET :offset";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':keyword', "%{$keyword}%");
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return [
            'data'       => $data,
            'total'      => $total,
            'page'       => $page,
            'limit'      => $limit,
            'totalPages' => ceil($total / $limit),
        ];
    }

    public function create(array $data): bool
    {
        if (empty($this->fillable)) {
            throw new \Exception('Fillable fields are not defined for ' . static::class);
        }

        $fields = array_intersect_key($data, array_flip($this->fillable));
        $columns = array_keys($fields);
        $placeholders = array_map(fn($column) => ":{$column}", $columns);

        $query = sprintf(
            'INSERT INTO %s (%s) VALUES (%s)',
            $this->table,
            implode(', ', $columns),
            implode(', ', $placeholders)
        );

        $stmt = $this->db->prepare($query);

        return $stmt->execute($fields);
    }

    public function update(int $id, array $data): bool
    {
        if (empty($this->fillable)) {
            throw new \Exception('Fillable fields are not defined for ' . static::class);
        }

        $fields = array_intersect_key($data, array_flip($this->fillable));
        $columns = array_keys($fields);
        $assignments = array_map(fn($column) => "{$column} = :{$column}", $columns);

        $query = sprintf(
            'UPDATE %s SET %s WHERE %s = :id',
            $this->table,
            implode(', ', $assignments),
            $this->primaryKey
        );

        $stmt = $this->db->prepare($query);

        return $stmt->execute([
            ...$fields,
            'id' => $id,
        ]);
    }
}
