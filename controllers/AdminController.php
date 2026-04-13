<?php
class AdminController extends HomeController
{
    public $product;
    public $category;
    public $user;
    public $order;
    public function __construct()
    {
        $this->product = new Watch();
        $this->category = new Category();
        $this->user = new User();
        $this->order = new Order();
        checkAdmin(); // Chỉ admin mới chạy được các hàm bên dưới
    }
    public function home()
    {
        $products = $this->product->getAll();
        require_once PATH_ROOT . '/views/admin/index.php';
    }

    public function listCategories()
    {
        $brands = $this->category->getAll();
        require_once PATH_ROOT . '/views/admin/category_list.php';
    }

    public function createCategory()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('?controller=admin&action=list-categories');
        }

        $name = trim($_POST['name'] ?? '');
        if ($name === '') {
            $this->redirect('?controller=admin&action=list-categories&brand_message=empty');
        }

        $exists = $this->category->findByName($name);
        if ($exists) {
            $this->redirect('?controller=admin&action=list-categories&brand_message=exists');
        }

        $created = $this->category->create($name);
        if ($created) {
            $this->redirect('?controller=admin&action=list-categories&brand_message=created');
        }

        $this->redirect('?controller=admin&action=list-categories&brand_message=failed');
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $imagePath = '';
            
            // Xử lý upload ảnh
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = PATH_ROOT . '/uploads/';
                
                // Tạo thư mục nếu chưa tồn tại
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }
                
                // Tạo tên file duy nhất
                $fileName = uniqid() . '_' . basename($_FILES['image']['name']);
                $targetFile = $uploadDir . $fileName;
                
                // Kiểm tra loại file
                $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
                $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                
                if (in_array($imageFileType, $allowedTypes)) {
                    if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                        $imagePath = $fileName;
                    }
                }
            }
            
            $this->product->create([
                'name' => $_POST['name'] ?? '',
                'category_id' => $_POST['category_id'] ?? 0,
                'price' => $_POST['price'] ?? 0,
                'description' => $_POST['description'] ?? '',
                'image' => $imagePath
            ]);
            $this->redirect('?act=admin');
        }
        require_once PATH_ROOT . '/views/admin/create.php';
    }

    public function listOrders()
    {
        $db = connectDB();
        $orders = [];
        $orderItemsMap = [];
        $totalRows = 0;
        $perPage = 10;
        $page = max(1, (int)($_GET['page'] ?? 1));
        $offset = ($page - 1) * $perPage;

        $filters = [
            'q' => trim($_GET['q'] ?? ''),
            'status' => trim($_GET['status'] ?? ''),
            'date_from' => trim($_GET['date_from'] ?? ''),
            'date_to' => trim($_GET['date_to'] ?? ''),
            'min_total' => trim($_GET['min_total'] ?? ''),
            'max_total' => trim($_GET['max_total'] ?? ''),
            'sort' => trim($_GET['sort'] ?? 'created_desc'),
        ];

        $where = [];
        $params = [];

        if ($filters['q'] !== '') {
            $where[] = "(users.fullname LIKE :q OR users.email LIKE :q OR CAST(orders.id AS CHAR) LIKE :q)";
            $params['q'] = '%' . $filters['q'] . '%';
        }
        if ($filters['status'] !== '') {
            $where[] = "orders.status = :status";
            $params['status'] = $filters['status'];
        }
        if ($filters['date_from'] !== '') {
            $where[] = "DATE(orders.created_at) >= :date_from";
            $params['date_from'] = $filters['date_from'];
        }
        if ($filters['date_to'] !== '') {
            $where[] = "DATE(orders.created_at) <= :date_to";
            $params['date_to'] = $filters['date_to'];
        }
        if ($filters['min_total'] !== '' && is_numeric($filters['min_total'])) {
            $where[] = "orders.total_amount >= :min_total";
            $params['min_total'] = (float)$filters['min_total'];
        }
        if ($filters['max_total'] !== '' && is_numeric($filters['max_total'])) {
            $where[] = "orders.total_amount <= :max_total";
            $params['max_total'] = (float)$filters['max_total'];
        }

        $whereSql = !empty($where) ? ('WHERE ' . implode(' AND ', $where)) : '';
        $sortMap = [
            'created_desc' => 'orders.created_at DESC',
            'created_asc' => 'orders.created_at ASC',
            'amount_desc' => 'orders.total_amount DESC',
            'amount_asc' => 'orders.total_amount ASC',
            'id_desc' => 'orders.id DESC',
            'id_asc' => 'orders.id ASC',
        ];
        $orderBy = $sortMap[$filters['sort']] ?? $sortMap['created_desc'];

        try {
            $countSql = "SELECT COUNT(*) as total
                         FROM orders
                         JOIN users ON orders.user_id = users.id
                         {$whereSql}";
            $countStmt = $db->prepare($countSql);
            $countStmt->execute($params);
            $totalRows = (int)(($countStmt->fetch(PDO::FETCH_ASSOC))['total'] ?? 0);

            $isExportCsv = (($_GET['export'] ?? '') === 'csv');
            if ($isExportCsv) {
                $exportSql = "SELECT orders.*, users.fullname, users.email
                              FROM orders
                              JOIN users ON orders.user_id = users.id
                              {$whereSql}
                              ORDER BY {$orderBy}";
                $exportStmt = $db->prepare($exportSql);
                $exportStmt->execute($params);
                $exportOrders = $exportStmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
                $this->exportOrdersCsv($exportOrders);
                return;
            }

            $sql = "SELECT orders.*, users.fullname, users.email
                    FROM orders
                    JOIN users ON orders.user_id = users.id
                    {$whereSql}
                    ORDER BY {$orderBy}
                    LIMIT :limit OFFSET :offset";
            $stmt = $db->prepare($sql);
            foreach ($params as $k => $v) {
                $stmt->bindValue(':' . $k, $v);
            }
            $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();
            $orders = $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];

            if (!empty($orders)) {
                $orderIds = array_map(static function ($order) {
                    return (int)($order['id'] ?? 0);
                }, $orders);
                $orderItemsMap = $this->order->getItemsByOrderIds($orderIds);
            }
        } catch (PDOException $e) {
            // DB cũ có thể chưa có bảng/cột orders -> không cho trang admin chết.
            $orders = [];
            $orderItemsMap = [];
        }

        $totalPages = max(1, (int)ceil($totalRows / $perPage));
        if ($page > $totalPages) {
            $page = $totalPages;
        }
        require_once PATH_ROOT . '/views/admin/order_list.php';
    }

    public function editOrder($id)
    {
        $db = connectDB();
        $errorMessage = '';

        try {
            $stmt = $db->prepare("SELECT orders.*, users.fullname
                                    FROM orders
                                    JOIN users ON orders.user_id = users.id
                                    WHERE orders.id = :id");
            $stmt->execute(['id' => $id]);
            $order = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->redirect('?controller=admin&action=list-orders');
        }

        if (!$order) {
            $this->redirect('?controller=admin&action=list-orders');
        }

        $allowedStatusOptions = $this->getAllowedNextStatuses((string)$order['status']);
        $statusHistory = $this->order->getStatusHistory($id);
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $status = $_POST['status'] ?? 'pending';
            $shipping_fee = $_POST['shipping_fee'] ?? 0;

            if (!in_array($status, $allowedStatusOptions, true)) {
                $errorMessage = 'Không thể chuyển trạng thái lùi về trước sau khi đơn đã được xác nhận.';
                require_once PATH_ROOT . '/views/admin/order_edit.php';
                return;
            }
            
            // Tự động miễn phí ship cho đơn hàng trên 10.000.000 VNĐ
            if ($order['total_amount'] > 10000000) {
                $shipping_fee = 0;
            }

            $stmt = $db->prepare("UPDATE orders SET status = :status, shipping_fee = :shipping_fee WHERE id = :id");
            $stmt->execute(['status' => $status, 'shipping_fee' => $shipping_fee, 'id' => $id]);
            if ($status !== (string)$order['status']) {
                $this->order->addStatusHistory($id, $status);
            }
            
            $this->redirect('?controller=admin&action=list-orders');
        }

        require_once PATH_ROOT . '/views/admin/order_edit.php';
    }

    public function detail($id)
    {
        $product = $this->product->find($id);
        if (!$product) {
            $this->redirect('?act=admin');
        }
        require_once PATH_ROOT . '/views/admin/detail.php';
    }

    public function edit($id)
    {
        $product = $this->product->find($id);
        if (!$product) {
            $this->redirect('?act=admin');
        }

        // Lấy danh sách các ảnh đã upload để hiển thị tùy chọn chọn ảnh có sẵn
        $uploadedImages = $this->getUploadedImages();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $imagePath = $_POST['current_image'] ?? '';
            
            // Xử lý upload ảnh mới
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = PATH_ROOT . '/uploads/';
                
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }
                $oldImagePath = $_POST['current_image'] ?? ''; // Lưu đường dẫn ảnh cũ để xóa
                
                // Xóa ảnh cũ nếu có
                if (!empty($_POST['current_image']) && file_exists($uploadDir . $_POST['current_image'])) {
                    unlink($uploadDir . $_POST['current_image']);
                }
                
                // Tạo tên file duy nhất
                $fileName = uniqid() . '_' . basename($_FILES['image']['name']);
                $targetFile = $uploadDir . $fileName;
                
                // Kiểm tra loại file
                $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
                $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                
                if (in_array($imageFileType, $allowedTypes)) {
                    if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                        $imagePath = $fileName;
                        // Nếu ảnh mới được tải lên thành công, xóa ảnh cũ (nếu có và khác ảnh mới)
                        if (!empty($oldImagePath) && file_exists($uploadDir . $oldImagePath) && $oldImagePath !== $imagePath) {
                            unlink($uploadDir . $oldImagePath);
                        }
                    }
                }
            } else if (isset($_POST['existing_image_selection']) && !empty($_POST['existing_image_selection'])) {
                // Case 2: Existing image selected (and no new image uploaded)
                $selectedExistingImage = $_POST['existing_image_selection'];
                $uploadDir = PATH_ROOT . '/uploads/'; // Đảm bảo $uploadDir được định nghĩa
                $oldImagePath = $_POST['current_image'] ?? ''; // Lưu đường dẫn ảnh cũ để xóa

                // Chỉ cập nhật nếu ảnh được chọn khác với ảnh hiện tại
                if ($selectedExistingImage !== $oldImagePath) {
                    // Đảm bảo ảnh được chọn thực sự tồn tại trong thư mục uploads
                    if (file_exists($uploadDir . $selectedExistingImage)) {
                        $imagePath = $selectedExistingImage;
                        // Nếu một ảnh có sẵn khác được chọn, xóa ảnh cũ (nếu có và khác ảnh mới)
                        if (!empty($oldImagePath) && file_exists($uploadDir . $oldImagePath) && $oldImagePath !== $imagePath) {
                            unlink($uploadDir . $oldImagePath);
                        }
                    }
                }
            }
            $this->product->update($id, [
                'name' => $_POST['name'] ?? '',
                'category_id' => $_POST['category_id'] ?? 0,
                'price' => $_POST['price'] ?? 0,
                'description' => $_POST['description'] ?? '',
                'image' => $imagePath
            ]);
            $this->redirect('?act=admin');
        }
        // Truyền biến $uploadedImages vào view
        require_once PATH_ROOT . '/views/admin/edit.php'; 
    }

    /**
     * Lấy danh sách tất cả các tệp ảnh trong thư mục uploads.
     * @return array Mảng chứa tên các tệp ảnh.
     */
    private function getUploadedImages() {
        $uploadDir = PATH_ROOT . '/uploads/';
        $images = [];
        if (is_dir($uploadDir)) {
            $files = scandir($uploadDir);
            foreach ($files as $file) {
                if ($file !== '.' && $file !== '..' && is_file($uploadDir . $file)) {
                    $imageFileType = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp']; // Các định dạng ảnh cho phép
                    if (in_array($imageFileType, $allowedTypes)) {
                        $images[] = $file;
                    }
                }
            }
        }
        return $images;
    }

    public function delete($id)
    {
        // Lấy thông tin sản phẩm để xóa ảnh
        $product = $this->product->find($id);
        if ($product && !empty($product['image'])) {
            $imagePath = PATH_ROOT . '/uploads/' . $product['image'];
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
        
        $this->product->delete($id);
        $this->redirect('?act=admin');
    }

    public function disableUser($id)
    {
        $this->user->updateStatus($id, 0); // Giả định 0 là trạng thái bị vô hiệu hóa/khóa
        $this->redirect('?controller=admin&action=list-users');
    }

    public function enableUser($id)
    {
        $this->user->updateStatus($id, 1); // 1 là trạng thái hoạt động
        $this->redirect('?controller=admin&action=list-users');
    }

    public function deleteUser($id)
    {
        $currentUserId = (int)($_SESSION['user']['id'] ?? 0);

        // Khong cho admin tu xoa chinh minh.
        if ($id === $currentUserId) {
            $this->redirect('?controller=admin&action=list-users');
        }

        $this->user->delete($id);
        $this->redirect('?controller=admin&action=list-users');
    }

    public function listUsers()
    {
        $users = $this->user->getAll(); // Đảm bảo model User có hàm getAll()
        require_once PATH_ROOT . '/views/admin/user_list.php';
    }

    public function editUser($id)
    {
        $user = $this->user->findById($id);
        if (!$user) {
            $this->redirect('?controller=admin&action=list-users');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $fullname = trim($_POST['fullname'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $phone = trim($_POST['phone'] ?? '');
            $birthDate = trim($_POST['birth_date'] ?? '');
            $address = trim($_POST['address'] ?? '');
            $hometown = trim($_POST['hometown'] ?? '');
            $role = $_POST['role'] ?? 'user';

            if ($fullname === '' || $email === '') {
                $error = 'Vui lòng nhập đầy đủ thông tin.';
                require_once PATH_ROOT . '/views/admin/user_edit.php';
                return;
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = 'Email không hợp lệ.';
                require_once PATH_ROOT . '/views/admin/user_edit.php';
                return;
            }

            $existing = $this->user->findByEmail($email);
            if ($existing && (int)$existing['id'] !== (int)$id) {
                $error = 'Email đã tồn tại.';
                require_once PATH_ROOT . '/views/admin/user_edit.php';
                return;
            }

            $updated = $this->user->update($id, [
                'fullname' => $fullname,
                'email' => $email,
                'phone' => $phone,
                'birth_date' => $birthDate !== '' ? $birthDate : null,
                'address' => $address,
                'hometown' => $hometown,
                'role' => in_array($role, ['admin', 'user'], true) ? $role : 'user',
            ]);

            if ($updated) {
                $this->redirect('?controller=admin&action=list-users');
            }

            $error = 'Cập nhật người dùng thất bại, vui lòng thử lại.';
            require_once PATH_ROOT . '/views/admin/user_edit.php';
            return;
        }

        require_once PATH_ROOT . '/views/admin/user_edit.php';
    }

    public function confirmOrder($id)
    {
        $order = $this->order->find($id);
        if (!$order || !in_array((string)$order['status'], ['pending', 'processing'], true)) {
            $this->redirect('?controller=admin&action=list-orders');
        }
        $this->order->updateStatus($id, 'shipping');
        $this->order->addStatusHistory($id, 'shipping');
        $this->redirect('?controller=admin&action=list-orders');
    }

    public function shipOrder($id)
    {
        $order = $this->order->find($id);
        if (!$order || (string)$order['status'] !== 'shipping') {
            $this->redirect('?controller=admin&action=list-orders');
        }
        $this->order->updateStatus($id, 'completed');
        $this->order->addStatusHistory($id, 'completed');
        $this->redirect('?controller=admin&action=list-orders');
    }

    private function getAllowedNextStatuses(string $currentStatus): array
    {
        $map = [
            'pending' => ['pending', 'processing', 'shipping', 'canceled'],
            'processing' => ['processing', 'shipping', 'canceled'],
            'shipping' => ['shipping', 'completed'],
            'completed' => ['completed'],
            'canceled' => ['canceled'],
        ];
        return $map[$currentStatus] ?? [$currentStatus];
    }

    public function reports()
    {
        // Kết nối DB để lấy dữ liệu thống kê (Thực tế nên viết trong Model)
        $db = connectDB();

        // 1. Thống kê tổng doanh thu (giả định cột total_amount và trạng thái đơn hàng)
        $totalRevenue = 0;
        $totalOrders = 0;
        $completedOrders = 0;
        $pendingOrders = 0;
        $canceledOrders = 0;
        $shippingOrders = 0;
        $avgOrderValue = 0;
        $todayOrders = 0;
        $todayRevenue = 0;
        $totalUsers = 0;
        $totalProducts = 0;
        $dailyLabels = [];
        $dailyRevenue = [];
        $dailyOrderCounts = [];
        $recentOrders = [];
        try {
            $stmtRevenue = $db->query("SELECT SUM(total_amount) as total FROM orders WHERE status = 'completed'");
            $rowRevenue = $stmtRevenue->fetch(PDO::FETCH_ASSOC);
            $totalRevenue = $rowRevenue['total'] ?? 0;

            // 2. Tổng số đơn hàng
            $stmtOrders = $db->query("SELECT COUNT(*) as total FROM orders");
            $rowOrders = $stmtOrders->fetch(PDO::FETCH_ASSOC);
            $totalOrders = $rowOrders['total'] ?? 0;

            // 2.1. Phân bổ trạng thái đơn hàng
            $stmtStatus = $db->query("SELECT status, COUNT(*) as total FROM orders GROUP BY status");
            $statusRows = $stmtStatus->fetchAll(PDO::FETCH_ASSOC) ?: [];
            foreach ($statusRows as $row) {
                $statusKey = strtolower((string)($row['status'] ?? ''));
                $count = (int)($row['total'] ?? 0);
                if ($statusKey === 'completed') {
                    $completedOrders = $count;
                } elseif ($statusKey === 'pending') {
                    $pendingOrders = $count;
                } elseif ($statusKey === 'canceled') {
                    $canceledOrders = $count;
                } elseif ($statusKey === 'shipping') {
                    $shippingOrders = $count;
                }
            }

            // 2.2. Giá trị đơn trung bình
            $stmtAvg = $db->query("SELECT AVG(total_amount) as avg_amount FROM orders");
            $rowAvg = $stmtAvg->fetch(PDO::FETCH_ASSOC);
            $avgOrderValue = (float)($rowAvg['avg_amount'] ?? 0);

            // 2.3. Chỉ số theo ngày hôm nay
            $stmtToday = $db->query("SELECT COUNT(*) as total_orders, SUM(CASE WHEN status = 'completed' THEN total_amount ELSE 0 END) as total_revenue FROM orders WHERE DATE(created_at) = CURDATE()");
            $rowToday = $stmtToday->fetch(PDO::FETCH_ASSOC);
            $todayOrders = (int)($rowToday['total_orders'] ?? 0);
            $todayRevenue = (float)($rowToday['total_revenue'] ?? 0);

            // 2.4. Tổng user và tổng sản phẩm (KPI bổ sung)
            $stmtUsers = $db->query("SELECT COUNT(*) as total FROM users");
            $totalUsers = (int)(($stmtUsers->fetch(PDO::FETCH_ASSOC))['total'] ?? 0);

            $stmtProducts = $db->query("SELECT COUNT(*) as total FROM products");
            $totalProducts = (int)(($stmtProducts->fetch(PDO::FETCH_ASSOC))['total'] ?? 0);

            // 2.5. Doanh thu + số đơn 7 ngày gần nhất (dữ liệu thật)
            $stmtDaily = $db->query("
                SELECT DATE(created_at) as order_day,
                       COUNT(*) as order_count,
                       SUM(CASE WHEN status = 'completed' THEN total_amount ELSE 0 END) as revenue
                FROM orders
                WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 6 DAY)
                GROUP BY DATE(created_at)
                ORDER BY DATE(created_at) ASC
            ");
            $dailyRows = $stmtDaily->fetchAll(PDO::FETCH_ASSOC) ?: [];

            $dailyMap = [];
            foreach ($dailyRows as $row) {
                $day = (string)($row['order_day'] ?? '');
                $dailyMap[$day] = [
                    'revenue' => (float)($row['revenue'] ?? 0),
                    'orders' => (int)($row['order_count'] ?? 0),
                ];
            }

            for ($i = 6; $i >= 0; $i--) {
                $dateKey = date('Y-m-d', strtotime("-{$i} day"));
                $dailyLabels[] = date('d/m', strtotime($dateKey));
                $dailyRevenue[] = (float)($dailyMap[$dateKey]['revenue'] ?? 0);
                $dailyOrderCounts[] = (int)($dailyMap[$dateKey]['orders'] ?? 0);
            }

            // 3. Danh sách đơn hàng gần đây
            $stmtRecent = $db->query("SELECT orders.*, users.fullname
                                       FROM orders
                                       JOIN users ON orders.user_id = users.id
                                       ORDER BY orders.id DESC LIMIT 10");
            $recentOrders = $stmtRecent->fetchAll(PDO::FETCH_ASSOC) ?: [];
        } catch (PDOException $e) {
            // DB cũ chưa có orders -> để mặc định 0 rỗng.
        }

        if (($_GET['export'] ?? '') === 'csv') {
            $this->exportReportCsv([
                'totalRevenue' => $totalRevenue,
                'totalOrders' => $totalOrders,
                'completedOrders' => $completedOrders,
                'pendingOrders' => $pendingOrders,
                'shippingOrders' => $shippingOrders,
                'canceledOrders' => $canceledOrders,
                'avgOrderValue' => $avgOrderValue,
                'todayOrders' => $todayOrders,
                'todayRevenue' => $todayRevenue,
                'totalUsers' => $totalUsers,
                'totalProducts' => $totalProducts,
                'dailyLabels' => $dailyLabels,
                'dailyRevenue' => $dailyRevenue,
                'dailyOrderCounts' => $dailyOrderCounts,
            ]);
            return;
        }

        require_once PATH_ROOT . '/views/admin/reports.php';
    }

    private function exportOrdersCsv(array $orders): void
    {
        header('Content-Type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename="orders_' . date('Ymd_His') . '.csv"');
        $out = fopen('php://output', 'w');
        if ($out === false) {
            exit;
        }
        fwrite($out, "\xEF\xBB\xBF");
        fputcsv($out, ['Ma don', 'Khach hang', 'Email', 'Ngay dat', 'Phi ship', 'Tong tien', 'Trang thai']);
        foreach ($orders as $order) {
            fputcsv($out, [
                $order['id'] ?? '',
                $order['fullname'] ?? '',
                $order['email'] ?? '',
                $order['created_at'] ?? '',
                $order['shipping_fee'] ?? 0,
                $order['total_amount'] ?? 0,
                $order['status'] ?? '',
            ]);
        }
        fclose($out);
        exit;
    }

    private function exportReportCsv(array $data): void
    {
        header('Content-Type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename="report_' . date('Ymd_His') . '.csv"');
        $out = fopen('php://output', 'w');
        if ($out === false) {
            exit;
        }
        fwrite($out, "\xEF\xBB\xBF");
        fputcsv($out, ['Chi so', 'Gia tri']);
        fputcsv($out, ['Tong doanh thu', $data['totalRevenue'] ?? 0]);
        fputcsv($out, ['Tong don hang', $data['totalOrders'] ?? 0]);
        fputcsv($out, ['Don hoan thanh', $data['completedOrders'] ?? 0]);
        fputcsv($out, ['Don dang cho', $data['pendingOrders'] ?? 0]);
        fputcsv($out, ['Don dang giao', $data['shippingOrders'] ?? 0]);
        fputcsv($out, ['Don da huy', $data['canceledOrders'] ?? 0]);
        fputcsv($out, ['Gia tri trung binh/don', $data['avgOrderValue'] ?? 0]);
        fputcsv($out, ['Don hom nay', $data['todayOrders'] ?? 0]);
        fputcsv($out, ['Doanh thu hom nay', $data['todayRevenue'] ?? 0]);
        fputcsv($out, ['Tong nguoi dung', $data['totalUsers'] ?? 0]);
        fputcsv($out, ['Tong san pham', $data['totalProducts'] ?? 0]);
        fputcsv($out, []);
        fputcsv($out, ['Ngay', 'Doanh thu', 'So don']);
        $labels = $data['dailyLabels'] ?? [];
        $revenues = $data['dailyRevenue'] ?? [];
        $counts = $data['dailyOrderCounts'] ?? [];
        foreach ($labels as $i => $label) {
            fputcsv($out, [
                $label,
                $revenues[$i] ?? 0,
                $counts[$i] ?? 0,
            ]);
        }
        fclose($out);
        exit;
    }
}
