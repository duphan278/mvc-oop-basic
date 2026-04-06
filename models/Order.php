<?php

class Order
{
    private $conn;

    public function __construct()
    {
        // Dùng chung cấu hình CSDL từ commons/env.php
        $this->conn = connectDB();
    }

    // Tạo đơn hàng mới
    public function create(array $data)
    {
        $sql = "INSERT INTO orders (user_id, total_amount, payment_method, shipping_address, contact_name, contact_phone, bank, status, voucher_id, discount_amount) 
                VALUES (:user_id, :total_amount, :payment_method, :shipping_address, :contact_name, :contact_phone, :bank, :status, :voucher_id, :discount_amount)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($data);
        return $this->conn->lastInsertId();
    }

    // Lấy tất cả đơn hàng
    public function getAll()
    {
        $sql = "SELECT * FROM orders ORDER BY created_at DESC";
        return $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy đơn hàng theo user
    public function getByUser($user_id)
    {
        $sql = "SELECT * FROM orders WHERE user_id = :user_id ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['user_id' => $user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Chi tiết đơn hàng
    public function find($id)
    {
        $sql = "SELECT * FROM orders WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Thêm chi tiết sản phẩm vào order_items
    public function addItems($orderId, array $items)
    {
        $sql = "INSERT INTO order_items (order_id, product_id, product_name, quantity, unit_price, subtotal) 
                VALUES (:order_id, :product_id, :product_name, :quantity, :unit_price, :subtotal)";
        $stmt = $this->conn->prepare($sql);

        foreach ($items as $item) {
            $stmt->execute([
                'order_id' => $orderId,
                'product_id' => $item['id'],
                'product_name' => $item['name'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['price'],
                'subtotal' => $item['subtotal']
            ]);
        }
        return true;
    }

    public function getItems($orderId)
    {
        $sql = "SELECT * FROM order_items WHERE order_id = :order_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['order_id' => $orderId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateStatus($orderId, $status)
    {
        $sql = "UPDATE orders SET status = :status WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute(['status' => $status, 'id' => $orderId]);
    }

    public function addStatusHistory($orderId, $status)
    {
        $sql = "INSERT INTO order_status_history (order_id, status) VALUES (:order_id, :status)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute(['order_id' => $orderId, 'status' => $status]);
    }

    public function getStatusHistory($orderId)
    {
        $sql = "SELECT * FROM order_status_history WHERE order_id = :order_id ORDER BY changed_at DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['order_id' => $orderId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
