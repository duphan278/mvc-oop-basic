<?php

session_start();

// Require file Common
require_once './commons/env.php'; // Khai báo biến môi trường
require_once './commons/function.php'; // Hàm hỗ trợ

$currentController = $_GET['controller'] ?? 'home';
$currentAction = $_GET['action'] ?? (($_GET['act'] ?? '/') === '/' ? 'index' : ($_GET['act'] ?? 'index'));
$currentPageCss = BASE_URL . 'public/css/pages/' . $currentController . '-' . $currentAction . '.css';

// Tu dong nap CSS local va bo cac link CDN de chay on dinh tren moi may.
ob_start(function ($buffer) use ($currentPageCss) {
    if (stripos($buffer, '<head') !== false) {
        $buffer = preg_replace('/<link[^>]+href="https?:\/\/cdn\.jsdelivr\.net[^"]*"[^>]*>\s*/i', '', $buffer);
        $buffer = preg_replace('/<link[^>]+href="https?:\/\/cdnjs\.cloudflare\.com[^"]*"[^>]*>\s*/i', '', $buffer);
        $buffer = preg_replace('/<link[^>]+href="https?:\/\/fonts\.googleapis\.com[^"]*"[^>]*>\s*/i', '', $buffer);

        $localCss = '<link rel="stylesheet" href="' . BASE_URL . 'public/css/bootstrap.min.css">';
        $themeCss = '<link rel="stylesheet" href="' . BASE_URL . 'public/css/app.css">';
        $faCss = '<link rel="stylesheet" href="' . BASE_URL . 'public/vendor/fontawesome/css/all.min.css">';
        $pageCss = '<link rel="stylesheet" href="' . $currentPageCss . '">';
        $inject = $localCss . PHP_EOL . '    ' . $themeCss . PHP_EOL . '    ' . $faCss . PHP_EOL . '    ' . $pageCss;
        return preg_replace('/<head([^>]*)>/i', '<head$1>' . PHP_EOL . '    ' . $inject, $buffer, 1);
    }

    return $buffer;
});

// Require toàn bộ file Controllers
require_once './controllers/UserController.php';
require_once './controllers/HomeController.php';
require_once './controllers/AuthController.php';
require_once './controllers/AdminController.php';

// Require toàn bộ file Models
require_once './models/Watch.php';
require_once './models/User.php';
require_once './models/Category.php';
require_once './models/Comment.php';
require_once './models/Order.php';
require_once './models/Voucher.php';

// Route
$act = $_GET['act'] ?? '/';
$controller = $_GET['controller'] ?? null;
$action = $_GET['action'] ?? null;

// Hỗ trợ route kiểu cũ và mới
if ($act === 'login-handle') {
    (new AuthController())->login();
    exit;
}
if ($act === 'register') {
    (new AuthController())->registerPage();
    exit;
}
if ($act === 'register-handle') {
    (new AuthController())->register();
    exit;
}
if ($act === 'logout') {
    (new AuthController())->logout();
    exit;
}

if ($controller) {
    switch ($controller) {
        case 'auth':
            $auth = new AuthController();
            if ($action === 'loginPage') {
                $auth->loginPage();
                exit;
            }
            if ($action === 'registerPage') {
                $auth->registerPage();
                exit;
            }
            if ($action === 'logout') {
                $auth->logout();
                exit;
            }
            if ($action === 'login') {
                $auth->login();
                exit;
            }
            if ($action === 'register') {
                $auth->register();
                exit;
            }
            break;
        case 'admin':
            $admin = new AdminController();
            if ($action === 'home' || !$action) {
                $admin->home();
                exit;
            }
            if ($action === 'list-orders') {
                $admin->listOrders();
                exit;
            }
            if ($action === 'list-categories') {
                $admin->listCategories();
                exit;
            }
            if ($action === 'create-category') {
                $admin->createCategory();
                exit;
            }
            if ($action === 'confirm-order' && isset($_GET['id'])) {
                $admin->confirmOrder((int)$_GET['id']);
                exit;
            }
            if ($action === 'ship-order' && isset($_GET['id'])) {
                $admin->shipOrder((int)$_GET['id']);
                exit;
            }
            if ($action === 'create') {
                $admin->create();
                exit;
            }
            if ($action === 'edit-order' && isset($_GET['id'])) {
                $admin->editOrder((int)$_GET['id']);
                exit;
            }
            if ($action === 'detail' && isset($_GET['id'])) {
                $admin->detail((int)$_GET['id']);
                exit;
            }
            if ($action === 'edit' && isset($_GET['id'])) {
                $admin->edit((int)$_GET['id']);
                exit;
            }
            if ($action === 'delete' && isset($_GET['id'])) {
                $admin->delete((int)$_GET['id']);
                exit;
            }
            if ($action === 'list-users') {
                $admin->listUsers();
                exit;
            }
            if ($action === 'edit-user' && isset($_GET['id'])) {
                $admin->editUser((int)$_GET['id']);
                exit;
            }
            if ($action === 'disable-user' && isset($_GET['id'])) {
                $admin->disableUser((int)$_GET['id']);
                exit;
            }
            if ($action === 'enable-user' && isset($_GET['id'])) {
                $admin->enableUser((int)$_GET['id']);
                exit;
            }
            if ($action === 'delete-user' && isset($_GET['id'])) {
                $admin->deleteUser((int)$_GET['id']);
                exit;
            }
            if ($action === 'reports') {
                $admin->reports();
                exit;
            }
            break;
        case 'user':
            $userC = new UserController();
            if ($action === 'home' || !$action) {
                $userC->home();
                exit;
            }
            if ($action === 'products') {
                $userC->products();
                exit;
            }
            if ($action === 'brands') {
                $userC->brands();
                exit;
            }
            if ($action === 'contact') {
                $userC->contact();
                exit;
            }
            if ($action === 'detail' && isset($_GET['id'])) {
                $userC->detail((int)$_GET['id']);
                exit;
            }
            if ($action === 'addComment' && isset($_GET['id'])) {
                $userC->addComment((int)$_GET['id']);
                exit;
            }
            if ($action === 'addToCart' && isset($_GET['id'])) {
                $userC->addToCart((int)$_GET['id']);
                exit;
            }
            if ($action === 'removeCartItem' && isset($_GET['id'])) {
                $userC->removeCartItem((int)$_GET['id']);
                exit;
            }
            if ($action === 'decrementCartItem' && isset($_GET['id'])) {
                $userC->decrementCartItem((int)$_GET['id']);
                exit;
            }
            if ($action === 'cart') {
                $userC->cart();
                exit;
            }
            if ($action === 'checkout') {
                $userC->checkout();
                exit;
            }
            if ($action === 'apply-voucher') {
                $userC->applyVoucher();
                exit;
            }
            if ($action === 'order-status') {
                $userC->orderStatus();
                exit;
            }
            if ($action === 'cancel-order' && isset($_GET['id'])) {
                $userC->cancelOrder((int)$_GET['id']);
                exit;
            }
            if ($action === 'productsByCategory' && isset($_GET['id'])) {
                $userC->productsByCategory((int)$_GET['id']);
                exit;
            }
            break;
    }
}

switch ($act) {
    // Trang chủ (người dùng)
    case '/':
        (new UserController())->home();
        break;

    // Trang admin
    case 'admin':
        (new AdminController())->home();
        break;

    default:
        http_response_code(404);
        echo '<h2>404 - Page not found</h2>';
        break;
};
