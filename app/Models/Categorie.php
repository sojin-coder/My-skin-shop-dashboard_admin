<?php

class Categorie extends Model
{
    protected string $table = 'categories';

    // Get all categories
    public function all(): array
    {
        $stmt = Database::connection()->query(
            "SELECT * FROM {$this->table} ORDER BY id DESC"
        );

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Search categories
    public function search(string $keyword): array
    {
        $stmt = Database::connection()->prepare("
            SELECT *
            FROM {$this->table}
            WHERE name LIKE :keyword
            ORDER BY id DESC
        ");

        $stmt->execute([
            'keyword' => '%' . $keyword . '%'
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Count categories
    public function getTotalCategories(): int
    {
        $stmt = Database::connection()->query("
            SELECT COUNT(*) AS total
            FROM {$this->table}
        ");

        return (int) $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    // Find category
    public function find(int $id): ?array
    {
        $stmt = Database::connection()->prepare("
            SELECT *
            FROM {$this->table}
            WHERE id = :id
        ");

        $stmt->execute(['id' => $id]);

        $category = $stmt->fetch(PDO::FETCH_ASSOC);

        return $category ?: null;
    }

  
    public function create(array $data): bool
    {
        $stmt = Database::connection()->prepare("
        INSERT INTO {$this->table}
        (name, description, status)
        VALUES (:name, :description, :status)
    ");

        return $stmt->execute([
            'name' => $data['name'],
            'description' => $data['description'],
            'status' => $data['status']
            
        ]);
    }

    // Update category
    public function update(int $id, array $data): bool
    {
        $stmt = Database::connection()->prepare("
            UPDATE {$this->table}
            SET
                name = :name,
                description = :description,
                image = :image,
                status = :status
            WHERE id = :id
        ");

        return $stmt->execute([
            'id' => $id,
            'name' => $data['name'],
            'description' => $data['description'],
            'image' => $data['image'],
            'status' => $data['status']
        ]);
    }

    // Delete category
    public function delete(int $id): bool
    {
        $stmt = Database::connection()->prepare("
            DELETE FROM {$this->table}
            WHERE id = :id
        ");

        return $stmt->execute(['id' => $id]);
    }
}
