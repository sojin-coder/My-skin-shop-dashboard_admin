<?php

class Feedback extends Model
{
    // ប្រសិនបើឈ្មោះតារាងក្នុង Database គឺ reviews
    protected string $table = 'reviews';

    // ទាញយកទិន្នន័យទាំងអស់ រួមទាំងឈ្មោះអតិថិជន (JOIN)
    public function allWithCustomer(): array
    {
        $sql = "SELECT r.*, c.name AS customer_name, c.email AS customer_email, p.name AS product_name 
            FROM {$this->table} r
            LEFT JOIN customers c ON r.customer_id = c.id
            LEFT JOIN products p ON r.product_id = p.id
            ORDER BY r.created_at DESC";

        $stmt = Database::connection()->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ទាញយកទិន្នន័យតាម ID សម្រាប់ Edit
    public function find($id)
    {
        $stmt = Database::connection()->prepare("SELECT * FROM {$this->table} WHERE id = :id LIMIT 1");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Update Status (ឧ. ពី pending ទៅ resolved)
    public function updateStatus($id, $status)
    {
        $stmt = Database::connection()->prepare(
            "UPDATE {$this->table} SET status = :status, updated_at = NOW() WHERE id = :id"
        );
        return $stmt->execute(['status' => $status, 'id' => $id]);
    }

    // លុប Feedback
    public function delete($id)
    {
        $stmt = Database::connection()->prepare("DELETE FROM {$this->table} WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
    
}