<?php

// Hỗ trợ show bất kỳ data nào
function debug($data)
{
    echo "<pre>";

    print_r($data);

    die;
}

// Kết nối CSDL qua PDO
function connectDB() {
    // Kết nối CSDL
    $host = DB_HOST;
    $port = DB_PORT;
    $dbname = DB_NAME;

    try {
        $conn = new PDO("mysql:host=$host;port=$port;dbname=$dbname", DB_USERNAME, DB_PASSWORD);

        // cài đặt chế độ báo lỗi là xử lý ngoại lệ
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // cài đặt chế độ trả dữ liệu
        $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
        return $conn;
    } catch (PDOException $e) {
        debug("Connection failed: " . $e->getMessage());
    }
}
function checkAdmin() {
    if (!isset($_SESSION['user']) || !in_array($_SESSION['user']['role'], ['admin', 'administrator', '1'])) {
        header('Location: ' . BASE_URL . '?controller=auth&action=loginPage');
        exit();
    }
}

function checkUser() {
    if (!isset($_SESSION['user'])) {
        header('Location: ' . BASE_URL . '?controller=auth&action=loginPage');
        exit();
    }
}

function resolveProductImage(?string $image, array $fallbackImages = [], int $seed = 0): string
{
    $defaultFallback = 'https://images.unsplash.com/photo-1523170335258-f5ed11844a49?auto=format&fit=crop&w=900&q=80';
    $fallbacks = !empty($fallbackImages) ? array_values($fallbackImages) : [$defaultFallback];
    $pickFallback = $fallbacks[abs($seed) % count($fallbacks)];

    if (empty($image)) {
        return $pickFallback;
    }

    $image = trim($image);
    if ($image === '') {
        return $pickFallback;
    }

    if (filter_var($image, FILTER_VALIDATE_URL)) {
        $parts = parse_url($image);
        $host = strtolower($parts['host'] ?? '');
        $path = strtolower($parts['path'] ?? '');
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        $isImageByExt = in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg', 'avif'], true);
        $isImageHost = in_array($host, ['images.unsplash.com', 'images.pexels.com', 'i.imgur.com', 'res.cloudinary.com'], true);
        if ($isImageByExt || $isImageHost) {
            return $image;
        }
        return $pickFallback;
    }

    $localPath = PATH_ROOT . '/uploads/' . $image;
    if (file_exists($localPath)) {
        return BASE_URL . '/uploads/' . rawurlencode($image);
    }

    return $pickFallback;
}