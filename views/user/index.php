<?php
// Đây là trang chính của user, thể hiện nhiều tùy chọn.
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chủ - Luxe Watches</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .card {
            height: 100%;
            display: flex;
            flex-direction: column;
            transition: all 0.3s;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        }
        .card-img-top {
            height: 200px;
            object-fit: cover;
            background: #f8f9fa;
        }
        .card-body {
            display: flex;
            flex-direction: column;
            padding: 15px;
        }
        .card-btn-group {
            margin-top: auto;
        }
        .card-text-price {
            color: #d0021b;
            font-weight: 700;
        }
        .card-title {
            font-size: 1rem;
            height: 2.4em;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }
    </style>
</head>
<body>
    <?php include PATH_ROOT . '/views/components/navbar.php'; ?>
    <?php
        $rolexFallbackImages = [
            'https://images.unsplash.com/photo-1523170335258-f5ed11844a49?auto=format&fit=crop&w=900&q=80',
            'https://images.unsplash.com/photo-1547996160-81dfa63595aa?auto=format&fit=crop&w=900&q=80',
            'https://images.unsplash.com/photo-1522312346375-d1a52e2b99b3?auto=format&fit=crop&w=900&q=80'
        ];
    ?>
    <div class="container mt-4">
        <h1>Chào mừng đến Luxe Watches</h1>
        <p>Chọn một hành động để tiếp tục:</p>
        <div class="row g-3">
            <div class="col-md-3">
                <a href="<?= BASE_URL ?>?controller=user&action=home&view=products" class="btn btn-primary w-100">Xem sản phẩm</a>
            </div>
            <div class="col-md-3">
                <a href="<?= BASE_URL ?>?controller=user&action=home&view=brands" class="btn btn-info w-100">Xem thương hiệu</a>
            </div>
            <div class="col-md-3">
                <a href="<?= BASE_URL ?>?controller=user&action=home&view=cart" class="btn btn-warning w-100">Xem giỏ hàng</a>
            </div>
            <div class="col-md-3">
                <a href="<?= BASE_URL ?>?controller=user&action=home&view=contact" class="btn btn-success w-100">Liên hệ</a>
            </div>
        </div>

        <hr>
        <h3>Sản phẩm nổi bật</h3>
        <div class="row">
            <?php foreach ($products as $product): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <?php $productImage = resolveProductImage($product['image'] ?? '', $rolexFallbackImages, (int)($product['id'] ?? 0)); ?>
                        <img src="<?= htmlspecialchars($productImage) ?>" class="card-img-top" alt="<?= htmlspecialchars($product['name']) ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= $product['name'] ?></h5>
                            <p class="card-text card-text-price mb-1">
                                <?= number_format($product['price'], 0, ',', '.') ?> VND
                            </p>
                            <p class="card-text text-muted small mb-3">
                                Danh mục: <?= htmlspecialchars($product['category_name'] ?? 'N/A') ?>
                            </p>
                            <div class="card-btn-group d-flex gap-2">
                                <a href="<?= BASE_URL ?>?controller=user&action=detail&id=<?= $product['id'] ?>" class="btn btn-sm btn-outline-secondary flex-grow-1"><i class="fas fa-eye me-1"></i> Chi tiết</a>
                                <a href="<?= BASE_URL ?>?controller=user&action=addToCart&id=<?= $product['id'] ?>" class="btn btn-sm btn-danger flex-grow-1"><i class="fas fa-cart-plus me-1"></i> Giỏ hàng</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <h3>Danh mục</h3>
        <div class="row">
            <?php foreach ($brands as $brand): ?>
                <div class="col-md-3 mb-3">
                    <a href="<?= BASE_URL ?>?controller=user&action=home&view=products&id=<?= $brand['id'] ?>" class="btn btn-outline-secondary w-100"><?= $brand['name'] ?></a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
