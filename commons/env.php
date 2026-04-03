<?php

// Biến môi trường, dùng chung toàn hệ thống
// Khai báo dưới dạng HẰNG SỐ để không phải dùng $GLOBALS

// Tự nhận BASE_URL theo thư mục project để tránh sai đường dẫn khi đổi tên folder.
if (!defined('BASE_URL')) {
    $isHttps = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';
    $scheme = $isHttps ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
    $script = $_SERVER['SCRIPT_NAME'] ?? '/index.php';
    $basePath = rtrim(str_replace(basename($script), '', $script), '/');
    $basePath = $basePath === '' ? '' : $basePath;
    define('BASE_URL', $scheme . '://' . $host . $basePath . '/');
}

if (!defined('BASE_URL_ADMIN')) {
    define('BASE_URL_ADMIN', BASE_URL . 'admin/');
}

define('DB_HOST', 'localhost');
define('DB_PORT', 3306);
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'watch_shop');

define('PATH_ROOT', __DIR__ . '/../');
