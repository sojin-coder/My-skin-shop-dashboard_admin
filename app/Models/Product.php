<?php


class Product extends Model
{
    protected string $table = 'products';

    // get product
    public function all(): array
    {
        $stmt = Database::connection()->query("SELECT * FROM {$this->table} ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // create product

    public function create(array $data){
        $stmt = Database::connection()->prepare("INSERT INTO {$this->table}
            (name, price, stock, image, description)
            VALUES (:name, :price, :stock, :image, :description)");

        return $stmt->execute([
            "name" => $data["name"],
            "price" => $data["price"],
            "stock" => $data["stock"],
            "image" => $data["image"],
            "description" => $data["description"],
        ]);
    }
    public function find(int $id): ?array
    {
        $stmt = Database::connection()->prepare("
            SELECT *
            FROM {$this->table}
            WHERE id = :id
        ");

        $stmt->execute([
            "id" => $id
        ]);

        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        return $product ?: null;
    }

    public function update(int $id, array $data): bool
    {
        $stmt = Database::connection()->prepare("
            UPDATE {$this->table}
            SET
                name = :name,
                price = :price,
                stock = :stock,
                image = :image,
                description = :description
            WHERE id = :id
        ");
    
        return $stmt->execute([
            'id' => $id,
            'name' => $data['name'],
            'price' => $data['price'],
            'stock' => $data['stock'],
            'image' => $data['image'],
            'description' => $data['description'],
        ]);
    }
    // delete product
    public function delete(int $id){
        $stmt = Database::connection()->prepare("DELETE FROM {$this->table} WHERE id = :id");
        return $stmt->execute(['id'=> $id]);
    }
    public function search(string $keyword):array{
        $stmt = Database::connection()->prepare("SELECT * FROM {$this->table} 
        WHERE name LIKE :keyword ORDER BY id DESC");

        $stmt->execute(['keyword' => '%'.$keyword . '%']);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotalProducts(): int
    {
        $sql = "SELECT COUNT(*) AS total FROM {$this->table}";

        $stmt = Database::connection()->query($sql);

        return (int) $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }
    
   
}


