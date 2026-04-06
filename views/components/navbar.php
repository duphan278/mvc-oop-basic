<?php
$role = $_SESSION['user']['role'] ?? null;
$isAdmin = in_array($role, ['admin', 'administrator', '1']);
$cartCount = isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0;
?>

<header class="site-header">
    <div class="container-fluid site-topbar d-flex flex-wrap align-items-center justify-content-between gap-3">
        <div class="d-flex align-items-center gap-2">
            <a href="<?= BASE_URL ?>" class="brand-link">Luxe Watches</a>
            <span class="brand-pill">Premium Store</span>
        </div>

        <form class="site-search d-flex align-items-center gap-2 flex-grow-1" method="get" action="<?= BASE_URL ?>">
            <input type="hidden" name="controller" value="user">
            <input type="hidden" name="action" value="products">
            <input type="text" class="form-control" name="q" placeholder="Tim san pham...">
            <button class="btn btn-primary" type="submit">Tim</button>
        </form>

        <div class="site-meta d-flex align-items-center gap-2">
            <span class="site-chip">Hotline: 1800 6005</span>
            <?php if (!$isAdmin): ?>
                <a href="<?= BASE_URL ?>?controller=user&action=cart" class="site-chip">
                    Gio hang (<?= (int)$cartCount ?>)
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
                    <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>">Trang chu</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>?controller=user&action=products">San pham</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>?controller=user&action=brands">Thuong hieu</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>?controller=user&action=contact">Lien he</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>?controller=user&action=order-status">Trang thai don hang</a></li>
                    <?php if ($isAdmin): ?>
                        <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>?controller=admin&action=home">Admin</a></li>
                    <?php endif; ?>
                </ul>

                <ul class="navbar-nav mb-2 mb-lg-0">
                    <?php if (isset($_SESSION['user'])): ?>
                        <li class="nav-item"><span class="nav-link"><?= htmlspecialchars($_SESSION['user']['email']) ?></span></li>
                        <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>?controller=auth&action=logout">Dang xuat</a></li>
                    <?php else: ?>
                        <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>?controller=auth&action=loginPage">Dang nhap</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>?controller=auth&action=registerPage">Dang ky</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
</header>

<?php if (isset($_SESSION['user'])): ?>
    <div class="site-promo">
        <div class="alert mb-0" role="alert">
            Dang co uu dai cho thanh vien. Xem ngay cac mau dong ho moi nhat va nhan uu dai trong ngay.
        </div>
    </div>
<?php endif; ?>
