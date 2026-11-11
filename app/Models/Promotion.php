<?php
class Promotion extends Model
{
    protected string $table = 'promotions';

    public function all(): array
    {
        $stmt = Database::connection()->query("SELECT * FROM {$this->table} ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create(array $data)
    {
        $stmt = Database::connection()->prepare("
            INSERT INTO {$this->table} 
            (name, code, discount_type, discount_value, start_date, end_date, usage_limit, status, created_at) 
            VALUES (:name, :code, :discount_type, :discount_value, :start_date, :end_date, :usage_limit, :status, NOW())
        ");
        return $stmt->execute([
            "name" => $data["name"],
            "code" => strtoupper($data["code"]),
            "discount_type" => $data["discount_type"],
            "discount_value" => $data["discount_value"],
            "start_date" => $data["start_date"],
            "end_date" => $data["end_date"],
            "usage_limit" => $data["usage_limit"],
            "status" => $data["status"],
        ]);
    }
    // សម្រាប់ទាញយកទិន្នន័យតាម ID (ប្រើក្នុង Edit)
    public function find($id)
    {
        $stmt = Database::connection()->prepare("SELECT * FROM {$this->table} WHERE id = :id LIMIT 1");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // សម្រាប់ Update ទិន្នន័យ
    public function update($id, array $data)
    {
        $stmt = Database::connection()->prepare("
            UPDATE {$this->table} SET 
            name = :name, 
            code = :code, 
            discount_type = :discount_type, 
            discount_value = :discount_value, 
            start_date = :start_date, 
            end_date = :end_date, 
            usage_limit = :usage_limit, 
            status = :status
            WHERE id = :id
        ");

        return $stmt->execute([
            "id" => $id,
            "name" => $data["name"],
            "code" => strtoupper($data["code"]),
            "discount_type" => $data["discount_type"],
            "discount_value" => $data["discount_value"],
            "start_date" => $data["start_date"],
            "end_date" => $data["end_date"],
            "usage_limit" => $data["usage_limit"],
            "status" => $data["status"],
        ]);
    }

    // សម្រាប់លុបទិន្នន័យ
    public function delete($id)
    {
        $stmt = Database::connection()->prepare("DELETE FROM {$this->table} WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}