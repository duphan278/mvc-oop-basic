<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký - Watch Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        .register-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        h2 {
            font-family: 'Playfair Display', serif;
            font-weight: 600;
            color: #2c3e50;
        }

        .btn-primary {
            background: linear-gradient(135deg, #2c3e50, #3498db);
            border: none;
            font-weight: 500;
        }
    </style>
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