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
}