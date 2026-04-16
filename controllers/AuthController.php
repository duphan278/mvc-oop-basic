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

            $user = $this->userModel->findByEmail($email);
            if ($user && password_verify($password, $user['password'])) {
                
                // Kiểm tra trạng thái tài khoản
                if (isset($user['status']) && $user['status'] == 0) {
                    $this->loginPage('Tài khoản của bạn đã bị khóa. Vui lòng liên hệ quản trị viên.');
                    return;
                }

                session_regenerate_id(true);
                // Lưu session
                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'fullname' => $user['fullname'] ?? $user['name'] ?? '',
                    'email' => $user['email'],
                    'role' => $user['role'] ?? 'user'
                ];

                $userRole = (string)($user['role'] ?? 'user');
                if ($userRole === 'admin' || $userRole === 'administrator' || $userRole === '1') {
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
            $phone = trim($_POST['phone'] ?? '');
            $birthDate = trim($_POST['birth_date'] ?? '');
            $address = trim($_POST['address'] ?? '');
            $hometown = trim($_POST['hometown'] ?? '');

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
                'role' => 'user',
                'phone' => $phone,
                'birth_date' => $birthDate !== '' ? $birthDate : null,
                'address' => $address,
                'hometown' => $hometown
            ];

            $inserted = $this->userModel->create($userData);
            if ($inserted) {
                session_regenerate_id(true);
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
