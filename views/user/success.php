<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt hàng thành công - Luxe Watches</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f5f5f5; }
        .success-wrap { max-width: 600px; margin: 50px auto; text-align: center; }
        .success-box { background: #fff; border: 1px solid #eee; padding: 40px; border-radius: 8px; }
        .success-icon { font-size: 64px; color: #28a745; margin-bottom: 20px; }
    </style>
</head>
<body>
    <?php include PATH_ROOT . '/views/components/navbar.php'; ?>
    <div class="container-fluid success-wrap">
        <div class="success-box">
            <div class="success-icon">✓</div>
            <h2 class="mb-3">Đặt hàng thành công!</h2>
            <p class="mb-4">Cảm ơn bạn đã đặt hàng tại Luxe Watches. Chúng tôi sẽ xử lý đơn hàng của bạn trong thời gian sớm nhất.</p>
            <p class="text-muted mb-4">Mã đơn hàng: #<?= htmlspecialchars($orderId ?? 'N/A') ?></p>
            <a href="<?= BASE_URL ?>?controller=user&action=products" class="btn btn-danger px-4">Quay lại cửa hàng</a>
        </div>
    </div>
</body>
</html>