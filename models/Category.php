<?php

class Category
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
        $sql = "SELECT * FROM categories";
        return $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    // 2. Chi tiết
    public function find($id)
    {
        $sql = "SELECT * FROM categories WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findByName(string $name)
    {
        $sql = "SELECT * FROM categories WHERE LOWER(name) = LOWER(:name) LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['name' => trim($name)]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findByNameExceptId(string $name, int $excludeId)
    {
        $sql = "SELECT * FROM categories
                WHERE LOWER(name) = LOWER(:name) AND id != :exclude_id
                LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            'name' => trim($name),
            'exclude_id' => $excludeId,
        ]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create(string $name): bool
    {
        $sql = "INSERT INTO categories (name) VALUES (:name)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute(['name' => trim($name)]);
    }

    public function update(int $id, string $name): bool
    {
        $sql = "UPDATE categories SET name = :name WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            'id' => $id,
            'name' => trim($name),
        ]);
    }

    public function countProductsByCategoryId(int $id): int
    {
        $sql = "SELECT COUNT(*) AS total FROM products WHERE category_id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        return (int)(($stmt->fetch(PDO::FETCH_ASSOC))['total'] ?? 0);
    }

    public function delete(int $id): bool
    {
        $sql = "DELETE FROM categories WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
}