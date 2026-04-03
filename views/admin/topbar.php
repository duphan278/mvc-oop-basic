<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="<?= BASE_URL ?>?controller=admin&action=home">
            <i class="fas fa-shield-alt me-2"></i>Admin
        </a>

        <div class="d-flex align-items-center gap-3">
            <?php if (isset($_SESSION['user'])): ?>
                <span class="text-white-50">
                    <i class="fas fa-user me-1"></i>
                    <?= htmlspecialchars($_SESSION['user']['email']) ?>
                </span>
                <a class="btn btn-outline-light btn-sm" href="<?= BASE_URL ?>?controller=auth&action=logout">
                    <i class="fas fa-sign-out-alt me-1"></i>Đăng xuất
                </a>
            <?php else: ?>
                <a class="btn btn-outline-light btn-sm" href="<?= BASE_URL ?>?controller=auth&action=loginPage">
                    <i class="fas fa-sign-in-alt me-1"></i>Đăng nhập
                </a>
            <?php endif; ?>
        </div>
    </div>
</nav>

