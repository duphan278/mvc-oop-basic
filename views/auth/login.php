<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập - Watch Store</title>
</head>
<body>

<div class="container login-container">
    <div class="card p-4">
        <h3 class="text-center mb-4">ĐĂNG NHẬP</h3>
        
        <?php if (isset($errorMessage) && $errorMessage): ?>
            <div class="alert alert-danger text-center"><?= htmlspecialchars($errorMessage) ?></div>
        <?php endif; ?>

        <form action="?controller=auth&action=login" method="POST">
            <div class="mb-3">
                <label class="form-label">Email của bạn</label>
                <input type="email" name="email" class="form-control" placeholder="admin@gmail.com" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Mật khẩu</label>
                <input type="password" name="password" class="form-control" placeholder="••••••••" required>
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="remember">
                <label class="form-check-label" for="remember">Ghi nhớ đăng nhập</label>
            </div>
            <button type="submit" class="btn btn-primary w-100 py-2">Đăng Nhập</button>
        </form>
        
        <div class="text-center mt-3">
            <small>Chưa có tài khoản? <a href="?controller=auth&action=registerPage">Đăng ký ngay</a></small>
            <div class="mt-2">
                <a href="?controller=auth&action=registerPage" class="btn btn-outline-success btn-sm">Đăng ký</a>
            </div>
        </div>
    </div>
</div>

</body>
</html>