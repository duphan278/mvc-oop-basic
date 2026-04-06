<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách yêu thích - Luxe Watches</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --text-primary: #1a1a1a;
            --text-secondary: #6c757d;
            --text-muted: #8e8e93;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            line-height: 1.7;
            color: var(--text-primary);
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Playfair Display', serif;
            font-weight: 600;
            line-height: 1.3;
            letter-spacing: -0.02em;
        }

        .card-title {
            font-family: 'Playfair Display', serif;
            font-weight: 600;
        }

        .btn {
            font-weight: 500;
            border-radius: 8px;
        }

        .empty-wishlist h4 {
            color: var(--text-secondary);
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background: #f5f5f5; }
        .wishlist-wrap { max-width: 1200px; margin: 0 auto; }
        .wishlist-item {
            background: #fff;
            border: 1px solid #eee;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 15px;
            transition: box-shadow 0.3s;
        }
        .wishlist-item:hover {
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .product-image {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 8px;
        }
        .product-price {
            color: #d0021b;
            font-weight: 700;
            font-size: 1.1rem;
        }
        .empty-wishlist {
            text-align: center;
            padding: 60px 20px;
            background: #fff;
            border-radius: 8px;
            border: 1px solid #eee;
        }
        .wishlist-actions {
            display: flex;
            gap: 10px;
            align-items: center;
        }
    </style>
</head>
<body>
    <?php include PATH_ROOT . '/views/components/navbar.php'; ?>
    <div class="container-fluid mt-4 mb-4 wishlist-wrap">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="mb-0">
                <i class="fas fa-heart text-danger me-2"></i>
                Danh sách yêu thích của tôi
            </h3>
            <span class="badge bg-danger fs-6">
                <?= count($wishlistItems) ?> sản phẩm
            </span>
        </div>

        <?php if (empty($wishlistItems)): ?>
            <div class="empty-wishlist">
                <i class="fas fa-heart-broken text-muted" style="font-size: 64px; margin-bottom: 20px;"></i>
                <h4 class="text-muted">Danh sách yêu thích trống</h4>
                <p class="text-muted mb-4">Hãy thêm các sản phẩm bạn yêu thích vào đây để dễ dàng theo dõi và mua sắm.</p>
                <a href="<?= BASE_URL ?>?controller=user&action=products" class="btn btn-danger btn-lg">
                    <i class="fas fa-shopping-bag me-2"></i>
                    Khám phá sản phẩm
                </a>
            </div>
        <?php else: ?>
            <div class="row">
                <?php foreach ($wishlistItems as $item): ?>
                    <div class="col-12">
                        <div class="wishlist-item">
                            <div class="row align-items-center">
                                <div class="col-md-2">
                                    <?php
                                        $img = $item['image'] ?? '';
                                        if ($img && strpos($img, 'http') === 0) {
                                            $imgSrc = $img;
                                        } elseif ($img) {
                                            $imgSrc = BASE_URL . ltrim($img, '/');
                                        } else {
                                            $imgSrc = 'https://via.placeholder.com/120x120?text=Watch';
                                        }
                                    ?>
                                    <img src="<?= htmlspecialchars($imgSrc) ?>" alt="<?= htmlspecialchars($item['name']) ?>" class="product-image">
                                </div>
                                <div class="col-md-6">
                                    <h5 class="mb-1">
                                        <a href="<?= BASE_URL ?>?controller=user&action=detail&id=<?= $item['id'] ?>" class="text-decoration-none text-dark">
                                            <?= htmlspecialchars($item['name']) ?>
                                        </a>
                                    </h5>
                                    <p class="text-muted mb-2 small">
                                        Danh mục: <?= htmlspecialchars($item['category_name'] ?? 'N/A') ?>
                                    </p>
                                    <p class="mb-0 text-muted small">
                                        <?= htmlspecialchars(substr($item['description'] ?? '', 0, 150)) ?>...
                                    </p>
                                    <small class="text-muted">
                                        Đã thêm: <?= date('d/m/Y H:i', strtotime($item['created_at'])) ?>
                                    </small>
                                </div>
                                <div class="col-md-2 text-center">
                                    <div class="product-price">
                                        <?= number_format($item['price'], 0, ',', '.') ?>đ
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="wishlist-actions">
                                        <a href="<?= BASE_URL ?>?controller=user&action=detail&id=<?= $item['id'] ?>" class="btn btn-outline-primary btn-sm">
                                            <i class="fas fa-eye me-1"></i>
                                            Xem
                                        </a>
                                        <a href="<?= BASE_URL ?>?controller=user&action=addToCart&id=<?= $item['id'] ?>" class="btn btn-danger btn-sm">
                                            <i class="fas fa-cart-plus me-1"></i>
                                            Mua
                                        </a>
                                        <button type="button" class="btn btn-outline-danger btn-sm remove-wishlist" data-product-id="<?= $item['id'] ?>">
                                            <i class="fas fa-trash me-1"></i>
                                            Xóa
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Xử lý xóa khỏi wishlist
        document.querySelectorAll('.remove-wishlist').forEach(button => {
            button.addEventListener('click', function() {
                const productId = this.getAttribute('data-product-id');
                const itemElement = this.closest('.wishlist-item');

                if (confirm('Bạn có chắc muốn xóa sản phẩm này khỏi danh sách yêu thích?')) {
                    fetch('<?= BASE_URL ?>?controller=user&action=remove-from-wishlist', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: 'product_id=' + productId
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Xóa element khỏi DOM
                            itemElement.remove();
                            // Cập nhật số lượng
                            const badge = document.querySelector('.badge');
                            if (badge) {
                                const currentCount = parseInt(badge.textContent);
                                badge.textContent = (currentCount - 1) + ' sản phẩm';
                            }
                            // Reload nếu hết sản phẩm
                            if (document.querySelectorAll('.wishlist-item').length === 0) {
                                location.reload();
                            }
                        } else {
                            alert('Có lỗi xảy ra: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Có lỗi xảy ra khi xóa sản phẩm');
                    });
                }
            });
        });
    });
    </script>
</body>
</html>