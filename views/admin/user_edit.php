<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa thông tin người dùng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <?php include(PATH_ROOT . '/views/admin/topbar.php'); ?>

    <div class="d-flex" style="min-height:100vh; background-color: #f8f9fa;">
        <?php include(PATH_ROOT . '/views/admin/sidebar.php'); ?>

        <div class="container-fluid flex-grow-1 p-4 admin-main">
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-lg border-0 admin-fill-card">
                        <div class="card-header bg-primary text-white">
                            <h2 class="mb-0"><i class="fas fa-user-edit me-2"></i>Sửa thông tin người dùng</h2>
                        </div>
                        <div class="card-body p-4 p-lg-5">
                            <?php if (!empty($error)): ?>
                                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                            <?php endif; ?>
                            <form method="post" action="<?= BASE_URL ?>?controller=admin&action=edit-user&id=<?= (int)$user['id'] ?>">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Họ và tên <span class="text-danger">*</span></label>
                                        <input type="text" name="fullname" class="form-control" required value="<?= htmlspecialchars($_POST['fullname'] ?? $user['fullname'] ?? '') ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Email <span class="text-danger">*</span></label>
                                        <input type="email" name="email" class="form-control" required value="<?= htmlspecialchars($_POST['email'] ?? $user['email'] ?? '') ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Số điện thoại</label>
                                        <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($_POST['phone'] ?? ($user['phone'] ?? '')) ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Ngày tháng năm sinh</label>
                                        <input type="date" name="birth_date" class="form-control" value="<?= htmlspecialchars($_POST['birth_date'] ?? ($user['birth_date'] ?? '')) ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Quê quán</label>
                                        <input type="text" name="hometown" class="form-control" value="<?= htmlspecialchars($_POST['hometown'] ?? ($user['hometown'] ?? '')) ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Vai trò</label>
                                        <?php $selectedRole = $_POST['role'] ?? ($user['role'] ?? 'user'); ?>
                                        <select name="role" class="form-select">
                                            <option value="user" <?= $selectedRole === 'user' ? 'selected' : '' ?>>User</option>
                                            <option value="admin" <?= $selectedRole === 'admin' ? 'selected' : '' ?>>Admin</option>
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label fw-bold">Địa chỉ</label>
                                        <textarea name="address" class="form-control" rows="3"><?= htmlspecialchars($_POST['address'] ?? ($user['address'] ?? '')) ?></textarea>
                                    </div>
                                </div>

                                <div class="d-flex gap-2 mt-4">
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-save me-1"></i>Lưu thay đổi
                                    </button>
                                    <a href="<?= BASE_URL ?>?controller=admin&action=list-users" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left me-1"></i>Quay lại
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
