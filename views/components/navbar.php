<nav class="navbar navbar-expand-sm bg-light">
    <div class="container-fluid">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="<?= BASE_URL ?>">Trang chủ</a>
            </li>
            <?php if (isset($_SESSION['user']) && in_array($_SESSION['user']['role'], ['admin', 'administrator', '1'])): ?>
            <li class="nav-item">
                <a class="nav-link" href="<?= BASE_URL ?>?controller=admin&action=home">Admin</a>
            </li>
            <?php endif; ?>
            <?php if (!isset($_SESSION['user'])): ?>
            <li class="nav-item">
                <a class="nav-link" href="<?= BASE_URL ?>?controller=auth&action=registerPage">Đăng ký</a>
            </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>