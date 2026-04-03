<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Luxe Watches - Đồng hồ chính hãng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --accent-color: #e74c3c;
            --light-bg: #f8f9fa;
        }

        body {
            font-family: 'Roboto', sans-serif;
            line-height: 1.6;
        }

        .product-grid-item {
            border: 1px solid #eee;
            background: #fff;
            padding: 10px;
            height: 100%;
        }
        .product-grid-item img {
            width: 100%;
            height: 220px;
            object-fit: cover;
        }
        .product-name {
            font-size: 0.95rem;
            min-height: 42px;
        }
        .product-price {
            color: #d0021b;
            font-weight: 700;
        }
        .product-meta {
            font-size: 0.8rem;
            color: #666;
        }
        .content-wrap {
            max-width: 1220px;
            margin: 0 auto;
        }
        .hero-banner {
            border-radius: 14px;
            border: 1px solid #2a2a2a;
            background: linear-gradient(135deg, #0f0f10 0%, #1b1b1d 60%, #2a230f 100%);
            color: #fff;
            overflow: hidden;
        }
        .hero-watch {
            height: 145px;
            width: 100%;
            object-fit: cover;
            border-radius: 10px;
            border: 1px solid rgba(255,255,255,0.1);
        }
        .hero-right {
            background: transparent;
            border: 0;
            border-radius: 0;
            padding: 0;
        }
        .hero-logo {
            width: 100%;
            max-height: 170px;
            object-fit: contain;
        }
        .hero-title {
            font-family: 'Playfair Display', serif;
            color: #f5c400;
            font-size: 1.45rem;
            font-weight: 700;
            margin-bottom: 4px;
        }
        .hero-subtitle {
            color: #cfcfcf;
            margin-bottom: 0;
            font-size: 0.92rem;
        }

        .section-title {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 3rem;
            position: relative;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 50px;
            height: 3px;
            background: var(--secondary-color);
        }

        .footer {
            background: var(--primary-color);
            color: white;
            padding: 3rem 0 1rem;
        }

        .social-links a {
            color: white;
            margin: 0 10px;
            font-size: 1.5rem;
            transition: color 0.3s ease;
        }

        .social-links a:hover {
            color: var(--secondary-color);
        }

        @media (max-width: 768px) {
            .hero-watch {
                height: 120px;
            }
            .hero-title {
                font-size: 1.2rem;
            }
        }
    </style>
</head>
<body>
    <?php include PATH_ROOT . '/views/components/navbar.php'; ?>

    <div class="container-fluid mt-3">
        <div class="content-wrap">
        <?php
            $categories = (new Category())->getAll();
            $currentCat = $_GET['id'] ?? '';
        ?>

        <!-- Banner -->
        <section class="mb-2 p-2 hero-banner">
            <div class="row align-items-center g-2">
                <div class="col-lg-8">
                    <h2 class="hero-title">Luxe Watches</h2>
                    <p class="hero-subtitle">Tinh hoa đồng hồ cao cấp, thiết kế sang trọng và đẳng cấp doanh nhân.</p>
                    <div class="d-flex mt-2" style="gap:6px;">
                        <img class="hero-watch"
                             style="width: 33.33%;"
                             src="https://images.unsplash.com/photo-1524592094714-0f0654e20314?auto=format&fit=crop&w=600&q=80"
                             alt="Watch 1">
                        <img class="hero-watch"
                             style="width: 33.33%;"
                             src="https://images.unsplash.com/photo-1523275335684-37898b6baf30?auto=format&fit=crop&w=600&q=80"
                             alt="Watch 2">
                        <img class="hero-watch"
                             style="width: 33.33%;"
                             src="https://images.unsplash.com/photo-1509042239860-f550ce710b93?auto=format&fit=crop&w=600&q=80"
                             alt="Watch 3">
                    </div>
                </div>
                <div class="col-lg-4 text-center">
                    <div class="hero-right">
                        <img
                            src="<?= BASE_URL ?>public/images/luxe-watches-logo.png"
                            alt="Luxe Watches Logo"
                            class="hero-logo"
                            onerror="this.style.display='none'; this.nextElementSibling.style.display='block';"
                        >
                        <div style="display:none;" class="text-white-50 small">
                            Chưa thấy logo: hãy đặt file logo vào public/images/luxe-watches-logo.png
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Dải thương hiệu / danh mục -->
        <div class="bg-light border rounded px-3 py-2 mb-3">
            <div class="d-flex flex-wrap align-items-center gap-2">
                <span class="fw-bold me-2">Thương hiệu:</span>
                <a href="<?= BASE_URL ?>"
                   class="btn btn-sm <?= $currentCat === '' ? 'btn-warning' : 'btn-outline-secondary' ?>">
                    Tất cả
                </a>
                <?php foreach ($categories as $cat): ?>
                    <a href="<?= BASE_URL ?>?id=<?= $cat['id'] ?>"
                       class="btn btn-sm <?= $currentCat == $cat['id'] ? 'btn-warning' : 'btn-outline-secondary' ?>">
                        <?= htmlspecialchars($cat['name']) ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>

        <h5 class="mb-3">Đồng hồ chính hãng</h5>

        <div class="row justify-content-center">
            <?php foreach ($products as $product): ?>
                <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                    <div class="product-grid-item">
                        <a href="<?= BASE_URL ?>?controller=user&action=detail&id=<?= $product['id'] ?>">
                            <img src="<?= BASE_URL . $product['image'] ?>" alt="<?= htmlspecialchars($product['name']) ?>">
                        </a>
                        <div class="mt-2 product-name">
                            <a href="<?= BASE_URL ?>?controller=user&action=detail&id=<?= $product['id'] ?>"
                               class="text-decoration-none text-dark">
                                <?= htmlspecialchars($product['name']) ?>
                            </a>
                        </div>
                        <div class="product-price mt-1">
                            <?= number_format($product['price'], 0, ',', '.') ?> VND
                        </div>
                        <div class="product-meta mt-1">
                            Danh mục: <?= htmlspecialchars($product['category_name'] ?? 'N/A') ?>
                        </div>
                        <div class="mt-2 d-flex gap-2">
                            <a href="<?= BASE_URL ?>?controller=user&action=detail&id=<?= $product['id'] ?>"
                               class="btn btn-sm btn-outline-secondary">
                                Xem chi tiết
                            </a>
                            <a href="<?= BASE_URL ?>?controller=user&action=addToCart&id=<?= $product['id'] ?>"
                               class="btn btn-sm btn-danger">
                                Thêm vào giỏ
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <h5 class="mb-3">Luxe Watches</h5>
                    <p>Đồng hồ chính hãng từ các thương hiệu uy tín trên thế giới. Cam kết chất lượng và dịch vụ tốt nhất cho khách hàng.</p>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                <div class="col-lg-2">
                    <h6 class="mb-3">Sản Phẩm</h6>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-white text-decoration-none">Đồng Hồ Nam</a></li>
                        <li><a href="#" class="text-white text-decoration-none">Đồng Hồ Nữ</a></li>
                        <li><a href="#" class="text-white text-decoration-none">Đồng Hồ Cao Cấp</a></li>
                        <li><a href="#" class="text-white text-decoration-none">Phụ Kiện</a></li>
                    </ul>
                </div>
                <div class="col-lg-2">
                    <h6 class="mb-3">Hỗ Trợ</h6>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-white text-decoration-none">Hướng Dẫn Mua Hàng</a></li>
                        <li><a href="#" class="text-white text-decoration-none">Chính Sách Bảo Hành</a></li>
                        <li><a href="#" class="text-white text-decoration-none">Chính Sách Đổi Trả</a></li>
                        <li><a href="#" class="text-white text-decoration-none">Liên Hệ</a></li>
                    </ul>
                </div>
                <div class="col-lg-4">
                    <h6 class="mb-3">Liên Hệ</h6>
                    <p><i class="fas fa-map-marker-alt me-2"></i>123 Đường ABC, Quận XYZ, TP.HCM</p>
                    <p><i class="fas fa-phone me-2"></i>1900 XXX XXX</p>
                    <p><i class="fas fa-envelope me-2"></i>info@watchshop.com</p>
                </div>
            </div>
            <hr class="my-4">
            <div class="text-center">
                <p class="mb-0">&copy; 2024 Luxe Watches. Tất cả quyền được bảo lưu.</p>
            </div>
        </div>
    </footer>

</body>
</html>