<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm người dùng mới</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <?php include(PATH_ROOT . '/views/admin/topbar.php'); ?>

    <div class="d-flex" style="min-height:100vh; background-color: #f8f9fa;">
        <?php include(PATH_ROOT . '/views/admin/sidebar.php'); ?>

        <div class="container flex-grow-1 p-4">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card shadow-lg border-0">
                        <div class="card-header bg-success text-white">
                            <h2 class="mb-0"><i class="fas fa-user-plus"></i> Thêm người dùng mới</h2>
                        </div>
                        <div class="card-body p-4">
                            <?php if(isset($error)): ?>
                                <div class="alert alert-danger"><?= $error ?></div>
                            <?php endif; ?>

                            <form method="post" action="<?= BASE_URL ?>?controller=admin&action=create-user">
                                <div class="mb-3">
                                    <label for="fullname" class="form-label fw-bold">Họ và tên <span class="text-danger">*</span></label>
                                    <input type="text" name="fullname" id="fullname" class="form-control" required placeholder="Nhập họ tên đầy đủ" value="<?= htmlspecialchars($_POST['fullname'] ?? '') ?>">
                                </div>
                                
                                <div class="mb-3">
                                    <label for="email" class="form-label fw-bold">Email <span class="text-danger">*</span></label>
                                    <input type="email" name="email" id="email" class="form-control" required placeholder="example@gmail.com" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="password" class="form-label fw-bold">Mật khẩu <span class="text-danger">*</span></label>
                                        <input type="password" name="password" id="password" class="form-control" required placeholder="••••••••">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="role" class="form-label fw-bold">Vai trò</label>
                                        <select name="role" id="role" class="form-select">
                                            <option value="user" <?= (($_POST['role'] ?? '') == 'user') ? 'selected' : '' ?>>User (Người dùng)</option>
                                            <option value="admin" <?= (($_POST['role'] ?? '') == 'admin') ? 'selected' : '' ?>>Admin (Quản trị viên)</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="d-flex gap-2 mt-3">
                                    <button type="submit" class="btn btn-success btn-lg px-5">
                                        <i class="fas fa-save"></i> Lưu người dùng
                                    </button>
                                    <a href="<?= BASE_URL ?>?controller=admin&action=list-users" class="btn btn-secondary btn-lg">
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