<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý người dùng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <?php include(PATH_ROOT . 'views/components/navbar.php'); ?>

    <div class="d-flex" style="min-height:100vh; background-color: #f8f9fa;">
        <?php include(PATH_ROOT . 'views/admin/sidebar.php'); ?>

        <div class="container flex-grow-1 p-4">
            <div class="row">
                <div class="col-12">
                    <h1 class="mb-4 text-primary fw-bold">Trang Admin</h1>
                    
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h3 class="text-secondary mb-0">Quản lý người dùng</h3>
                    </div>
                    
                    <?php if (!empty($users)): ?>
                        <div class="table-responsive">
                            <table class="table table-hover table-striped table-bordered shadow-sm">
                                <thead class="table-dark">
                                    <tr>
                                        <th class="text-center">ID</th>
                                        <th>Họ tên</th>
                                        <th>Email</th>
                                        <th>Vai trò</th>
                                        <th class="text-center">Trạng thái</th>
                                        <th class="text-center">Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($users as $u): ?>
                                        <tr>
                                            <td class="text-center fw-bold"><?= htmlspecialchars($u['id']) ?></td>
                                            <td class="fw-semibold"><?= htmlspecialchars($u['fullname'] ?? $u['name'] ?? 'N/A') ?></td>
                                            <td><?= htmlspecialchars($u['email']) ?></td>
                                            <td>
                                                <span class="badge <?= ($u['role'] === 'admin' || $u['role'] === '1') ? 'bg-danger' : 'bg-primary' ?>">
                                                    <?= htmlspecialchars($u['role']) ?>
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <?php if (($u['status'] ?? 1) == 1): ?>
                                                    <span class="badge bg-success">Hoạt động</span>
                                                <?php else: ?>
                                                    <span class="badge bg-secondary">Bị khóa</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group">
                                                    <?php if (($u['status'] ?? 1) == 1): ?>
                                                        <a href="<?= BASE_URL ?>?controller=admin&action=disable-user&id=<?= $u['id'] ?>" class="btn btn-sm btn-outline-danger" title="Vô hiệu hóa" onclick="return confirm('Bạn có chắc chắn muốn vô hiệu hóa người dùng này?')">
                                                            <i class="fas fa-user-slash"></i> Vô hiệu hóa
                                                        </a>
                                                    <?php else: ?>
                                                        <a href="<?= BASE_URL ?>?controller=admin&action=enable-user&id=<?= $u['id'] ?>" class="btn btn-sm btn-outline-success" title="Kích hoạt">
                                                            <i class="fas fa-user-check"></i> Kích hoạt lại
                                                        </a>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info text-center">
                            <i class="fas fa-info-circle fa-2x mb-3"></i>
                            <h5>Chưa có người dùng nào.</h5>
                        </div>
                    <?php endif; ?>
                    
                    <div class="mt-4">
                        <a href="<?= BASE_URL ?>?act=admin" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Quay lại danh sách sản phẩm
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>