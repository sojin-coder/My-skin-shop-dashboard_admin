
<?php

class Customer extends Model
{
    protected string $table = 'customers';

    public function all(): array
    {
        $stmt = Database::connection()->query(
            "SELECT * FROM {$this->table} ORDER BY id DESC"
        );
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id)
    {
        $stmt = Database::connection()->prepare(
            "SELECT * FROM {$this->table} WHERE id = :id LIMIT 1"
        );
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function create(array $data)
    {
        $stmt = Database::connection()->prepare(
            "INSERT INTO {$this->table} 
            (name, email, phone, password, address, status, created_at, updated_at) 
            VALUES 
            (:name, :email, :phone, :password, :address, :status, NOW(), NOW())"
        );

        return $stmt->execute([
            "name" => $data["name"],
            "email" => $data["email"],
            "phone" => $data["phone"],
            "password" => $data["password"],
            "address" => $data["address"],
            "status" => $data["status"],
        ]);
    }
}