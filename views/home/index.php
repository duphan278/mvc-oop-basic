<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Luxe Watches - Đồng hồ chính hãng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --accent-color: #e74c3c;
            --light-bg: #f8f9fa;
            --text-primary: #1a1a1a;
            --text-secondary: #6c757d;
            --text-muted: #8e8e93;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            line-height: 1.7;
            color: var(--text-primary);
            font-weight: 400;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Playfair Display', serif;
            font-weight: 600;
            line-height: 1.3;
            letter-spacing: -0.02em;
            color: var(--text-primary);
            margin-bottom: 1rem;
        }

        h1 {
            font-size: 3rem;
            font-weight: 700;
        }

        h2 {
            font-size: 2.5rem;
        }

        h3 {
            font-size: 2rem;
        }

        h4 {
            font-size: 1.5rem;
        }

        h5 {
            font-size: 1.25rem;
        }

        p {
            margin-bottom: 1.5rem;
            line-height: 1.8;
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            text-align: center;
            margin-bottom: 3rem;
            position: relative;
        }

        .section-title::after {
            content: '';
            display: block;
            width: 60px;
            height: 3px;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
            margin: 1rem auto 0;
            border-radius: 2px;
        }

        .product-grid-item {
            border: 1px solid #e9ecef;
            background: #fff;
            padding: 1.5rem;
            height: 100%;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            transition: all 0.3s ease;
        }

        .product-grid-item:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }

        .product-grid-item img {
            width: 100%;
            height: 220px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 1rem;
        }

        .product-name {
            font-size: 1rem;
            font-weight: 500;
            min-height: 48px;
            line-height: 1.5;
            margin-bottom: 0.5rem;
        }

        .product-name a {
            color: var(--text-primary);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .product-name a:hover {
            color: var(--primary-color);
        }

        .product-price {
            color: #dc3545;
            font-weight: 700;
            font-size: 1.1rem;
            margin-bottom: 0.5rem;
        }

        .product-meta {
            font-size: 0.875rem;
            color: var(--text-muted);
            font-weight: 400;
        }

        .content-wrap {
            max-width: 1220px;
            margin: 0 auto;
        }

        .btn {
            font-weight: 500;
            letter-spacing: 0.025em;
            border-radius: 8px;
            padding: 0.75rem 1.5rem;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border: none;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(44, 62, 80, 0.3);
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }

        .card-title {
            font-family: 'Playfair Display', serif;
            font-weight: 600;
            color: var(--text-primary);
        }

        .card-text {
            color: var(--text-secondary);
            line-height: 1.6;
        }

        .newsletter-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .newsletter-section h3 {
            color: white;
            margin-bottom: 1rem;
        }

        .newsletter-section p {
            color: rgba(255,255,255,0.9);
        }

        .form-control {
            border-radius: 8px;
            border: 2px solid rgba(255,255,255,0.2);
            background: rgba(255,255,255,0.1);
            color: white;
        }

        .form-control::placeholder {
            color: rgba(255,255,255,0.7);
        }

        .form-control:focus {
            border-color: white;
            background: rgba(255,255,255,0.2);
            color: white;
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

        /* Landing refresh: softer, premium look */
        .content-wrap {
            padding-bottom: 1rem;
        }

        .hero-banner {
            border: 0;
            border-radius: 22px;
            padding: 1.25rem !important;
            box-shadow: 0 18px 40px rgba(16, 24, 40, 0.28);
        }

        .hero-watch {
            border-radius: 14px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.22);
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }

        .hero-watch:hover {
            transform: translateY(-3px);
            box-shadow: 0 14px 24px rgba(0, 0, 0, 0.28);
        }

        .brand-strip {
            border: 0 !important;
            border-radius: 18px !important;
            padding: 0.9rem 1rem !important;
            background: linear-gradient(180deg, #ffffff, #f7f9fc) !important;
            box-shadow: 0 10px 24px rgba(15, 23, 42, 0.08);
        }

        .brand-strip .btn-sm {
            border-radius: 999px;
            padding: 0.42rem 0.92rem;
            font-weight: 500;
        }

        .product-grid-item {
            border: 0;
            border-radius: 18px;
            box-shadow: 0 8px 22px rgba(17, 24, 39, 0.09);
            padding: 1rem;
        }

        .product-grid-item:hover {
            transform: translateY(-6px);
            box-shadow: 0 16px 34px rgba(17, 24, 39, 0.16);
        }

        .product-grid-item img {
            border-radius: 14px;
            background: #f6f8fb;
            object-fit: contain;
            padding: 0.65rem;
            height: 230px;
            border: 1px solid #eef1f5;
        }

        .product-grid-item .btn {
            border-radius: 999px;
            font-weight: 600;
        }

        .card {
            border-radius: 18px;
            box-shadow: 0 10px 24px rgba(17, 24, 39, 0.1);
            overflow: hidden;
        }

        .card .card-img-top {
            border-radius: 18px 18px 0 0;
            height: 220px;
            object-fit: cover;
        }

        .newsletter-section {
            border-radius: 22px;
            overflow: hidden;
            box-shadow: 0 18px 34px rgba(76, 29, 149, 0.25);
        }

        .newsletter-section .btn {
            border-radius: 0 12px 12px 0;
            font-weight: 600;
        }

        .footer {
            margin-top: 3.5rem;
            border-radius: 22px 22px 0 0;
            box-shadow: 0 -10px 28px rgba(17, 24, 39, 0.14);
        }

        .footer .social-links a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.08);
        }

        @media (max-width: 768px) {
            .hero-watch {
                height: 120px;
            }
            .hero-title {
                font-size: 1.2rem;
            }
            .product-grid-item img {
                height: 200px;
            }
            .newsletter-section {
                border-radius: 16px;
            }
            .footer {
                border-radius: 16px 16px 0 0;
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
            $rolexFallbackImages = [
                'https://images.unsplash.com/photo-1523170335258-f5ed11844a49?auto=format&fit=crop&w=900&q=80',
                'https://images.unsplash.com/photo-1547996160-81dfa63595aa?auto=format&fit=crop&w=900&q=80',
                'https://images.unsplash.com/photo-1522312346375-d1a52e2b99b3?auto=format&fit=crop&w=900&q=80'
            ];
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
        <div class="bg-light border rounded px-3 py-2 mb-3 brand-strip">
            <div class="d-flex flex-wrap align-items-center gap-2">
                <span class="fw-bold me-2">Thương hiệu:</span>
                <a href="<?= BASE_URL ?>"
                   class="btn btn-sm <?= $currentCat === '' ? 'btn-warning' : 'btn-outline-secondary' ?>">
                    Tất cả
                </a>
                <?php foreach ($categories as $cat): ?>
                    <a href="<?= BASE_URL ?>?controller=user&action=products&id=<?= (int)$cat['id'] ?>"
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
                            <?php $productImage = resolveProductImage($product['image'] ?? '', $rolexFallbackImages, (int)($product['id'] ?? 0)); ?>
                            <img src="<?= htmlspecialchars($productImage) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="img-fluid">
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

        <!-- Sản phẩm nổi bật -->
        <section class="my-5">
            <h3 class="section-title text-center">Sản Phẩm Nổi Bật</h3>
            <div class="row justify-content-center">
                <?php
                // Lấy 4 sản phẩm đầu làm nổi bật
                $featuredProducts = array_slice($products, 0, 4);
                foreach ($featuredProducts as $product): ?>
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                        <div class="product-grid-item">
                            <a href="<?= BASE_URL ?>?controller=user&action=detail&id=<?= $product['id'] ?>">
                                <?php $productImage = resolveProductImage($product['image'] ?? '', $rolexFallbackImages, (int)($product['id'] ?? 0)); ?>
                                <img src="<?= htmlspecialchars($productImage) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="img-fluid">
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
        </section>

        <!-- Tin tức -->
        <section class="my-5">
            <h3 class="section-title text-center">Tin Tức & Blog</h3>
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <div class="card h-100">
                        <img src="https://images.unsplash.com/photo-1547996160-81dfa63595aa?auto=format&fit=crop&w=600&q=80"
                             class="card-img-top" alt="News 1">
                        <div class="card-body">
                            <h5 class="card-title">Cách Chọn Đồng Hồ Phù Hợp</h5>
                            <p class="card-text">Hướng dẫn chi tiết cách chọn đồng hồ phù hợp với phong cách và nhu cầu của bạn.</p>
                            <a href="#" class="btn btn-outline-primary">Đọc thêm</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-4">
                    <div class="card h-100">
                        <img src="https://images.unsplash.com/photo-1587836374828-4dbafa94cf0e?auto=format&fit=crop&w=600&q=80"
                             class="card-img-top" alt="News 2">
                        <div class="card-body">
                            <h5 class="card-title">Xu Hướng Đồng Hồ 2024</h5>
                            <p class="card-text">Khám phá những xu hướng đồng hồ mới nhất trong năm 2024.</p>
                            <a href="#" class="btn btn-outline-primary">Đọc thêm</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-4">
                    <div class="card h-100">
                        <img src="https://images.unsplash.com/photo-1547996160-81dfa63595aa?auto=format&fit=crop&w=600&q=80"
                             class="card-img-top" alt="News 3">
                        <div class="card-body">
                            <h5 class="card-title">Bảo Quản Đồng Hồ Đúng Cách</h5>
                            <p class="card-text">Những bí quyết bảo quản đồng hồ để giữ được độ bền và vẻ đẹp lâu dài.</p>
                            <a href="#" class="btn btn-outline-primary">Đọc thêm</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Newsletter -->
        <section class="newsletter-section py-5 bg-primary text-white">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <h3 class="mb-3">Đăng ký nhận tin</h3>
                        <p class="mb-0">Nhận thông tin về sản phẩm mới, khuyến mãi đặc biệt và xu hướng đồng hồ mới nhất.</p>
                    </div>
                    <div class="col-lg-6">
                        <form class="newsletter-form" id="newsletter-form">
                            <div class="input-group input-group-lg">
                                <input type="email" class="form-control" placeholder="Nhập email của bạn" required>
                                <button class="btn btn-light" type="submit">
                                    <i class="fas fa-paper-plane me-2"></i>Đăng ký
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>

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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Newsletter subscription
        document.getElementById('newsletter-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const email = this.querySelector('input[type="email"]').value;
            const button = this.querySelector('button');
            const originalText = button.innerHTML;

            button.disabled = true;
            button.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Đang xử lý...';

            // Simulate API call (you can replace with actual API endpoint)
            setTimeout(() => {
                alert('Cảm ơn bạn đã đăng ký! Chúng tôi sẽ gửi thông tin mới nhất đến email của bạn.');
                this.reset();
                button.disabled = false;
                button.innerHTML = originalText;
            }, 1000);
        });
    </script>
</body>
</html>