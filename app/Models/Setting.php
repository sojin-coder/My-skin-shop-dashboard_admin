<?php

class Setting extends Model
{
    protected string $table = 'settings';

    public function all(): array
    {
        $stmt = Database::connection()->query(
            "SELECT * FROM {$this->table}"
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

    public function updateValue($id, $value)
    {
        $stmt = Database::connection()->prepare(
            "UPDATE {$this->table} SET setting_value = :value WHERE id = :id"
        );
        return $stmt->execute(['value' => $value, 'id' => $id]);
    }
}