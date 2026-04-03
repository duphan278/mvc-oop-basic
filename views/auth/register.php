<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký - Watch Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .login-container { max-width: 400px; margin-top: 60px; }
        .card { border: none; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        .btn-success { background-color: #2e7d32; border: none; }
        .btn-success:hover { background-color: #256628; }
    </style>
</head>
<body>
<?php include PATH_ROOT . '/views/components/navbar.php'; ?>
<div class="container login-container">
    <div class="card p-4">
        <h3 class="text-center mb-4">ĐĂNG KÝ THÀNH VIÊN</h3>

        <form action="<?= BASE_URL ?>?controller=auth&action=register" method="POST">
            <div class="mb-3">
                <label class="form-label">Họ và tên</label>
                <input type="text" name="fullname" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Mật khẩu</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <?php if (isset($errorMessage) && $errorMessage): ?>
                <div class="alert alert-danger text-center mt-2"><?= htmlspecialchars($errorMessage) ?></div>
            <?php endif; ?>

            <button type="submit" class="btn btn-success w-100 py-2">Tạo Tài Khoản</button>
        </form>

        <div class="text-center mt-3">
            <small>
                Đã có tài khoản?
                <a href="<?= BASE_URL ?>?controller=auth&action=loginPage">Đăng nhập</a>
            </small>
        </div>
    </div>
</div>
</body>
</html>