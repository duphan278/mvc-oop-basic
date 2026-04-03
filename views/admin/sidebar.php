<nav class="bg-dark text-white" style="width:280px; min-height:100vh; padding: 20px 0;">
    <div class="px-3 mb-4">
        <h4 class="text-center text-light mb-4">
            <i class="fas fa-cogs"></i> Admin Panel
        </h4>
    </div>
    <ul class="list-unstyled px-3">
        <li class="mb-2">
            <a href="<?= BASE_URL ?>?act=admin" class="d-block py-3 px-3 text-white text-decoration-none rounded sidebar-link">
                <i class="fas fa-list"></i> Danh sách sản phẩm
            </a>
        </li>
        <li class="mb-2">
            <a href="<?= BASE_URL ?>?controller=admin&action=list-orders" class="d-block py-3 px-3 text-white text-decoration-none rounded sidebar-link">
                <i class="fas fa-shopping-basket"></i> Quản lý đơn hàng
            </a>
        </li>
        <li class="mb-2">
            <a href="<?= BASE_URL ?>?controller=admin&action=list-users" class="d-block py-3 px-3 text-white text-decoration-none rounded sidebar-link">
                <i class="fas fa-users"></i> Quản lý người dùng
            </a>
        </li>
        <li class="mb-2">
            <a href="<?= BASE_URL ?>?controller=admin&action=categories" class="d-block py-3 px-3 text-white text-decoration-none rounded sidebar-link">
                <i class="fas fa-tags"></i> Quản lý thương hiệu
            </a>
        </li>
        <li class="mb-2">
            <a href="<?= BASE_URL ?>?controller=admin&action=reports" class="d-block py-3 px-3 text-white text-decoration-none rounded sidebar-link">
                <i class="fas fa-chart-bar"></i> Báo cáo
            </a>
        </li>
        <li class="mt-4">
            <a href="<?= BASE_URL ?>?act=logout" class="d-block py-3 px-3 text-danger text-decoration-none rounded sidebar-link">
                <i class="fas fa-sign-out-alt"></i> Đăng xuất
            </a>
        </li>
    </ul>
</nav>
