<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cập nhật đơn hàng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <?php include(PATH_ROOT . '/views/admin/topbar.php'); ?>

    <div class="d-flex" style="min-height:100vh; background-color: #f8f9fa;">
        <?php include(PATH_ROOT . '/views/admin/sidebar.php'); ?>

        <div class="container flex-grow-1 p-4">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="card shadow border-0">
                        <div class="card-header bg-primary text-white">
                            <h4 class="mb-0"><i class="fas fa-edit me-2"></i>Cập nhật đơn hàng #<?= $order['id'] ?></h4>
                        </div>
                        <div class="card-body p-4">
                            <p><strong>Khách hàng:</strong> <?= htmlspecialchars($order['fullname']) ?></p>
                            <p><strong>Tổng tiền hàng:</strong> <?= number_format($order['total_amount'], 0, ',', '.') ?> VNĐ</p>
                            <hr>
                            <form method="POST">
                                <div class="mb-3">
                                    <label for="shipping_fee" class="form-label fw-bold">Phí vận chuyển (VNĐ)</label>
                                    <div class="input-group">
                                        <input type="number" name="shipping_fee" id="shipping_fee" class="form-control"
                                               value="<?= $order['total_amount'] > 10000000 ? 0 : (int)$order['shipping_fee'] ?>"
                                               required <?= $order['total_amount'] > 10000000 ? 'readonly' : '' ?>>
                                        <span class="input-group-text">VNĐ</span>
                                    </div>
                                    <?php if ($order['total_amount'] > 10000000): ?>
                                        <small class="text-success"><i class="fas fa-check-circle"></i> Đơn hàng trên 10 triệu: Đã tự động áp dụng Miễn phí vận chuyển.</small>
                                    <?php endif; ?>
                                </div>

                                <div class="mb-4">
                                    <label for="status" class="form-label fw-bold">Trạng thái đơn hàng</label>
                                    <select name="status" id="status" class="form-select">
                                        <option value="pending" <?= $order['status'] == 'pending' ? 'selected' : '' ?>>Chờ xử lý (Pending)</option>
                                        <option value="processing" <?= $order['status'] == 'processing' ? 'selected' : '' ?>>Đang xử lý (Processing)</option>
                                        <option value="completed" <?= $order['status'] == 'completed' ? 'selected' : '' ?>>Hoàn thành (Completed)</option>
                                        <option value="canceled" <?= $order['status'] == 'canceled' ? 'selected' : '' ?>>Đã hủy (Canceled)</option>
                                    </select>
                                </div>

                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-save me-1"></i> Lưu thay đổi
                                    </button>
                                    <a href="<?= BASE_URL ?>?controller=admin&action=list-orders" class="btn btn-secondary">Hủy</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>