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

        <div class="container-fluid flex-grow-1 p-4 admin-main">
            <div class="row">
                <div class="col-12">
                    <div class="card shadow border-0 admin-fill-card">
                        <div class="card-header bg-primary text-white">
                            <h4 class="mb-0"><i class="fas fa-edit me-2"></i>Cập nhật đơn hàng #<?= $order['id'] ?></h4>
                        </div>
                        <div class="card-body p-4">
                            <?php if (!empty($errorMessage)): ?>
                                <div class="alert alert-warning"><?= htmlspecialchars($errorMessage) ?></div>
                            <?php endif; ?>
                            <div class="row g-4">
                                <div class="col-xl-8">
                                    <form method="POST">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="shipping_fee" class="form-label fw-bold">Phí vận chuyển (VNĐ)</label>
                                                <div class="input-group">
                                                    <input type="number" name="shipping_fee" id="shipping_fee" class="form-control"
                                                           value="<?= $order['total_amount'] > 10000000 ? 0 : (int)$order['shipping_fee'] ?>"
                                                           required <?= $order['total_amount'] > 10000000 ? 'readonly' : '' ?>>
                                                    <span class="input-group-text">VNĐ</span>
                                                </div>
                                                <?php if ($order['total_amount'] > 10000000): ?>
                                                    <small class="text-success"><i class="fas fa-check-circle"></i> Đơn hàng trên 10 triệu: Đã tự động miễn phí vận chuyển.</small>
                                                <?php endif; ?>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="status" class="form-label fw-bold">Trạng thái đơn hàng</label>
                                                <select name="status" id="status" class="form-select">
                                                    <?php
                                                        $statusLabels = [
                                                            'pending' => 'Chờ xử lý (Pending)',
                                                            'processing' => 'Đang xử lý (Processing)',
                                                            'shipping' => 'Đang giao (Shipping)',
                                                            'completed' => 'Hoàn thành (Completed)',
                                                            'canceled' => 'Đã hủy (Canceled)',
                                                        ];
                                                    ?>
                                                    <?php foreach (($allowedStatusOptions ?? []) as $statusOption): ?>
                                                        <option value="<?= htmlspecialchars($statusOption) ?>" <?= $order['status'] == $statusOption ? 'selected' : '' ?>>
                                                            <?= htmlspecialchars($statusLabels[$statusOption] ?? $statusOption) ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <small class="text-muted">Đơn đã xác nhận sẽ không thể chuyển về trạng thái trước đó.</small>
                                            </div>
                                        </div>

                                        <div class="d-flex gap-2 mt-2">
                                            <button type="submit" class="btn btn-success">
                                                <i class="fas fa-save me-1"></i> Lưu thay đổi
                                            </button>
                                            <a href="<?= BASE_URL ?>?controller=admin&action=list-orders" class="btn btn-secondary">Hủy</a>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-xl-4">
                                    <div class="border rounded p-3 h-100 bg-light">
                                        <h6 class="fw-bold mb-3"><i class="fas fa-receipt me-1"></i> Thông tin đơn hàng</h6>
                                        <p class="mb-2"><strong>Khách hàng:</strong> <?= htmlspecialchars($order['fullname']) ?></p>
                                        <p class="mb-2"><strong>Tổng tiền hàng:</strong> <?= number_format($order['total_amount'], 0, ',', '.') ?> VNĐ</p>
                                        <p class="mb-2"><strong>Trạng thái hiện tại:</strong> <?= htmlspecialchars($order['status']) ?></p>
                                        <p class="mb-0"><strong>Mã đơn:</strong> #<?= (int)$order['id'] ?></p>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4" id="history">
                                <h5 class="fw-bold mb-3"><i class="fas fa-clock-rotate-left me-2"></i>Lịch sử trạng thái</h5>
                                <div class="table-responsive">
                                    <table class="table table-sm table-striped align-middle">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Thời gian</th>
                                                <th>Trạng thái</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($statusHistory)): ?>
                                                <?php foreach ($statusHistory as $h): ?>
                                                    <tr>
                                                        <td><?= date('d/m/Y H:i:s', strtotime($h['changed_at'])) ?></td>
                                                        <td><span class="badge bg-secondary"><?= htmlspecialchars($h['status']) ?></span></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="2" class="text-muted">Chưa có dữ liệu lịch sử.</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>