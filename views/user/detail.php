<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết sản phẩm - Luxe Watches</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --accent-gold: #b8860b;
            --text-primary: #1a1a1a;
            --light-gray: #f8f9fa;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            line-height: 1.7;
            color: var(--text-primary);
            background-color: #fff;
        }

        .detail-container {
            padding: 60px 0;
        }

        h1 {
            font-family: 'Playfair Display', serif;
            font-weight: 600;
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
            color: var(--primary-color);
        }

        .category-label {
            text-transform: uppercase;
            letter-spacing: 2px;
            font-size: 0.85rem;
            color: #888;
            margin-bottom: 1.5rem;
            display: block;
        }

        .product-image-wrapper {
            overflow: hidden;
            border-radius: 12px;
            background: var(--light-gray);
            transition: all 0.5s ease;
        }

        .product-image-wrapper img {
            transition: transform 0.5s ease;
            mix-blend-mode: multiply;
        }

        .product-image-wrapper:hover img {
            transform: scale(1.05);
        }

        .price-display {
            font-size: 1.8rem;
            font-weight: 700;
            color: #d0021b;
            margin: 1.5rem 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .description-box {
            background: var(--light-gray);
            padding: 20px;
            border-radius: 8px;
            border-left: 4px solid var(--primary-color);
            margin-bottom: 2rem;
        }

        .action-group {
            display: flex;
            gap: 15px;
            margin-top: 2rem;
        }

        .btn {
            font-weight: 500;
            border-radius: 8px;
            padding: 12px 25px;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 0.9rem;
        }

        .btn-cart {
            background-color: var(--primary-color);
            color: white;
            flex: 2;
        }

        .btn-cart:hover {
            background-color: #1a252f;
            color: white;
            text-decoration: none;
            transform: translateY(-2px);
        }

        .btn-wishlist {
            flex: 1;
        }

        .back-to-list {
            display: inline-flex;
            align-items: center;
            margin-top: 30px;
            color: #6c757d;
            transition: all 0.3s ease;
        }
        .back-to-list:hover {
            color: var(--primary-color);
            transform: translateX(-5px);
        }
    </style>
</head>
<body>
    <?php include PATH_ROOT . '/views/components/navbar.php'; ?>
    <div class="container detail-container">
        <div class="row">
            <div class="col-md-6 mb-4 mb-md-0">
                <div class="product-image-wrapper shadow-sm">
                <?php if (!empty($product['image']) && file_exists(PATH_ROOT . '/uploads/' . $product['image'])): ?>
                    <img src="<?= BASE_URL ?>/uploads/<?= htmlspecialchars($product['image']) ?>" class="img-fluid" alt="<?= htmlspecialchars($product['name']) ?>">
                <?php else: ?>
                    <img src="<?= BASE_URL ?>/public/images/no-image.svg" class="img-fluid" alt="No image available">
                <?php endif; ?>
                </div>
            </div>
            <div class="col-md-6">
                <span class="category-label"><?= htmlspecialchars($product['category_name']) ?></span>
                <h1><?= $product['name'] ?></h1>
                <div class="price-display">
                    <?= number_format($product['price'], 0, ',', '.') ?> <small style="font-size: 1rem;">VND</small>
                </div>
                <div class="description-box">
                    <p class="mb-0 text-muted"><?= nl2br(htmlspecialchars($product['description'])) ?></p>
                </div>
                <div class="action-group mb-4">
                    <a href="<?= BASE_URL ?>?controller=user&action=addToCart&id=<?= $product['id'] ?>" class="btn btn-cart">
                        <i class="fas fa-cart-plus me-1"></i>Thêm vào giỏ hàng
                    </a>
                    <?php if (isset($_SESSION['user'])): ?>
                        <?php
                        $isInWishlist = isset($wishlist) && $wishlist->isInWishlist($_SESSION['user']['id'], $product['id']);
                        ?>
                        <button type="button" class="btn <?= $isInWishlist ? 'btn-danger' : 'btn-outline-danger' ?> btn-wishlist wishlist-btn"
                                data-product-id="<?= $product['id'] ?>" data-in-wishlist="<?= $isInWishlist ? '1' : '0' ?>">
                            <i class="fas fa-heart me-1"></i>
                            <span class="wishlist-text">
                                <?= $isInWishlist ? 'Đã yêu thích' : 'Yêu thích' ?>
                            </span>
                        </button>
                    <?php endif; ?>
                </div>
                <a href="<?= BASE_URL ?>?controller=user&action=products" class="text-decoration-none back-to-list small fw-medium">
                    <i class="fas fa-long-arrow-alt-left me-1"></i> Quay lại danh sách sản phẩm
                </a>
            </div>
        </div>
    </div>
</body>
</html>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const wishlistBtn = document.querySelector('.wishlist-btn');
    if (wishlistBtn) {
        wishlistBtn.addEventListener('click', function() {
            const productId = this.getAttribute('data-product-id');
            const isInWishlist = this.getAttribute('data-in-wishlist') === '1';
            const action = isInWishlist ? 'remove-from-wishlist' : 'add-to-wishlist';

            fetch('<?= BASE_URL ?>?controller=user&action=' + action, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'product_id=' + productId
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    if (isInWishlist) {
                        // Đã xóa khỏi wishlist
                        wishlistBtn.classList.remove('btn-danger');
                        wishlistBtn.classList.add('btn-outline-danger');
                        wishlistBtn.setAttribute('data-in-wishlist', '0');
                        wishlistBtn.querySelector('.wishlist-text').textContent = 'Yêu thích';
                    } else {
                        // Đã thêm vào wishlist
                        wishlistBtn.classList.remove('btn-outline-danger');
                        wishlistBtn.classList.add('btn-danger');
                        wishlistBtn.setAttribute('data-in-wishlist', '1');
                        wishlistBtn.querySelector('.wishlist-text').textContent = 'Đã yêu thích';
                    }
                } else {
                    alert('Có lỗi xảy ra: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Có lỗi xảy ra khi cập nhật danh sách yêu thích');
            });
        });
    }
});
</script>