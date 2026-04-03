<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ hàng - Watch Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include PATH_ROOT . '/views/components/navbar.php'; ?>
    <div class="container mt-4">
        <h1>Giỏ hàng của bạn</h1>
        <?php if (empty($cartItems)): ?>
            <p>Giỏ hàng trống.</p>
            <a href="<?= BASE_URL ?>?controller=user&action=products" class="btn btn-primary">Tiếp tục mua sắm</a>
        <?php else: ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Tên sản phẩm</th>
                        <th>Số lượng</th>
                        <th>Đơn giá</th>
                        <th>Thành tiền</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cartItems as $item): ?>
                        <tr>
                            <td><?= $item['name'] ?></td>
                            <td><?= $item['quantity'] ?></td>
                            <td><?= number_format($item['price']) ?> VND</td>
                            <td><?= number_format($item['subtotal']) ?> VND</td>
                            <td><a href="<?= BASE_URL ?>?controller=user&action=removeCartItem&id=<?= $item['id'] ?>" class="btn btn-danger btn-sm">Xóa</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="d-flex justify-content-between align-items-center">
                <h4>Tổng: <?= number_format($total) ?> VND</h4>
                <a href="<?= BASE_URL ?>?controller=user&action=products" class="btn btn-secondary">Tiếp tục mua sắm</a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>