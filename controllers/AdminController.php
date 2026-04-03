<?php
class AdminController extends HomeController
{
    public $product;
    public $user;
    public function __construct()
    {
        $this->product = new Watch();
        $this->user = new User();
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
            $this->product->create([
                'name' => $_POST['name'] ?? '',
                'category_id' => $_POST['category_id'] ?? 0,
                'price' => $_POST['price'] ?? 0,
                'description' => $_POST['description'] ?? '',
                'image' => $_POST['image'] ?? ''
            ]);
            $this->redirect('?act=admin');
        }
        require_once PATH_ROOT . '/views/admin/create.php';
    }

    public function listOrders()
    {
        $db = connectDB();
        $stmt = $db->query("SELECT orders.*, users.fullname
                             FROM orders 
                             JOIN users ON orders.user_id = users.id 
                             ORDER BY orders.id DESC");
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
        require_once PATH_ROOT . '/views/admin/order_list.php';
    }

    public function editOrder($id)
    {
        $db = connectDB();

        $stmt = $db->prepare("SELECT orders.*, users.fullname FROM orders JOIN users ON orders.user_id = users.id WHERE orders.id = :id");
        $stmt->execute(['id' => $id]);
        $order = $stmt->fetch(PDO::FETCH_ASSOC);

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

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->product->update($id, [
                'name' => $_POST['name'] ?? '',
                'category_id' => $_POST['category_id'] ?? 0,
                'price' => $_POST['price'] ?? 0,
                'description' => $_POST['description'] ?? '',
                'image' => $_POST['image'] ?? ''
            ]);
            $this->redirect('?act=admin');
        }

        require_once PATH_ROOT . '/views/admin/edit.php';
    }

    public function delete($id)
    {
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

    public function reports()
    {
        // Kết nối DB để lấy dữ liệu thống kê (Thực tế nên viết trong Model)
        $db = connectDB();

        // 1. Thống kê tổng doanh thu (giả định cột total_amount và trạng thái đơn hàng)
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

        require_once PATH_ROOT . '/views/admin/reports.php';
    }
}
