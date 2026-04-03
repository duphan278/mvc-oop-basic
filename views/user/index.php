<?php
// Đây là trang chính của user, thể hiện nhiều tùy chọn.
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chủ - Watch Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include PATH_ROOT . '/views/components/navbar.php'; ?>
    <div class="container mt-4">
        <h1>Chào mừng đến Watch Shop</h1>
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
                        <img src="<?= BASE_URL . $product['image'] ?>" class="card-img-top" alt="<?= $product['name'] ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= $product['name'] ?></h5>
                            <p class="card-text">Giá: <?= number_format($product['price']) ?> VND</p>
                            <p class="card-text">Danh mục: <?= $product['category_name'] ?></p>
                            <a href="<?= BASE_URL ?>?controller=user&action=detail&id=<?= $product['id'] ?>" class="btn btn-sm btn-primary">Chi tiết</a>
                            <a href="<?= BASE_URL ?>?controller=user&action=addToCart&id=<?= $product['id'] ?>" class="btn btn-sm btn-success">Thêm vào giỏ</a>
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
