<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập - Watch Store</title>
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

        .login-container {
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
        .login-container { max-width: 400px; margin-top: 100px; }
        .card { border: none; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        .btn-primary { background-color: #333; border: none; }
        .btn-primary:hover { background-color: #555; }
    </style>
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