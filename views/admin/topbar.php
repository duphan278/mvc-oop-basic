<nav class="navbar navbar-expand-lg admin-topbar">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold admin-topbar-brand" href="<?= BASE_URL ?>?controller=admin&action=reports">
            <i class="fas fa-layer-group me-2"></i>Trang quản trị
        </a>

        <div class="d-flex align-items-center gap-3">
            <?php if (isset($_SESSION['user'])): ?>
                <span class="admin-topbar-email">
                    <i class="fas fa-user me-1"></i>
                    <?= htmlspecialchars($_SESSION['user']['email'] ?? '') ?>
                </span>
                <a class="btn btn-sm admin-topbar-logout" href="<?= BASE_URL ?>?controller=auth&action=logout">
                    <i class="fas fa-sign-out-alt me-1"></i>Đăng xuất
                </a>
            <?php else: ?>
                <a class="btn btn-sm admin-topbar-logout" href="<?= BASE_URL ?>?controller=auth&action=loginPage">
                    <i class="fas fa-sign-in-alt me-1"></i>Đăng nhập
                </a>
            <?php endif; ?>
        </div>
    </div>
</nav>

