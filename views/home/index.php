<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Watch Shop - Đồng hồ chính hãng</title>
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

        .hero-section {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            padding: 100px 0;
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="20" cy="20" r="2" fill="rgba(255,255,255,0.1)"/><circle cx="80" cy="80" r="2" fill="rgba(255,255,255,0.1)"/><circle cx="60" cy="30" r="1" fill="rgba(255,255,255,0.1)"/></svg>') repeat;
            opacity: 0.3;
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .hero-title {
            font-family: 'Playfair Display', serif;
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }

        .hero-subtitle {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }

        .product-card {
            border: none;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            background: white;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.15);
        }

        .product-image {
            height: 250px;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .product-card:hover .product-image {
            transform: scale(1.05);
        }

        .product-title {
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }

        .product-price {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--accent-color);
        }

        .category-card {
            background: white;
            border-radius: 10px;
            padding: 2rem;
            text-align: center;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }

        .category-card:hover {
            transform: translateY(-3px);
        }

        .category-icon {
            font-size: 3rem;
            color: var(--secondary-color);
            margin-bottom: 1rem;
        }

        .navbar-brand {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            font-size: 1.8rem;
        }

        .btn-custom {
            border-radius: 25px;
            padding: 0.75rem 2rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-primary-custom {
            background: var(--secondary-color);
            border: none;
        }

        .btn-primary-custom:hover {
            background: #2980b9;
            transform: translateY(-2px);
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
            .hero-title {
                font-size: 2.5rem;
            }
            .hero-section {
                padding: 60px 0;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand text-primary" href="#">
                <i class="fas fa-clock me-2"></i>Watch Shop
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Trang chủ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Sản phẩm</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Thương hiệu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Liên hệ</a>
                    </li>
                </ul>
                <div class="d-flex">
                    <a href="#" class="btn btn-outline-primary me-2">
                        <i class="fas fa-search"></i>
                    </a>
                    <a href="#" class="btn btn-outline-primary me-2">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="badge bg-danger">0</span>
                    </a>
                    <?php if (isset($_SESSION['user'])): ?>
                        <div class="dropdown">
                            <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user"></i> <?= htmlspecialchars($_SESSION['user']['email']) ?>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Tài khoản</a></li>
                                <li><a class="dropdown-item" href="?act=logout">Đăng xuất</a></li>
                            </ul>
                        </div>
                    <?php else: ?>
                        <a href="?controller=auth&action=loginPage" class="btn btn-primary-custom">
                            <i class="fas fa-sign-in-alt"></i> Đăng nhập
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="hero-content">
                        <h1 class="hero-title">Đồng Hồ Chính Hãng</h1>
                        <p class="hero-subtitle">Khám phá bộ sưu tập đồng hồ cao cấp từ các thương hiệu nổi tiếng thế giới. Chất lượng đảm bảo, giá cả hợp lý.</p>
                        <a href="#products" class="btn btn-light btn-lg btn-custom me-3">
                            <i class="fas fa-shopping-bag me-2"></i>Xem sản phẩm
                        </a>
                        <a href="#about" class="btn btn-outline-light btn-lg btn-custom">
                            <i class="fas fa-info-circle me-2"></i>Tìm hiểu thêm
                        </a>
                    </div>
                </div>
                <div class="col-lg-6 text-center">
                    <img src="https://images.unsplash.com/photo-1524592094714-0f0654e20314?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Luxury Watch" class="img-fluid rounded-circle shadow" style="max-width: 400px;">
                </div>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="section-title text-center">Danh Mục Sản Phẩm</h2>
            <div class="row g-4">
                <div class="col-md-3 col-sm-6">
                    <div class="category-card">
                        <div class="category-icon">
                            <i class="fas fa-crown"></i>
                        </div>
                        <h5>Đồng Hồ Nam</h5>
                        <p>Phong cách lịch lãm cho phái mạnh</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="category-card">
                        <div class="category-icon">
                            <i class="fas fa-gem"></i>
                        </div>
                        <h5>Đồng Hồ Nữ</h5>
                        <p>Đẳng cấp và tinh tế</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="category-card">
                        <div class="category-icon">
                            <i class="fas fa-star"></i>
                        </div>
                        <h5>Đồng Hồ Cao Cấp</h5>
                        <p>Bộ sưu tập limited edition</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="category-card">
                        <div class="category-icon">
                            <i class="fas fa-tools"></i>
                        </div>
                        <h5>Phụ Kiện</h5>
                        <p>Dây đồng hồ, hộp đựng</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Products -->
    <section id="products" class="py-5">
        <div class="container">
            <h2 class="section-title text-center">Sản Phẩm Nổi Bật</h2>
            <div class="row g-4">
                <?php
                $featuredProducts = array_slice($products, 0, 8); // Hiển thị 8 sản phẩm đầu
                foreach ($featuredProducts as $product):
                ?>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="product-card h-100">
                        <div class="position-relative overflow-hidden">
                            <?php if (!empty($product['image'])): ?>
                                <img src="/uploads/<?= htmlspecialchars($product['image']) ?>" class="card-img-top product-image" alt="<?= htmlspecialchars($product['name']) ?>">
                            <?php else: ?>
                                <img src="https://images.unsplash.com/photo-1524592094714-0f0654e20314?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" class="card-img-top product-image" alt="Default Watch">
                            <?php endif; ?>
                            <div class="position-absolute top-0 end-0 m-2">
                                <span class="badge bg-danger">Hot</span>
                            </div>
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h5 class="product-title card-title">
                                <a href="#" class="text-decoration-none"><?= htmlspecialchars($product['name']) ?></a>
                            </h5>
                            <p class="text-muted small mb-2">
                                <i class="fas fa-tag me-1"></i><?= htmlspecialchars($product['category_name'] ?? 'Chưa phân loại') ?>
                            </p>
                            <p class="product-price mb-3">
                                <?= htmlspecialchars(number_format($product['price'], 0, ',', '.')) ?> VNĐ
                            </p>
                            <div class="mt-auto">
                                <button class="btn btn-primary-custom btn-sm me-2">
                                    <i class="fas fa-eye"></i> Xem
                                </button>
                                <button class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-cart-plus"></i> Thêm
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <?php if (count($products) > 8): ?>
            <div class="text-center mt-4">
                <a href="#" class="btn btn-primary-custom btn-lg">
                    <i class="fas fa-arrow-right me-2"></i>Xem tất cả sản phẩm
                </a>
            </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="section-title text-center">Tại Sao Chọn Chúng Tôi?</h2>
            <div class="row g-4">
                <div class="col-md-4 text-center">
                    <div class="mb-3">
                        <i class="fas fa-shield-alt fa-3x text-primary"></i>
                    </div>
                    <h5>Bảo Hành Chính Hãng</h5>
                    <p>Bảo hành lên đến 5 năm cho tất cả sản phẩm</p>
                </div>
                <div class="col-md-4 text-center">
                    <div class="mb-3">
                        <i class="fas fa-truck fa-3x text-primary"></i>
                    </div>
                    <h5>Miễn Phí Vận Chuyển</h5>
                    <p>Giao hàng tận nơi trên toàn quốc</p>
                </div>
                <div class="col-md-4 text-center">
                    <div class="mb-3">
                        <i class="fas fa-headset fa-3x text-primary"></i>
                    </div>
                    <h5>Hỗ Trợ 24/7</h5>
                    <p>Đội ngũ tư vấn chuyên nghiệp</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <h5 class="mb-3">Watch Shop</h5>
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
                <p class="mb-0">&copy; 2024 Watch Shop. Tất cả quyền được bảo lưu.</p>
            </div>
        </div>
    </footer>

    <script>
        // Simple cart functionality (demo)
        document.addEventListener('DOMContentLoaded', function() {
            const addToCartButtons = document.querySelectorAll('.fa-cart-plus').parentElement;
            addToCartButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Simple animation
                    this.innerHTML = '<i class="fas fa-check"></i> Đã thêm';
                    this.classList.remove('btn-outline-primary');
                    this.classList.add('btn-success');

                    // Update cart count (demo)
                    const cartBadge = document.querySelector('.badge');
                    let count = parseInt(cartBadge.textContent);
                    cartBadge.textContent = count + 1;

                    setTimeout(() => {
                        this.innerHTML = '<i class="fas fa-cart-plus"></i> Thêm';
                        this.classList.remove('btn-success');
                        this.classList.add('btn-outline-primary');
                    }, 2000);
                });
            });
        });
    </script>
</body>
</html>