<nav class="admin-sidebar">
    <div class="admin-sidebar-head px-3 mb-4">
        <h4 class="admin-sidebar-brand text-center mb-4">
            <i class="fas fa-shield-alt"></i>
        </h4>
    </div>
    <ul class="list-unstyled px-3 admin-menu">
        <li class="mb-2">
            <a href="<?= BASE_URL ?>?act=admin" class="d-block py-3 px-3 text-decoration-none rounded sidebar-link">
                <i class="fas fa-list"></i> Danh sách sản phẩm
            </a>
        </li>
        <li class="mb-2">
            <a href="<?= BASE_URL ?>?controller=admin&action=list-orders" class="d-block py-3 px-3 text-decoration-none rounded sidebar-link">
                <i class="fas fa-shopping-basket"></i> Quản lý đơn hàng
            </a>
        </li>
        <li class="mb-2">
            <a href="<?= BASE_URL ?>?controller=admin&action=list-categories" class="d-block py-3 px-3 text-decoration-none rounded sidebar-link">
                <i class="fas fa-tags"></i> Quản lý thương hiệu
            </a>
        </li>
        <li class="mb-2">
            <a href="<?= BASE_URL ?>?controller=admin&action=list-users" class="d-block py-3 px-3 text-decoration-none rounded sidebar-link">
                <i class="fas fa-users"></i> Quản lý người dùng
            </a>
        </li>
        <li class="mb-2">
            <a href="<?= BASE_URL ?>?controller=admin&action=reports" class="d-block py-3 px-3 text-decoration-none rounded sidebar-link">
                <i class="fas fa-chart-bar"></i> Báo cáo
            </a>
        </li>
    </ul>
</nav>
