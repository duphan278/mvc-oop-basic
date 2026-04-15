<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý người dùng</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Playfair Display', serif;
            font-weight: 600;
        }

        .card-title {
            font-family: 'Playfair Display', serif;
            font-weight: 500;
        }
    </style>
</head>
<body>
    <?php include(PATH_ROOT . '/views/admin/topbar.php'); ?>

    <div class="d-flex" style="min-height:100vh; background-color: #f8f9fa;">
        <?php include(PATH_ROOT . '/views/admin/sidebar.php'); ?>

        <div class="container-fluid flex-grow-1 p-4 admin-main">
            <div class="row">
                <div class="col-12">
                    <h1 class="mb-4 text-primary fw-bold">Quản lý người dùng</h1>
                    
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h3 class="text-secondary mb-0">Danh sách tài khoản</h3>
                    </div>
                    
                    <?php if (!empty($users)): ?>
                        <div class="table-responsive">
                            <table class="table table-hover table-striped table-bordered shadow-sm">
                                <thead class="table-dark">
                                    <tr>
                                        <th class="text-center">ID</th>
                                        <th>Họ tên</th>
                                        <th>Email</th>
                                        <th>SĐT</th>
                                        <th>Ngày sinh</th>
                                        <th>Quê quán</th>
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
                                            <td><?= htmlspecialchars($u['phone'] ?? '—') ?></td>
                                            <td><?= htmlspecialchars($u['birth_date'] ?? '—') ?></td>
                                            <td><?= htmlspecialchars($u['hometown'] ?? '—') ?></td>
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
                                                    <a href="<?= BASE_URL ?>?controller=admin&action=edit-user&id=<?= $u['id'] ?>" class="btn btn-sm btn-outline-primary" title="Sửa thông tin">
                                                        <i class="fas fa-user-edit"></i> Sửa
                                                    </a>
                                                    <?php if (($u['status'] ?? 1) == 1): ?>
                                                        <a href="<?= BASE_URL ?>?controller=admin&action=disable-user&id=<?= $u['id'] ?>" class="btn btn-sm btn-outline-danger" title="Vô hiệu hóa" onclick="return confirm('Bạn có chắc chắn muốn vô hiệu hóa người dùng này?')">
                                                            <i class="fas fa-user-slash"></i> Vô hiệu hóa
                                                        </a>
                                                    <?php else: ?>
                                                        <a href="<?= BASE_URL ?>?controller=admin&action=enable-user&id=<?= $u['id'] ?>" class="btn btn-sm btn-outline-success" title="Kích hoạt">
                                                            <i class="fas fa-user-check"></i> Kích hoạt lại
                                                        </a>
                                                    <?php endif; ?>
                                                    <?php if ((int)$u['id'] !== (int)($_SESSION['user']['id'] ?? 0)): ?>
                                                        <a href="<?= BASE_URL ?>?controller=admin&action=delete-user&id=<?= $u['id'] ?>" class="btn btn-sm btn-outline-dark" title="Xóa người dùng" onclick="return confirm('Bạn có chắc chắn muốn xóa người dùng này? Hành động này không thể hoàn tác.')">
                                                            <i class="fas fa-trash"></i> Xóa
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