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