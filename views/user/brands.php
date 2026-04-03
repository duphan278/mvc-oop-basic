<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thương hiệu - Watch Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include PATH_ROOT . '/views/components/navbar.php'; ?>
    <div class="container mt-4">
        <h1>Danh sách thương hiệu</h1>
        <div class="row">
            <?php foreach ($brands as $brand): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?= $brand['name'] ?></h5>
                            <a href="<?= BASE_URL ?>?controller=user&action=productsByCategory&id=<?= $brand['id'] ?>" class="btn btn-primary">Xem sản phẩm</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>