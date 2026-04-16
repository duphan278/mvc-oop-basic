<?php
require_once __DIR__ . '/commons/env.php';
require_once __DIR__ . '/commons/function.php';

try {
    $conn = connectDB();

    $stmt = $conn->prepare("SELECT id FROM categories WHERE name = :name LIMIT 1");
    $stmt->execute(['name' => 'Maserati']);
    $maseratiCategory = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$maseratiCategory) {
        $conn->prepare("INSERT INTO categories (name) VALUES (:name)")
            ->execute(['name' => 'Maserati']);
        $categoryId = (int)$conn->lastInsertId();
    } else {
        $categoryId = (int)$maseratiCategory['id'];
    }

    $products = [
        [
            'name' => 'Maserati Traguardo Chronograph R8871612031',
            'price' => 8950000,
            'description' => 'Dong ho nam phong cach the thao, day thep khong gi, may quartz ben bi.',
            'image' => 'https://images.unsplash.com/photo-1523170335258-f5ed11844a49?auto=format&fit=crop&w=1000&q=80',
        ],
        [
            'name' => 'Maserati Competizione R8853100026',
            'price' => 7650000,
            'description' => 'Thiet ke thanh lich, mat so xanh dam, phu hop phong cach doanh nhan.',
            'image' => 'https://images.unsplash.com/photo-1547996160-81dfa63595aa?auto=format&fit=crop&w=1000&q=80',
        ],
        [
            'name' => 'Maserati Sfida R8853140003',
            'price' => 7200000,
            'description' => 'Mat so den toi gian, vo thep khong gi, kha nang chong nuoc tot.',
            'image' => 'https://images.unsplash.com/photo-1522312346375-d1a52e2b99b3?auto=format&fit=crop&w=1000&q=80',
        ],
        [
            'name' => 'Maserati Successo R8871621012',
            'price' => 8350000,
            'description' => 'Bo may quartz on dinh, thiet ke da nang giua lich lam va the thao.',
            'image' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?auto=format&fit=crop&w=1000&q=80',
        ],
        [
            'name' => 'Maserati Stile R8853142004',
            'price' => 6900000,
            'description' => 'Kieu dang hien dai, de phoi do cong so, day da mem mai.',
            'image' => 'https://images.unsplash.com/photo-1539874754764-5a96559165b0?auto=format&fit=crop&w=1000&q=80',
        ],
        [
            'name' => 'Maserati Epoca R8851118006',
            'price' => 9800000,
            'description' => 'Phong cach co dien ket hop chat lieu cao cap, mat kinh ben dep.',
            'image' => 'https://images.unsplash.com/photo-1434056886845-dac89ffe9b56?auto=format&fit=crop&w=1000&q=80',
        ],
        [
            'name' => 'Maserati Potenza R8851108021',
            'price' => 9100000,
            'description' => 'Mau dong ho noi bat voi kim va coc so sang ro, sang trong va manh me.',
            'image' => 'https://images.unsplash.com/photo-1508057198894-247b23fe5ade?auto=format&fit=crop&w=1000&q=80',
        ],
        [
            'name' => 'Maserati Attrazione R8853151001',
            'price' => 7450000,
            'description' => 'Thiet ke gon gang, ton vinh phong cach nam tinh hien dai.',
            'image' => 'https://images.unsplash.com/photo-1623998021446-45f0f1312c47?auto=format&fit=crop&w=1000&q=80',
        ],
    ];

    $checkStmt = $conn->prepare("SELECT id FROM products WHERE name = :name LIMIT 1");
    $insertStmt = $conn->prepare("
        INSERT INTO products (name, category_id, price, description, image)
        VALUES (:name, :category_id, :price, :description, :image)
    ");

    $created = 0;
    foreach ($products as $product) {
        $checkStmt->execute(['name' => $product['name']]);
        if ($checkStmt->fetch(PDO::FETCH_ASSOC)) {
            continue;
        }

        $insertStmt->execute([
            'name' => $product['name'],
            'category_id' => $categoryId,
            'price' => $product['price'],
            'description' => $product['description'],
            'image' => $product['image'],
        ]);
        $created++;
    }

    echo "Seed Maserati thanh cong. Da them {$created} san pham moi.";
} catch (Throwable $e) {
    http_response_code(500);
    echo 'Loi khi seed du lieu Maserati: ' . $e->getMessage();
}

