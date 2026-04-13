<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý thương hiệu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <?php include(PATH_ROOT . '/views/admin/topbar.php'); ?>

    <div class="d-flex" style="min-height:100vh; background-color: #f8f9fa;">
        <?php include(PATH_ROOT . '/views/admin/sidebar.php'); ?>

        <div class="container-fluid flex-grow-1 p-4 admin-main">
            <h1 class="mb-4 text-primary fw-bold">Quản lý thương hiệu</h1>

            <?php if (isset($_GET['brand_message']) && $_GET['brand_message'] === 'created'): ?>
                <div class="alert alert-success">Đã thêm thương hiệu mới thành công.</div>
            <?php elseif (isset($_GET['brand_message']) && $_GET['brand_message'] === 'exists'): ?>
                <div class="alert alert-warning">Thương hiệu này đã tồn tại.</div>
            <?php elseif (isset($_GET['brand_message']) && $_GET['brand_message'] === 'empty'): ?>
                <div class="alert alert-warning">Vui lòng nhập tên thương hiệu.</div>
            <?php elseif (isset($_GET['brand_message']) && $_GET['brand_message'] === 'failed'): ?>
                <div class="alert alert-danger">Thêm thương hiệu thất bại. Vui lòng thử lại.</div>
            <?php endif; ?>

            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="fas fa-plus-circle me-1"></i> Thêm thương hiệu mới</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="<?= BASE_URL ?>?controller=admin&action=create-category" class="row g-2">
                        <div class="col-md-8">
                            <input type="text" name="name" class="form-control" placeholder="Nhập tên thương hiệu (ví dụ: Omega)" required>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-save me-1"></i> Lưu thương hiệu
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="fas fa-list me-1"></i> Danh sách thương hiệu</h5>
                </div>
                <div class="card-body p-0">
                    <?php if (!empty($brands)): ?>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover mb-0">
                                <thead class="table-dark">
                                    <tr>
                                        <th style="width: 120px;">ID</th>
                                        <th>Tên thương hiệu</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($brands as $brand): ?>
                                        <tr>
                                            <td>#<?= (int)($brand['id'] ?? 0) ?></td>
                                            <td><?= htmlspecialchars($brand['name'] ?? '') ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="p-3 text-muted">Chưa có thương hiệu nào.</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
