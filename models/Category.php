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

    public function create(string $name): bool
    {
        $sql = "INSERT INTO categories (name) VALUES (:name)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute(['name' => trim($name)]);
    }
}