<?php

class Order extends Model
{
    protected string $table = 'orders';

    public function all(): array
    {
        $stmt = Database::connection()->query(
            "SELECT * FROM {$this->table} ORDER BY id DESC"
        );
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotalOrder(): int
    {
        $sql = "SELECT COUNT(*) AS total FROM {$this->table}";
        $stmt = Database::connection()->query($sql);
        return (int) $stmt->fetch(PDO::FETCH_ASSOC)['total'];
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
        // កែសម្រួល SQL ឱ្យត្រឹមត្រូវ និងបន្ថែម final_amount, created_at, updated_at
        $stmt = Database::connection()->prepare(
            "INSERT INTO {$this->table}
            (customer_id, order_number, total_amount, discount_amount, final_amount, status, payment_status, shipping_address, created_at, updated_at)
            VALUES 
            (:customer_id, :order_number, :total_amount, :discount_amount, :final_amount, :status, :payment_status, :shipping_address, NOW(), NOW())"
        );

        return $stmt->execute([
            "customer_id" => $data["customer_id"],
            "order_number" => $data["order_number"],
            "total_amount" => $data["total_amount"],
            "discount_amount" => $data["discount_amount"],
            "final_amount" => $data["final_amount"] ?? 0, // បន្ថែម final_amount
            "status" => $data["status"],
            "payment_status" => $data["payment_status"],
            "shipping_address" => $data["shipping_address"],
        ]);
    }

    // បន្ថែម Method សម្រាប់ Update (សម្រាប់ទំព័រ Edit)
    public function update($id, array $data)
    {
        $stmt = Database::connection()->prepare(
            "UPDATE {$this->table} SET 
            total_amount = :total_amount, 
            discount_amount = :discount_amount, 
            final_amount = :final_amount, 
            status = :status, 
            payment_status = :payment_status, 
            shipping_address = :shipping_address,
            updated_at = NOW()
            WHERE id = :id"
        );

        return $stmt->execute([
            "id" => $id,
            "total_amount" => $data["total_amount"],
            "discount_amount" => $data["discount_amount"],
            "final_amount" => $data["final_amount"],
            "status" => $data["status"],
            "payment_status" => $data["payment_status"],
            "shipping_address" => $data["shipping_address"],
        ]);
    }
}
