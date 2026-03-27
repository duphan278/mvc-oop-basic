<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết sản phẩm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <?php include(PATH_ROOT . 'views/components/navbar.php'); ?>

    <div class="d-flex" style="min-height:100vh; background-color: #f8f9fa;">
        <?php include(PATH_ROOT . 'views/admin/sidebar.php'); ?>

        <div class="container flex-grow-1 p-4">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card shadow-lg border-0">
                        <div class="card-header bg-info text-white">
                            <h2 class="mb-0"><i class="fas fa-eye"></i> Chi tiết sản phẩm</h2>
                        </div>
                        <div class="card-body p-4">
                            <div class="row">
                                <div class="col-md-8">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td class="fw-bold" style="width: 150px;"><i class="fas fa-hashtag text-primary"></i> ID:</td>
                                            <td><?= htmlspecialchars($product['id']) ?></td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold"><i class="fas fa-tag text-primary"></i> Tên sản phẩm:</td>
                                            <td class="fw-semibold"><?= htmlspecialchars($product['name']) ?></td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold"><i class="fas fa-building text-primary"></i> Thương hiệu:</td>
                                            <td><?= htmlspecialchars($product['category_name'] ?? 'N/A') ?></td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold"><i class="fas fa-dollar-sign text-success"></i> Giá:</td>
                                            <td class="text-success fw-bold fs-5"><?= htmlspecialchars(number_format($product['price'], 0, ',', '.')) ?> VNĐ</td>
                                        </tr>
                                      
                                    </table>
                                </div>
                                <div class="col-md-4 text-center">
                                    <?php if (!empty($product['image'])): ?>
                                        <div class="mb-3">
                                            <img src="/uploads/<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="img-fluid rounded shadow" style="max-width: 200px;" />
                                        </div>
                                    <?php else: ?>
                                        <div class="bg-light p-4 rounded">
                                            <i class="fas fa-image fa-3x text-muted"></i>
                                            <p class="text-muted mt-2">Không có ảnh</p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="mt-4">
                                <h5 class="fw-bold"><i class="fas fa-file-alt text-primary"></i> Mô tả sản phẩm:</h5>
                                <div class="border rounded p-3 bg-light">
                                    <?= nl2br(htmlspecialchars($product['description'] ?? 'Không có mô tả')) ?>
                                </div>
                            </div>
                            <div class="d-flex gap-2 mt-4">
                                <a href="<?= BASE_URL ?>?controller=admin&action=edit&id=<?= $product['id'] ?>" class="btn btn-warning">
                                    <i class="fas fa-edit"></i> Chỉnh sửa
                                </a>
                                <a href="<?= BASE_URL ?>?act=admin" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Quay lại danh sách
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>