<?php
$role = $_SESSION['user']['role'] ?? null;
$isAdmin = in_array($role, ['admin', 'administrator', '1']);
$cartCount = isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0;
?>

<header class="site-header">
    <div class="container-fluid site-topbar d-flex flex-wrap align-items-center justify-content-between gap-3">
        <div class="site-brand d-flex align-items-center gap-2">
            <a href="<?= BASE_URL ?>" class="brand-link">Luxe Watches</a>
            <span class="brand-pill">Cửa hàng cao cấp</span>
        </div>

        <form class="site-search d-flex align-items-center gap-2 flex-grow-1" method="get" action="<?= BASE_URL ?>">
            <input type="hidden" name="controller" value="user">
            <input type="hidden" name="action" value="products">
            <input type="text" class="form-control" name="q" placeholder="Tìm sản phẩm, thương hiệu..." value="<?= htmlspecialchars($_GET['q'] ?? '') ?>">
            <button class="btn btn-primary site-search-btn" type="submit">Tìm</button>
        </form>

        <div class="site-meta d-flex align-items-center gap-2">
            <span class="site-chip site-hotline">Hotline: 1800 6005</span>
            <?php if (!$isAdmin): ?>
                <a href="<?= BASE_URL ?>?controller=user&action=cart" class="site-chip site-cart-chip">
                    Giỏ hàng <strong>(<?= (int)$cartCount ?>)</strong>
                </a>
            <?php endif; ?>
        </div>
    </div>

    <nav class="site-mainnav navbar navbar-expand-lg">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNavbar">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>">Trang chủ</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>?controller=user&action=products">Sản phẩm</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>?controller=user&action=brands">Thương hiệu</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>?controller=user&action=contact">Liên hệ</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>?controller=user&action=order-status">Trạng thái đơn hàng</a></li>
                    <?php if ($isAdmin): ?>
                        <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>?controller=admin&action=home">Admin</a></li>
                    <?php endif; ?>
                </ul>

                <ul class="navbar-nav mb-2 mb-lg-0">
                    <?php if (isset($_SESSION['user'])): ?>
                        <li class="nav-item"><span class="nav-link user-email-chip"><?= htmlspecialchars($_SESSION['user']['email'] ?? '') ?></span></li>
                        <li class="nav-item"><a class="nav-link nav-cta" href="<?= BASE_URL ?>?controller=auth&action=logout">Đăng xuất</a></li>
                    <?php else: ?>
                        <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>?controller=auth&action=loginPage">Đăng nhập</a></li>
                        <li class="nav-item"><a class="nav-link nav-cta" href="<?= BASE_URL ?>?controller=auth&action=registerPage">Đăng ký</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
</header>

<?php if (isset($_SESSION['user'])): ?>
    <div class="site-promo">
        <div class="alert mb-0" role="alert">
            Đang có ưu đãi cho thành viên. Xem ngay các mẫu đồng hồ mới nhất và nhận ưu đãi trong ngày.
        </div>
    </div>
<?php endif; ?>
