<?php

class Comment
{
    private $conn;

    public function __construct()
    {
        $this->conn = connectDB();
        $this->ensureTable();
    }

    private function ensureTable(): void
    {
        $sql = "CREATE TABLE IF NOT EXISTS product_comments (
                    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
                    product_id INT UNSIGNED NOT NULL,
                    user_id INT UNSIGNED NOT NULL,
                    content TEXT NOT NULL,
                    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                    PRIMARY KEY (id),
                    KEY idx_product_comments_product_id (product_id),
                    KEY idx_product_comments_user_id (user_id)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
        $this->conn->exec($sql);
    }

    public function getByProductId(int $productId): array
    {
        $sql = "SELECT c.*, u.fullname, u.email
                FROM product_comments c
                LEFT JOIN users u ON c.user_id = u.id
                WHERE c.product_id = :product_id
                ORDER BY c.id DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['product_id' => $productId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    public function create(int $productId, int $userId, string $content): bool
    {
        $sql = "INSERT INTO product_comments (product_id, user_id, content)
                VALUES (:product_id, :user_id, :content)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            'product_id' => $productId,
            'user_id' => $userId,
            'content' => $content,
        ]);
    }
}

