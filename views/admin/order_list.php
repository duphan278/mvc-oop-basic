<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý đơn hàng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <?php include(PATH_ROOT . 'views/components/navbar.php'); ?>

    <div class="d-flex" style="min-height:100vh; background-color: #f8f9fa;">
        <?php include(PATH_ROOT . 'views/admin/sidebar.php'); ?>

        <div class="container flex-grow-1 p-4">
            <h1 class="mb-4 text-primary fw-bold">Quản lý đơn hàng</h1>
            
            <div class="card shadow-sm">
                <div class="card-body">
                    <?php if (!empty($orders)): ?>
                        <div class="table-responsive">
                            <table class="table table-hover table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Mã ĐH</th>
                                        <th>Khách hàng</th>
                                        <th>Ngày đặt</th>
                                        <th class="text-end">Phí Ship</th>
                                        <th class="text-end">Tổng tiền</th>
                                        <th class="text-center">Trạng thái</th>
                                        <th class="text-center">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($orders as $order): ?>
                                        <tr>
                                            <td>#<?= $order['id'] ?></td>
                                            <td class="fw-semibold"><?= htmlspecialchars($order['fullname']) ?></td>
                                            <td><?= date('d/m/Y H:i', strtotime($order['created_at'])) ?></td>
                                            <td class="text-end text-muted"><?= number_format($order['shipping_fee'] ?? 0, 0, ',', '.') ?> VNĐ</td>
                                            <td class="text-end fw-bold"><?= number_format($order['total_amount'], 0, ',', '.') ?> VNĐ</td>
                                            <td class="text-center">
                                                <span class="badge bg-info"><?= htmlspecialchars($order['status']) ?></span>
                                            </td>
                                            <td class="text-center">
                                                <a href="<?= BASE_URL ?>?controller=admin&action=edit-order&id=<?= $order['id'] ?>" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-edit"></i> Cập nhật
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-warning text-center">
                            <h5>Chưa có đơn hàng nào được ghi nhận.</h5>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="mt-4">
                <a href="<?= BASE_URL ?>?act=admin" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Quay lại danh sách sản phẩm
                </a>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>