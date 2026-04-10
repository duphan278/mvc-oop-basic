<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký - Watch Store</title>
    <style>
        .register-container {
            max-width: 980px;
            margin: 36px auto;
        }
        .register-card {
            border-radius: 14px;
        }
        @media (max-width: 991px) {
            .register-container {
                max-width: 680px;
            }
        }
    </style>
</head>
<body>
<div class="container register-container">
    <div class="card p-4 register-card">
        <h3 class="text-center mb-4">ĐĂNG KÝ THÀNH VIÊN</h3>

        <form action="<?= BASE_URL ?>?controller=auth&action=register" method="POST">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Họ và tên</label>
                    <input type="text" name="fullname" class="form-control" required autocomplete="name" value="<?= htmlspecialchars($_POST['fullname'] ?? '') ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" required autocomplete="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Mật khẩu</label>
                    <input type="password" name="password" class="form-control" required autocomplete="new-password">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Số điện thoại</label>
                    <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Ngày tháng năm sinh</label>
                    <input type="date" name="birth_date" class="form-control" value="<?= htmlspecialchars($_POST['birth_date'] ?? '') ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Quê quán</label>
                    <input type="text" name="hometown" class="form-control" value="<?= htmlspecialchars($_POST['hometown'] ?? '') ?>">
                </div>
                <div class="col-12">
                    <label class="form-label">Địa chỉ</label>
                    <textarea name="address" class="form-control" rows="2"><?= htmlspecialchars($_POST['address'] ?? '') ?></textarea>
                </div>
            </div>

            <?php if (isset($errorMessage) && $errorMessage): ?>
                <div class="alert alert-danger text-center mt-2"><?= htmlspecialchars($errorMessage) ?></div>
            <?php endif; ?>

            <button type="submit" class="btn btn-success w-100 py-2 mt-3">Tạo Tài Khoản</button>
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