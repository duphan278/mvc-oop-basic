<?php
require_once __DIR__ . '/commons/env.php';
require_once __DIR__ . '/commons/function.php';

try {
    $conn = connectDB();
    $columns = ['payment_method' => "VARCHAR(255) DEFAULT 'cod'",
                'shipping_address' => 'TEXT',
                'contact_name' => 'VARCHAR(255)',
                'contact_phone' => 'VARCHAR(20)',
                'bank' => 'VARCHAR(255)'];

    foreach ($columns as $column => $definition) {
        $stmt = $conn->prepare("SELECT COUNT(*) AS cnt FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'orders' AND COLUMN_NAME = :column");
        $stmt->execute(['column' => $column]);
        $exists = (int)$stmt->fetch(PDO::FETCH_ASSOC)['cnt'];
        if ($exists === 0) {
            $conn->exec("ALTER TABLE orders ADD COLUMN `$column` $definition");
        }
    }

    // Tạo bảng order_items nếu chưa có
    $conn->exec("CREATE TABLE IF NOT EXISTS `order_items` (
      `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
      `order_id` INT NOT NULL,
      `product_id` INT NOT NULL,
      `product_name` VARCHAR(255) NOT NULL,
      `quantity` INT NOT NULL DEFAULT 1,
      `unit_price` DECIMAL(12,2) NOT NULL DEFAULT 0,
      `subtotal` DECIMAL(12,2) NOT NULL DEFAULT 0,
      PRIMARY KEY (`id`),
      KEY `idx_order_items_order_id` (`order_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");

    // Tạo bảng order_status_history nếu chưa có
    $conn->exec("CREATE TABLE IF NOT EXISTS `order_status_history` (
      `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
      `order_id` INT NOT NULL,
      `status` VARCHAR(50) NOT NULL,
      `changed_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
      PRIMARY KEY (`id`),
      KEY `idx_order_status_history_order_id` (`order_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");

    // Tạo bảng vouchers nếu chưa có
    $conn->exec("CREATE TABLE IF NOT EXISTS `vouchers` (
      `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
      `code` VARCHAR(50) NOT NULL UNIQUE,
      `discount_type` ENUM('percent', 'fixed') NOT NULL DEFAULT 'percent',
      `discount_value` DECIMAL(12,2) NOT NULL DEFAULT 0,
      `min_order_amount` DECIMAL(12,2) NOT NULL DEFAULT 0,
      `expiry_date` DATETIME NOT NULL,
      `is_active` TINYINT(1) NOT NULL DEFAULT 1,
      `usage_limit` INT UNSIGNED NULL DEFAULT NULL,
      `used_count` INT UNSIGNED NOT NULL DEFAULT 0,
      PRIMARY KEY (`id`),
      UNIQUE KEY `uniq_vouchers_code` (`code`),
      KEY `idx_vouchers_expiry_date` (`expiry_date`),
      KEY `idx_vouchers_is_active` (`is_active`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");

    // Thêm cột voucher_id và discount_amount vào orders
    $voucherColumns = ['voucher_id' => 'INT UNSIGNED NULL', 'discount_amount' => "DECIMAL(12,2) NOT NULL DEFAULT 0"];
    foreach ($voucherColumns as $column => $definition) {
        $stmt = $conn->prepare("SELECT COUNT(*) AS cnt FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'orders' AND COLUMN_NAME = :column");
        $stmt->execute(['column' => $column]);
        $exists = (int)$stmt->fetch(PDO::FETCH_ASSOC)['cnt'];
        if ($exists === 0) {
            $conn->exec("ALTER TABLE orders ADD COLUMN `$column` $definition");
        }
    }

    // Thêm foreign key cho voucher_id
    $stmt = $conn->prepare("SELECT COUNT(*) AS cnt FROM INFORMATION_SCHEMA.TABLE_CONSTRAINTS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'orders' AND CONSTRAINT_NAME = 'fk_orders_voucher'");
    $stmt->execute();
    $fkExists = (int)$stmt->fetch(PDO::FETCH_ASSOC)['cnt'];
    if ($fkExists === 0) {
        $conn->exec("ALTER TABLE orders ADD CONSTRAINT `fk_orders_voucher` FOREIGN KEY (`voucher_id`) REFERENCES `vouchers` (`id`) ON DELETE SET NULL");
    }

    // Seed dữ liệu voucher mẫu
    $conn->exec("INSERT INTO `vouchers` (`code`, `discount_type`, `discount_value`, `min_order_amount`, `expiry_date`, `is_active`, `usage_limit`) VALUES
    ('WELCOME10', 'percent', 10.00, 500000.00, '2026-12-31 23:59:59', 1, 100),
    ('SAVE50K', 'fixed', 50000.00, 1000000.00, '2026-12-31 23:59:59', 1, 50),
    ('FLASH20', 'percent', 20.00, 200000.00, '2026-04-30 23:59:59', 1, NULL)
    ON DUPLICATE KEY UPDATE `code` = `code`");

    // Tạo bảng wishlist nếu chưa có
    $conn->exec("CREATE TABLE IF NOT EXISTS `wishlist` (
      `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
      `user_id` INT NOT NULL,
      `product_id` INT NOT NULL,
      `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
      PRIMARY KEY (`id`),
      UNIQUE KEY `uniq_wishlist_user_product` (`user_id`, `product_id`),
      KEY `idx_wishlist_user_id` (`user_id`),
      KEY `idx_wishlist_product_id` (`product_id`),
      CONSTRAINT `fk_wishlist_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
      CONSTRAINT `fk_wishlist_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");

    // Tạo bảng newsletter_subscribers nếu chưa có
    $conn->exec("CREATE TABLE IF NOT EXISTS `newsletter_subscribers` (
      `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
      `email` VARCHAR(255) NOT NULL UNIQUE,
      `subscribed_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
      `is_active` TINYINT(1) NOT NULL DEFAULT 1,
      PRIMARY KEY (`id`),
      UNIQUE KEY `uniq_newsletter_email` (`email`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");

    echo "Database updated successfully.";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>