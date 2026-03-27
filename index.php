<?php

session_start();

// Require file Common
require_once './commons/env.php'; // Khai báo biến môi trường
require_once './commons/function.php'; // Hàm hỗ trợ

// Require toàn bộ file Controllers
require_once './controllers/UserController.php';
require_once './controllers/HomeController.php';
require_once './controllers/AuthController.php';
require_once './controllers/AdminController.php';

// Require toàn bộ file Models
require_once './models/Watch.php';
require_once './models/User.php';

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
            if ($action === 'logout') {
                $auth->logout();
                exit;
            }
            if ($action === 'login') {
                $auth->login();
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
            if ($action === 'disable-user' && isset($_GET['id'])) {
                $admin->disableUser((int)$_GET['id']);
                exit;
            }
            if ($action === 'enable-user' && isset($_GET['id'])) {
                $admin->enableUser((int)$_GET['id']);
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
