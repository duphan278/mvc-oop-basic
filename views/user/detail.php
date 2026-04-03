<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết sản phẩm - Luxe Watches</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include PATH_ROOT . '/views/components/navbar.php'; ?>
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-6">
                <img src="<?= BASE_URL . $product['image'] ?>" class="img-fluid" alt="<?= $product['name'] ?>">
            </div>
            <div class="col-md-6">
                <h1><?= $product['name'] ?></h1>
                <p class="text-muted">Danh mục: <?= $product['category_name'] ?></p>
                <h3 class="text-primary">Giá: <?= number_format($product['price']) ?> VND</h3>
                <p><?= $product['description'] ?></p>
                <a href="<?= BASE_URL ?>?controller=user&action=addToCart&id=<?= $product['id'] ?>" class="btn btn-success">Thêm vào giỏ hàng</a>
                <a href="<?= BASE_URL ?>?controller=user&action=products" class="btn btn-secondary">Quay lại</a>
            </div>
        </div>
    </div>
</body>
</html>