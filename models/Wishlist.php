<?php

class Wishlist
{
    private $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

    /**
     * Thêm sản phẩm vào wishlist
     */
    public function add($userId, $productId)
    {
        $stmt = $this->conn->prepare("INSERT INTO wishlist (user_id, product_id) VALUES (?, ?) ON DUPLICATE KEY UPDATE created_at = CURRENT_TIMESTAMP");
        return $stmt->execute([$userId, $productId]);
    }

    /**
     * Xóa sản phẩm khỏi wishlist
     */
    public function remove($userId, $productId)
    {
        $stmt = $this->conn->prepare("DELETE FROM wishlist WHERE user_id = ? AND product_id = ?");
        return $stmt->execute([$userId, $productId]);
    }

    /**
     * Kiểm tra sản phẩm có trong wishlist không
     */
    public function isInWishlist($userId, $productId)
    {
        $stmt = $this->conn->prepare("SELECT COUNT(*) as count FROM wishlist WHERE user_id = ? AND product_id = ?");
        $stmt->execute([$userId, $productId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] > 0;
    }

    /**
     * Lấy wishlist của user
     */
    public function getByUser($userId)
    {
        $stmt = $this->conn->prepare("
            SELECT w.*, p.name, p.price, p.image, p.description, c.name as category_name
            FROM wishlist w
            JOIN products p ON w.product_id = p.id
            LEFT JOIN categories c ON p.category_id = c.id
            WHERE w.user_id = ?
            ORDER BY w.created_at DESC
        ");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Đếm số sản phẩm trong wishlist
     */
    public function countByUser($userId)
    {
        $stmt = $this->conn->prepare("SELECT COUNT(*) as count FROM wishlist WHERE user_id = ?");
        $stmt->execute([$userId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'];
    }
}
?>