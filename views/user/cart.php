<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ hàng - Luxe Watches</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f5f5f5; }
        .cart-wrap { max-width: 1200px; margin: 0 auto; }
        .cart-box { background: #fff; border: 1px solid #eee; }
        .shop-row { background: #fff; border: 1px solid #eee; }
        .product-cell { min-width: 360px; }
        .qty-box { border: 1px solid #ddd; border-radius: 4px; overflow: hidden; display: inline-flex; align-items: center; }
        .qty-btn { width: 28px; height: 28px; display: inline-flex; justify-content: center; align-items: center; text-decoration: none; color: #333; background: #fff; }
        .qty-num { width: 36px; text-align: center; border-left: 1px solid #ddd; border-right: 1px solid #ddd; font-size: 14px; }
        .price-red { color: #ee4d2d; font-weight: 600; }
        .checkout-bar { position: sticky; bottom: 0; z-index: 5; }
    </style>
</head>
<body>
    <?php include PATH_ROOT . '/views/components/navbar.php'; ?>
    <div class="container-fluid mt-3 mb-4 cart-wrap">
        <h4 class="mb-3 fw-bold">Giỏ Hàng</h4>
        <?php if (empty($cartItems)): ?>
            <div class="cart-box p-4 text-center">
                <p class="mb-3">Giỏ hàng trống.</p>
                <a href="<?= BASE_URL ?>?controller=user&action=products" class="btn btn-danger">Tiếp tục mua sắm</a>
            </div>
        <?php else: ?>
            <div class="cart-box px-3 py-2 mb-2">
                <div class="row fw-semibold text-muted small">
                    <div class="col-md-6">Sản phẩm</div>
                    <div class="col-md-2 text-center">Đơn Giá</div>
                    <div class="col-md-2 text-center">Số Lượng</div>
                    <div class="col-md-1 text-center">Số Tiền</div>
                    <div class="col-md-1 text-center">Thao Tác</div>
                </div>
            </div>

            <?php foreach ($cartItems as $item): ?>
                <div class="shop-row p-3 mb-2">
                    <div class="row align-items-center">
                        <div class="col-md-6 product-cell">
                            <div class="d-flex align-items-center gap-3">
                                <?php
                                    $img = $item['image'] ?? '';
                                    if ($img && strpos($img, 'http') === 0) {
                                        $imgSrc = $img;
                                    } elseif ($img) {
                                        $imgSrc = BASE_URL . ltrim($img, '/');
                                    } else {
                                        $imgSrc = 'https://via.placeholder.com/80x80?text=Watch';
                                    }
                                ?>
                                <img src="<?= htmlspecialchars($imgSrc) ?>" alt="<?= htmlspecialchars($item['name']) ?>" width="80" height="80" style="object-fit:cover;border:1px solid #eee;">
                                <div>
                                    <div class="fw-semibold"><?= htmlspecialchars($item['name']) ?></div>
                                    <small class="text-muted">Mã SP: #<?= (int)$item['id'] ?></small>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-2 text-center">
                            <?= number_format($item['price'], 0, ',', '.') ?>đ
                        </div>

                        <div class="col-md-2 text-center">
                            <div class="qty-box">
                                <a class="qty-btn" href="<?= BASE_URL ?>?controller=user&action=decrementCartItem&id=<?= (int)$item['id'] ?>">-</a>
                                <span class="qty-num"><?= (int)$item['quantity'] ?></span>
                                <a class="qty-btn" href="<?= BASE_URL ?>?controller=user&action=addToCart&id=<?= (int)$item['id'] ?>">+</a>
                            </div>
                        </div>

                        <div class="col-md-1 text-center price-red">
                            <?= number_format($item['subtotal'], 0, ',', '.') ?>đ
                        </div>

                        <div class="col-md-1 text-center">
                            <a href="<?= BASE_URL ?>?controller=user&action=removeCartItem&id=<?= (int)$item['id'] ?>" class="text-danger text-decoration-none">
                                Xóa
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

            <div class="cart-box p-3 mt-3 d-flex justify-content-between align-items-center checkout-bar">
                <a href="<?= BASE_URL ?>?controller=user&action=products" class="btn btn-outline-secondary">Mua thêm</a>
                <div class="d-flex align-items-center gap-3">
                    <div>
                        Tổng cộng:
                        <span class="price-red fs-5"><?= number_format($total, 0, ',', '.') ?>đ</span>
                    </div>
                    <button class="btn btn-danger px-4">Mua hàng</button>
                </div>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>