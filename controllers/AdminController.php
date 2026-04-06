<?php
class AdminController extends HomeController
{
    public $product;
    public $user;
    public $order;
    public function __construct()
    {
        $this->product = new Watch();
        $this->user = new User();
        $this->order = new Order();
        checkAdmin(); // Chỉ admin mới chạy được các hàm bên dưới
    }
    public function home()
    {
        $products = $this->product->getAll();
        require_once PATH_ROOT . '/views/admin/index.php';
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
        try {
            $stmt = $db->query("SELECT orders.*, users.fullname
                                 FROM orders
                                 JOIN users ON orders.user_id = users.id
                                 ORDER BY orders.id DESC");
            $orders = $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
        } catch (PDOException $e) {
            // DB cũ có thể chưa có bảng/cột orders -> không cho trang admin chết.
            $orders = [];
        }
        require_once PATH_ROOT . '/views/admin/order_list.php';
    }

    public function editOrder($id)
    {
        $db = connectDB();

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
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $status = $_POST['status'] ?? 'pending';
            $shipping_fee = $_POST['shipping_fee'] ?? 0;
            
            // Tự động miễn phí ship cho đơn hàng trên 10.000.000 VNĐ
            if ($order['total_amount'] > 10000000) {
                $shipping_fee = 0;
            }

            $stmt = $db->prepare("UPDATE orders SET status = :status, shipping_fee = :shipping_fee WHERE id = :id");
            $stmt->execute(['status' => $status, 'shipping_fee' => $shipping_fee, 'id' => $id]);
            
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

    public function listUsers()
    {
        $users = $this->user->getAll(); // Đảm bảo model User có hàm getAll()
        require_once PATH_ROOT . '/views/admin/user_list.php';
    }

    public function confirmOrder($id)
    {
        $this->order->updateStatus($id, 'shipping');
        $this->order->addStatusHistory($id, 'shipping');
        $this->redirect('?controller=admin&action=list-orders');
    }

    public function shipOrder($id)
    {
        $this->order->updateStatus($id, 'completed');
        $this->order->addStatusHistory($id, 'completed');
        $this->redirect('?controller=admin&action=list-orders');
    }

    public function reports()
    {
        // Kết nối DB để lấy dữ liệu thống kê (Thực tế nên viết trong Model)
        $db = connectDB();

        // 1. Thống kê tổng doanh thu (giả định cột total_amount và trạng thái đơn hàng)
        $totalRevenue = 0;
        $totalOrders = 0;
        $recentOrders = [];
        try {
            $stmtRevenue = $db->query("SELECT SUM(total_amount) as total FROM orders WHERE status = 'completed'");
            $rowRevenue = $stmtRevenue->fetch(PDO::FETCH_ASSOC);
            $totalRevenue = $rowRevenue['total'] ?? 0;

            // 2. Tổng số đơn hàng
            $stmtOrders = $db->query("SELECT COUNT(*) as total FROM orders");
            $rowOrders = $stmtOrders->fetch(PDO::FETCH_ASSOC);
            $totalOrders = $rowOrders['total'] ?? 0;

            // 3. Danh sách đơn hàng gần đây
            $stmtRecent = $db->query("SELECT orders.*, users.fullname
                                       FROM orders
                                       JOIN users ON orders.user_id = users.id
                                       ORDER BY orders.id DESC LIMIT 10");
            $recentOrders = $stmtRecent->fetchAll(PDO::FETCH_ASSOC) ?: [];
        } catch (PDOException $e) {
            // DB cũ chưa có orders -> để mặc định 0 rỗng.
        }

        require_once PATH_ROOT . '/views/admin/reports.php';
    }
}
