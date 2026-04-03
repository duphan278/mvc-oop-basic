-- Tạo database + bảng tối thiểu để project chạy được

CREATE DATABASE IF NOT EXISTS `watch_shop`
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE `watch_shop`;

-- Bảng users (đăng ký/đăng nhập)
CREATE TABLE IF NOT EXISTS `users` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `fullname` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `role` VARCHAR(50) NOT NULL DEFAULT 'user',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_users_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Bảng categories (thương hiệu/danh mục)
CREATE TABLE IF NOT EXISTS `categories` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Bảng products
CREATE TABLE IF NOT EXISTS `products` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `category_id` INT UNSIGNED NULL,
  `price` DECIMAL(12,2) NOT NULL DEFAULT 0,
  `description` TEXT NULL,
  `image` VARCHAR(255) NULL,
  PRIMARY KEY (`id`),
  KEY `idx_products_category_id` (`category_id`),
  CONSTRAINT `fk_products_category`
    FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`)
    ON DELETE SET NULL
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Seed dữ liệu mẫu (tùy chọn)
INSERT INTO `categories` (`name`)
SELECT * FROM (SELECT 'Default') AS tmp
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name`='Default')
LIMIT 1;

