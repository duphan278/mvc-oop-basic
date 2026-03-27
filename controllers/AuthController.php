<?php
class AuthController extends HomeController{
    public $userModel;

    public function __construct(){
        $this->userModel = new User();
    }

    public function loginPage($error = '') {
        if (!empty($error)) {
            $errorMessage = $error;
        }
        require_once PATH_ROOT . '/views/auth/login.php';
    }

    public function registerPage($error = '') {
        if (!empty($error)) {
            $errorMessage = $error;
        }
        require_once PATH_ROOT . '/views/auth/register.php';
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = trim($_POST['password'] ?? '');

            if (empty($email) || empty($password)) {
                $this->loginPage('Vui lòng nhập đầy đủ email và mật khẩu.');
                return;
            }

            // Quyền admin cứng: du@gmail.com / 123
            if ($email === 'du@gmail.com' && $password === '123') {
                $_SESSION['user'] = [
                    'id' => 0,
                    'fullname' => 'Du',
                    'email' => 'du@gmail.com',
                    'role' => 'admin'
                ];
                $this->redirect('?controller=admin&action=home');
                return;
            }

            $user = $this->userModel->findByEmail($email);
            if ($user && password_verify($password, $user['password'])) {
                
                // Kiểm tra trạng thái tài khoản
                if (isset($user['status']) && $user['status'] == 0) {
                    $this->loginPage('Tài khoản của bạn đã bị khóa. Vui lòng liên hệ quản trị viên.');
                    return;
                }

                // Lưu session
                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'fullname' => $user['fullname'] ?? $user['name'] ?? '',
                    'email' => $user['email'],
                    'role' => $user['role'] ?? 'user'
                ];

                if ($user['role'] === 'admin' || $user['role'] === 'administrator' || $user['role'] === '1') {
                    $this->redirect('?controller=admin&action=home');
                }
                $this->redirect('?controller=user&action=home');
                return;
            }

            $this->loginPage('Email hoặc mật khẩu không chính xác.');
            return;
        }

        $this->loginPage();
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $fullname = trim($_POST['fullname'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = trim($_POST['password'] ?? '');

            if (!$fullname || !$email || !$password) {
                $this->registerPage('Vui lòng điền đầy đủ thông tin đăng ký.');
                return;
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->registerPage('Email không hợp lệ.');
                return;
            }

            if ($this->userModel->findByEmail($email)) {
                $this->registerPage('Email đã được đăng ký trước đó.');
                return;
            }

            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $userData = [
                'fullname' => $fullname,
                'email' => $email,
                'password' => $passwordHash,
                'role' => 'user'
            ];

            $inserted = $this->userModel->create($userData);
            if ($inserted) {
                $_SESSION['user'] = [
                    'id' => $this->userModel->findByEmail($email)['id'],
                    'fullname' => $fullname,
                    'email' => $email,
                    'role' => 'user'
                ];
                $this->redirect('?controller=user&action=home');
                return;
            }

            $this->registerPage('Đăng ký thất bại, vui lòng thử lại.');
        } else {
            $this->registerPage();
        }
    }

    public function logout() {
        session_unset();
        session_destroy();
        $this->redirect('?controller=auth&action=loginPage');
    }
}
