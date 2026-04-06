<?php
    $role = $_SESSION['user']['role'] ?? null;
    $isAdmin = in_array($role, ['admin', 'administrator', '1']);
    $cartCount = isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0;
?>

<!-- Thanh trên cùng: logo + tìm kiếm + hotline -->
<div class="py-2" style="background:#000; color:#fff;">
    <div class="container-fluid d-flex flex-wrap align-items-center justify-content-between gap-2">
        <div class="d-flex align-items-center gap-2">
            <a href="<?= BASE_URL ?>" class="text-decoration-none text-warning fw-bold fs-5">
                Luxe Watches
            </a>
            <span class="badge bg-warning text-dark ms-2">Phong cách thượng lưu</span>
        </div>

        <form class="flex-grow-1 mx-3" method="get" action="<?= BASE_URL ?>">
            <input type="hidden" name="controller" value="user">
            <input type="hidden" name="action" value="products">
            <div class="input-group input-group-sm">
                <input type="text" class="form-control" name="q" placeholder="Nhập từ khóa...">
                <button class="btn btn-warning" type="submit">Tìm kiếm</button>
            </div>
        </form>

        <div class="d-flex align-items-center gap-3">
            <div class="text-end">
                <div class="small">Hotline mua hàng</div>
                <div class="fw-bold text-warning">1800 6005</div>
            </div>
            <div class="text-end d-none d-md-block">
                <div class="small">Hệ thống cửa hàng</div>
                <div class="fw-bold">34 tỉnh thành</div>
            </div>
            <!-- Dark Mode Toggle -->
            <button id="theme-toggle" class="btn btn-outline-light border-0 p-2" title="Chuyển đổi chế độ sáng/tối">
                <i class="fas fa-moon"></i>
            </button>
            <?php if (!$isAdmin): ?>
                <a href="<?= BASE_URL ?>?controller=user&action=cart" class="text-decoration-none text-white position-relative">
                    <i class="fas fa-shopping-cart fs-4"></i>
                    <?php if ($cartCount > 0): ?>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            <?= $cartCount ?>
                        </span>
                    <?php endif; ?>
                </a>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Thanh menu dưới màu vàng -->
<nav class="navbar navbar-expand-lg navbar-light" style="background:#f5c400;">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 fw-semibold">
                <li class="nav-item">
                    <a class="nav-link" href="<?= BASE_URL ?>">ĐỒNG HỒ</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= BASE_URL ?>?controller=user&action=products">SẢN PHẨM</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= BASE_URL ?>?controller=user&action=brands">THƯƠNG HIỆU</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= BASE_URL ?>?controller=user&action=contact">LIÊN HỆ</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= BASE_URL ?>?controller=user&action=wishlist">
                        <i class="fas fa-heart me-1"></i>YÊU THÍCH
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= BASE_URL ?>?controller=user&action=order-status">TRẠNG THÁI ĐƠN HÀNG</a>
                </li>
                <?php if ($isAdmin): ?>
                    <li class="nav-item">
                        <a class="nav-link text-danger" href="<?= BASE_URL ?>?controller=admin&action=home">ADMIN</a>
                    </li>
                <?php endif; ?>
            </ul>

            <ul class="navbar-nav mb-2 mb-lg-0">
                <?php if (isset($_SESSION['user'])): ?>
                    <li class="nav-item">
                        <span class="nav-link">
                            <i class="fas fa-user me-1"></i><?= htmlspecialchars($_SESSION['user']['email']) ?>
                        </span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= BASE_URL ?>?controller=auth&action=logout">Đăng xuất</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= BASE_URL ?>?controller=auth&action=loginPage">Đăng nhập</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= BASE_URL ?>?controller=auth&action=registerPage">Đăng ký</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<!-- Banner khuyến mãi cho người dùng đã đăng nhập -->
<?php if (isset($_SESSION['user'])): ?>
<div class="alert alert-warning alert-dismissible fade show mb-0 border-0 rounded-0" role="alert" style="background: linear-gradient(135deg, #ff6b6b, #feca57); color: white;">
    <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap">
        <div class="d-flex align-items-center gap-3">
            <img src="https://images.unsplash.com/photo-1607082348824-0a96f2a4b9da?auto=format&fit=crop&w=80&q=80"
                 alt="Khuyến mãi" class="rounded" style="width: 60px; height: 60px; object-fit: cover;">
            <div>
                <h5 class="mb-1 fw-bold">🎉 Chương Trình Khuyến Mãi 4/4! 🎉</h5>
                <p class="mb-0 small">Giảm giá lên đến 50% cho tất cả sản phẩm đồng hồ. Cơ hội vàng không thể bỏ lỡ!</p>
            </div>
        </div>
        <div class="d-flex align-items-center gap-2">
            <a href="<?= BASE_URL ?>?controller=user&action=products" class="btn btn-light btn-sm fw-bold">
                Mua ngay <i class="fas fa-arrow-right ms-1"></i>
            </a>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- Dark Mode Styles -->
<style>
    /* Dark mode variables */
    :root {
        --bg-color: #ffffff;
        --text-color: #1a1a1a;
        --navbar-bg: #000000;
        --card-bg: #ffffff;
        --border-color: #dee2e6;
        --text-secondary: #6c757d;
        --text-muted: #8e8e93;
    }

    [data-theme="dark"] {
        --bg-color: #0f0f0f;
        --text-color: #ffffff;
        --navbar-bg: #1a1a1a;
        --card-bg: #1a1a1a;
        --border-color: #2a2a2a;
        --text-secondary: #b0b0b0;
        --text-muted: #888888;
    }

    body {
        background-color: var(--bg-color);
        color: var(--text-color);
        transition: background-color 0.3s ease, color 0.3s ease;
    }

    .navbar-dark {
        background-color: var(--navbar-bg) !important;
    }

    .card, .product-grid-item {
        background-color: var(--card-bg);
        border-color: var(--border-color);
        color: var(--text-color);
    }

    .card-title, .product-name a {
        color: var(--text-color) !important;
    }

    .card-text, .product-meta {
        color: var(--text-secondary) !important;
    }

    .theme-transition {
        transition: all 0.3s ease;
    }

    /* Enhanced typography for dark mode */
    [data-theme="dark"] h1,
    [data-theme="dark"] h2,
    [data-theme="dark"] h3,
    [data-theme="dark"] h4,
    [data-theme="dark"] h5,
    [data-theme="dark"] h6 {
        color: var(--text-color);
    }

    [data-theme="dark"] .section-title::after {
        background: linear-gradient(90deg, #60a5fa, #a78bfa);
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const themeToggle = document.getElementById('theme-toggle');
    const html = document.documentElement;
    const icon = themeToggle.querySelector('i');

    // Load saved theme
    const savedTheme = localStorage.getItem('theme') || 'light';
    if (savedTheme === 'dark') {
        html.setAttribute('data-theme', 'dark');
        icon.className = 'fas fa-sun';
    }

    themeToggle.addEventListener('click', function() {
        const currentTheme = html.getAttribute('data-theme');
        if (currentTheme === 'dark') {
            html.removeAttribute('data-theme');
            localStorage.setItem('theme', 'light');
            icon.className = 'fas fa-moon';
        } else {
            html.setAttribute('data-theme', 'dark');
            localStorage.setItem('theme', 'dark');
            icon.className = 'fas fa-sun';
        }
    });
});
</script>