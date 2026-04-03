<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa sản phẩm</title>
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
                        <div class="card-header bg-warning text-dark">
                            <h2 class="mb-0"><i class="fas fa-edit"></i> Chỉnh sửa sản phẩm</h2>
                        </div>
                        <div class="card-body p-4">
                            <form method="post" action="<?= BASE_URL ?>?controller=admin&action=edit&id=<?= $product['id'] ?>">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="name" class="form-label fw-bold">Tên sản phẩm <span class="text-danger">*</span></label>
                                        <input type="text" name="name" id="name" class="form-control" required value="<?= htmlspecialchars($product['name'] ?? '') ?>">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="category_id" class="form-label fw-bold">Thương hiệu</label>
                                        <input type="number" name="category_id" id="category_id" class="form-control" value="<?= htmlspecialchars($product['category_id'] ?? '') ?>" placeholder="ID thương hiệu">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="price" class="form-label fw-bold">Giá (VNĐ) <span class="text-danger">*</span></label>
                                        <input type="number" step="0.01" name="price" id="price" class="form-control" required value="<?= htmlspecialchars($product['price'] ?? '') ?>">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="image" class="form-label fw-bold">Ảnh sản phẩm</label>
                                        <input type="text" name="image" id="image" class="form-control" value="<?= htmlspecialchars($product['image'] ?? '') ?>" placeholder="Tên file ảnh">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="description" class="form-label fw-bold">Mô tả sản phẩm</label>
                                    <textarea name="description" id="description" class="form-control" rows="4"><?= htmlspecialchars($product['description'] ?? '') ?></textarea>
                                </div>
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-success btn-lg">
                                        <i class="fas fa-save"></i> Cập nhật
                                    </button>
                                    <a href="<?= BASE_URL ?>?act=admin" class="btn btn-secondary btn-lg">
                                        <i class="fas fa-arrow-left"></i> Quay lại
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>