<?php
class UserController
{
    public $product;
    public $category;
    public $order;
    public $voucher;

    public function __construct()
    {
        $this->product = new Watch();
        $this->category = new Category();
        $this->order = new Order();
        $this->voucher = new Voucher();
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
        $category_id = $_GET['id'] ?? null;
        if ($category_id) {
            $products = $this->product->getByCategory($category_id);
        } else {
            $products = $this->product->getAll();
        }
        require_once PATH_ROOT . '/views/user/products.php';
    }

    public function brands()
    {
        $brands = $this->category->getAll();
        require_once PATH_ROOT . '/views/user/brands.php';
    }

    public function contact()
    {
        require_once PATH_ROOT . '/views/user/contact.php';
    }

    public function detail($id)
    {
        $product = $this->product->find($id);
        require_once PATH_ROOT . '/views/user/detail.php';
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

        if (!isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id] = 1;
        } else {
            $_SESSION['cart'][$id]++;
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
        // Chặn xem giỏ hàng nếu chưa đăng nhập
        checkUser();

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

        require_once PATH_ROOT . '/views/user/cart.php';
    }

    public function productsByCategory($category_id)
    {
        $products = $this->product->getByCategory($category_id);
        require_once PATH_ROOT . '/views/user/products.php';
    }

    public function orderStatus()
    {
        checkUser();

        $user_id = $_SESSION['user']['id'];
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
        checkUser();
        $order = $this->order->find($id);
        $user_id = $_SESSION['user']['id'];

        if ($order && $order['user_id'] == $user_id && $order['status'] === 'pending') {
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
        checkUser();

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

            $user_id = $_SESSION['user']['id'];
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
