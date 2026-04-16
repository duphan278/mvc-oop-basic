<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thương hiệu - Luxe Watches</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include PATH_ROOT . '/views/components/navbar.php'; ?>
    <div class="container mt-4">
        <h1>Danh sách thương hiệu</h1>
        <div class="row">
            <?php if (empty($brands)): ?>
                <div class="col-12">
                    <div class="alert alert-warning">Hiện chưa có danh mục nào có sản phẩm.</div>
                </div>
            <?php else: ?>
                <?php foreach ($brands as $brand): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($brand['name'] ?? '') ?></h5>
                                <a href="<?= BASE_URL ?>?controller=user&action=products&id=<?= (int)($brand['id'] ?? 0) ?>" class="btn btn-primary">Xem sản phẩm</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>