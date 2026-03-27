<div class="container login-container">
    <div class="card p-4">
        <h3 class="text-center mb-4">ĐĂNG KÝ THÀNH VIÊN</h3>
        <form action="?controller=auth&action=register" method="POST">
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
    </div>
</div>