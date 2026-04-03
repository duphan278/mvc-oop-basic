<?php

class Watch
{
    private $conn;

    public function __construct()
    {
        // Dùng chung cấu hình CSDL từ commons/env.php
        $this->conn = connectDB();
    }

    // 1. Lấy tất cả
    public function getAll()
    {
        $sql = "SELECT products.*, categories.name AS category_name
                FROM products
                LEFT JOIN categories ON products.category_id = categories.id";

        return $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    // 1.1. Lấy theo danh mục
    public function getByCategory($category_id)
    {
        $sql = "SELECT products.*, categories.name AS category_name
                FROM products
                LEFT JOIN categories ON products.category_id = categories.id
                WHERE products.category_id = :category_id";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['category_id' => $category_id]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 2. Chi tiết
    public function find($id)
    {
        $sql = "SELECT products.*, categories.name AS category_name
                FROM products
                LEFT JOIN categories ON products.category_id = categories.id
                WHERE products.id = :id";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // 2.1. Lấy nhiều sản phẩm theo danh sách ID
    public function getByIds(array $ids)
    {
        if (empty($ids)) {
            return [];
        }

        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $sql = "SELECT products.*, categories.name AS category_name
                FROM products
                LEFT JOIN categories ON products.category_id = categories.id
                WHERE products.id IN ($placeholders)";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute($ids);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 3. Thêm
    public function create($data)
    {
        $category_id = isset($data['category_id']) && $data['category_id'] !== '' ? (int)$data['category_id'] : null;

        $sql = "INSERT INTO products 
                (name, category_id, price, description, image)
                VALUES 
                (:name, :category_id, :price, :description, :image)";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            'name' => $data['name'],
            'category_id' => $category_id,
            'price' => $data['price'],
            'description' => $data['description'],
            'image' => $data['image']
        ]);
    }

    // 4. Cập nhật
    public function update($id, $data)
    {
        $category_id = isset($data['category_id']) && $data['category_id'] !== '' ? (int)$data['category_id'] : null;

        $sql = "UPDATE products SET
                    name = :name,
                    category_id = :category_id,
                    price = :price,
                    description = :description,
                    image = :image
    
                WHERE id = :id";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            'name' => $data['name'],
            'category_id' => $category_id,
            'price' => $data['price'],
            'description' => $data['description'],
            'image' => $data['image'],
            'id' => $id
        ]);
    }

    // 5. Xóa
    public function delete($id)
    {
        $sql = "DELETE FROM products WHERE id = :id";

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
}