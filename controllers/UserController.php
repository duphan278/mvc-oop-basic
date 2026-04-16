<?php
class UserController
{
    public $product;
    public $category;
    public $order;
    public $voucher;

    public $wishlist;
    public $comment;
    public $user;


    public function __construct()
    {
        $this->product = new Watch();
        $this->category = new Category();
        $this->order = new Order();
        $this->voucher = new Voucher();
        $this->comment = new Comment();
        $this->user = new User();
    }

    private function requireValidUserId(): int
    {
        checkUser();
        $userId = (int)($_SESSION['user']['id'] ?? 0);
        if ($userId <= 0 || !$this->user->findById($userId)) {
            // Session không còn hợp lệ với DB (user bị xóa/ID ảo), buộc đăng nhập lại.
            session_unset();
            session_destroy();
            header('Location: ' . BASE_URL . '?controller=auth&action=loginPage');
            exit;
        }
        return $userId;
    }

    public function home()
    {
        $view = $_GET['view'] ?? 'home';

        switch ($view) {
            case 'products':
                return $this->products();
            case 'brands':
                return $this->brands();
            case 'contact':
                return $this->contact();
            case 'cart':
                return $this->cart();
            case 'checkout':
                return $this->checkout();
            default:
                $products = $this->product->getAll();
                $brands = $this->category->getAll(); // Thêm dòng này để truyền dữ liệu danh mục vào trang chủ
                require_once PATH_ROOT . '/views/home/index.php';
                break;
        }
    }

    public function products()
    {
        $categoryId = isset($_GET['id']) ? (int)$_GET['id'] : null;
        $keyword = trim((string)($_GET['q'] ?? ''));
        $products = $this->product->search($keyword, $categoryId);
        $brands = $this->category->getAll();
        $brandsWithProducts = array_values(array_filter($brands, function ($brand) {
            $brandId = (int)($brand['id'] ?? 0);
            return $brandId > 0 && $this->category->countProductsByCategoryId($brandId) > 0;
        }));
        require_once PATH_ROOT . '/views/user/products.php';
    }

    public function brands()
    {
        $brands = $this->category->getAll();
        $brands = array_values(array_filter($brands, function ($brand) {
            $brandId = (int)($brand['id'] ?? 0);
            return $brandId > 0 && $this->category->countProductsByCategoryId($brandId) > 0;
        }));
        require_once PATH_ROOT . '/views/user/brands.php';
    }

    public function contact()
    {
        require_once PATH_ROOT . '/views/user/contact.php';
    }

    public function detail($id)
    {
        $product = $this->product->find($id);
        if (!$product) {
            header('Location: ' . BASE_URL . '?controller=user&action=products');
            exit;
        }


        $wishlist = $this->wishlist;
        $comments = $this->comment->getByProductId((int)$id);

        require_once PATH_ROOT . '/views/user/detail.php';
    }

    public function addComment($id)
    {
        $userId = $this->requireValidUserId();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $content = trim($_POST['content'] ?? '');
            if ($content !== '') {
                $this->comment->create((int)$id, $userId, $content);
            }
        }

        header('Location: ' . BASE_URL . '?controller=user&action=detail&id=' . (int)$id);
        exit;
    }

    public function addToCart($id)
    {
        // Chặn thao tác giỏ hàng nếu chưa đăng nhập
        checkUser();

        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        if ($id <= 0) {
            header('Location: ' . BASE_URL . '?controller=user&action=products');
            exit;
        }
        if (!$this->product->find((int)$id)) {
            header('Location: ' . BASE_URL . '?controller=user&action=products');
            exit;
        }

        $requestedQty = isset($_REQUEST['quantity']) ? (int)$_REQUEST['quantity'] : 1;
        $quantity = max(1, $requestedQty);

        if (!isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id] = $quantity;
        } else {
            $_SESSION['cart'][$id] += $quantity;
        }

        header('Location: ' . BASE_URL . '?controller=user&action=cart');
        exit;
    }

    public function removeCartItem($id)
    {
        // Chặn thao tác giỏ hàng nếu chưa đăng nhập
        checkUser();

        if (isset($_SESSION['cart'][$id])) {
            unset($_SESSION['cart'][$id]);
        }
        header('Location: ' . BASE_URL . '?controller=user&action=cart');
        exit;
    }

    public function decrementCartItem($id)
    {
        // Chặn thao tác giỏ hàng nếu chưa đăng nhập
        checkUser();

        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]--;
            if ($_SESSION['cart'][$id] <= 0) {
                unset($_SESSION['cart'][$id]);
            }
        }

        header('Location: ' . BASE_URL . '?controller=user&action=cart');
        exit;
    }

    public function cart()
    {
        // Chặn xem giỏ hàng nếu chưa đăng nhập + đảm bảo user hợp lệ trong DB
        $userId = $this->requireValidUserId();

        $cart = $_SESSION['cart'] ?? [];
        $cartItems = [];
        $total = 0;

        if (!empty($cart)) {
            $productIds = array_keys($cart);
            $cartItems = $this->product->getByIds($productIds);

            foreach ($cartItems as &$item) {
                $item['quantity'] = $cart[$item['id']];
                $item['subtotal'] = $item['quantity'] * $item['price'];
                $total += $item['subtotal'];
            }
            unset($item);
        }

        // Tự động điền thông tin checkout từ đơn gần nhất để khách cũ không phải nhập lại.
        $checkoutInfo = $this->order->getLatestCheckoutInfoByUser($userId) ?? [];
        if (empty($checkoutInfo)) {
            $checkoutInfo = [
                'contact_name' => (string)($_SESSION['user']['fullname'] ?? ''),
                'contact_phone' => '',
                'shipping_address' => '',
                'payment_method' => 'cod',
                'bank' => '',
            ];
        }

        require_once PATH_ROOT . '/views/user/cart.php';
    }

    public function productsByCategory($category_id)
    {
        header('Location: ' . BASE_URL . '?controller=user&action=products&id=' . (int)$category_id);
        exit;
    }

    public function orderStatus()
    {
        $user_id = $this->requireValidUserId();
        $orders = $this->order->getByUser($user_id);
        $message = '';
        $order = null;

         if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $order_id = isset($_POST['order_id']) ? (int)$_POST['order_id'] : 0;
            if ($order_id <= 0) {
                $message = 'Vui lòng nhập mã đơn hàng hợp lệ.';
            } else {
                $order = $this->order->find($order_id);
                if (!$order || $order['user_id'] != $user_id) {
                    $message = 'Đơn hàng không tồn tại hoặc không thuộc về bạn.';
                    $order = null;
                }
            }
        }

        // Khoảng nhận order_id từ query sau checkout
        if (!$order && isset($_GET['order_id'])) {
            $order_id = (int)$_GET['order_id'];
            if ($order_id > 0) {
                $order = $this->order->find($order_id);
                if (!$order || $order['user_id'] != $user_id) {
                    $message = 'Đơn hàng không tồn tại hoặc không thuộc về bạn.';
                    $order = null;
                }
            }
        }

        $orderItems = [];
        $statusHistory = [];
        if ($order) {
            $orderItems = $this->order->getItems($order['id']);
            $statusHistory = $this->order->getStatusHistory($order['id']);
        }

        require_once PATH_ROOT . '/views/user/order_status.php';
    }

    public function cancelOrder($id)
    {
        $user_id = $this->requireValidUserId();
        $order = $this->order->find($id);

        if ($order && $order['user_id'] == $user_id && in_array((string)$order['status'], ['pending', 'processing'], true)) {
            $this->order->updateStatus($id, 'canceled');
            $this->order->addStatusHistory($id, 'canceled');
            header('Location: ' . BASE_URL . '?controller=user&action=order-status&order_id=' . $id . '&message=order_canceled');
            exit;
        }

        header('Location: ' . BASE_URL . '?controller=user&action=order-status&order_id=' . $id . '&error=cannot_cancel');
        exit;
    }

    public function checkout()
    {
        $user_id = $this->requireValidUserId();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $payment = $_POST['payment'] ?? 'cod';
            $bank = $_POST['bank'] ?? '';
            $name = trim($_POST['name'] ?? '');
            $phone = trim($_POST['phone'] ?? '');
            $address = trim($_POST['address'] ?? '');
            $voucherCode = trim($_POST['voucher_code'] ?? '');

            if (empty($name) || empty($phone) || empty($address)) {
                // Redirect back with error
                header('Location: ' . BASE_URL . '?controller=user&action=cart&error=missing_info');
                exit;
            }

            if ($payment === 'bank' && empty($bank)) {
                header('Location: ' . BASE_URL . '?controller=user&action=cart&error=select_bank');
                exit;
            }

            $cart = $_SESSION['cart'] ?? [];
            $total = 0;

            $cartItems = [];
            if (!empty($cart)) {
                $productIds = array_keys($cart);
                $productList = $this->product->getByIds($productIds);

                foreach ($productList as $item) {
                    $quantity = $cart[$item['id']];
                    $subtotal = $quantity * $item['price'];
                    $total += $subtotal;

                    $cartItems[] = [
                        'id' => $item['id'],
                        'name' => $item['name'],
                        'quantity' => $quantity,
                        'price' => $item['price'],
                        'subtotal' => $subtotal
                    ];
                }
            }

            if ($total == 0) {
                header('Location: ' . BASE_URL . '?controller=user&action=cart&error=empty_cart');
                exit;
            }

            // Xử lý voucher
            $voucher = null;
            $discountAmount = 0;
            if (!empty($voucherCode)) {
                $voucher = $this->voucher->findByCode($voucherCode);
                if ($voucher) {
                    $discountAmount = $this->voucher->calculateDiscount($voucher, $total);
                } else {
                    // Voucher không hợp lệ, redirect với error
                    header('Location: ' . BASE_URL . '?controller=user&action=cart&error=invalid_voucher');
                    exit;
                }
            }

            $finalTotal = $total - $discountAmount;

            $orderData = [
                'user_id' => $user_id,
                'total_amount' => $finalTotal,
                'payment_method' => $payment,
                'shipping_address' => $address,
                'contact_name' => $name,
                'contact_phone' => $phone,
                'bank' => $bank,
                'status' => 'pending',
                'voucher_id' => $voucher ? $voucher['id'] : null,
                'discount_amount' => $discountAmount
            ];

            $orderId = $this->order->create($orderData);

            if ($orderId) {
                // Lưu item đơn hàng
                $this->order->addItems($orderId, $cartItems);

                // Lưu lịch sử trạng thái
                $this->order->addStatusHistory($orderId, 'pending');

                // Tăng số lần sử dụng voucher nếu có
                if ($voucher) {
                    $this->voucher->incrementUsage($voucher['id']);
                }

                // Clear cart
                unset($_SESSION['cart']);

                // Chuyển về trang trạng thái đơn hàng (tra cứu)
                header('Location: ' . BASE_URL . '?controller=user&action=order-status&order_id=' . $orderId);
                exit;
            } else {
                // Lỗi tạo đơn hàng
                header('Location: ' . BASE_URL . '?controller=user&action=cart&error=order_failed');
                exit;
            }
        }

        // If not POST, redirect to cart
        header('Location: ' . BASE_URL . '?controller=user&action=cart');
        exit;
    }

    public function applyVoucher()
    {
        checkUser();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $voucherCode = trim($_POST['voucher_code'] ?? '');
            $orderAmount = (float)($_POST['order_amount'] ?? 0);

            if (empty($voucherCode)) {
                echo json_encode(['success' => false, 'message' => 'Vui lòng nhập mã voucher']);
                exit;
            }

            $voucher = $this->voucher->findByCode($voucherCode);
            if (!$voucher) {
                echo json_encode(['success' => false, 'message' => 'Mã voucher không tồn tại']);
                exit;
            }

            if (!$this->voucher->isValid($voucher, $orderAmount)) {
                $message = 'Voucher không hợp lệ';
                if ($voucher['expiry_date'] < date('Y-m-d H:i:s')) {
                    $message = 'Voucher đã hết hạn';
                } elseif ($orderAmount < $voucher['min_order_amount']) {
                    $message = 'Đơn hàng chưa đạt giá trị tối thiểu ' . number_format($voucher['min_order_amount'], 0, ',', '.') . 'đ';
                } elseif ($voucher['usage_limit'] !== null && $voucher['used_count'] >= $voucher['usage_limit']) {
                    $message = 'Voucher đã hết lượt sử dụng';
                }
                echo json_encode(['success' => false, 'message' => $message]);
                exit;
            }

            $discount = $this->voucher->calculateDiscount($voucher, $orderAmount);
            $finalAmount = $orderAmount - $discount;

            echo json_encode([
                'success' => true,
                'message' => 'Áp dụng voucher thành công!',
                'discount' => $discount,
                'final_amount' => $finalAmount,
                'discount_type' => $voucher['discount_type'],
                'discount_value' => $voucher['discount_value']
            ]);
            exit;
        }

        echo json_encode(['success' => false, 'message' => 'Phương thức không hợp lệ']);
        exit;
    }

}
