<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trạng thái đơn hàng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .alert-dark-strong {
            background-color: #2e2e2e;
            color: #f8f9fa;
            border-color: #444;
        }
        .status-time {
            background: #212529;
            color: #e9ecef;
            padding: 2px 8px;
            border-radius: 8px;
            font-size: 0.85rem;
        }
        .status-history li {
            border-left: 3px solid #444;
            padding-left: 10px;
        }
    </style>
</head>
<body>
    <?php include PATH_ROOT . '/views/components/navbar.php'; ?>
    <div class="container mt-5">
        <h2 class="mb-4">Tra cứu trạng thái đơn hàng</h2>

        <?php if (!empty($message)): ?>
            <div class="alert alert-dark-strong"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

        <?php if (isset($_GET['message']) && $_GET['message'] === 'order_canceled'): ?>
            <div class="alert alert-dark-strong">Đơn hàng đã được hủy thành công.</div>
        <?php endif; ?>

        <?php if (isset($_GET['error']) && $_GET['error'] === 'cannot_cancel'): ?>
            <div class="alert alert-dark-strong">Không thể hủy đơn hàng hiện tại.</div>
        <?php endif; ?>

        <form method="POST" class="row g-3 mb-4">
            <div class="col-md-4">
                <input type="number" name="order_id" class="form-control" placeholder="Nhập mã đơn hàng" value="<?= isset($_GET['order_id']) ? (int)$_GET['order_id'] : '' ?>" required>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Tra cứu</button>
            </div>
        </form>

        <?php if ($order): ?>
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Đơn hàng #<?= htmlspecialchars((string)($order['id'] ?? '')) ?></h5>
                    <p><strong>Ngày đặt:</strong> <?= htmlspecialchars($order['created_at'] ?? '') ?></p>
                    <p><strong>Trạng thái:</strong> 
                        <?php
                        $statusClasses = [
                            'pending' => 'bg-warning',
                            'shipping' => 'bg-primary',
                            'completed' => 'bg-success',
                            'canceled' => 'bg-danger',
                            'processing' => 'bg-info'
                        ];
                        $statusKey = strtolower((string)($order['status'] ?? ''));
                        $statusClass = $statusClasses[$statusKey] ?? 'bg-secondary';
                        ?>
                        <span class="badge <?= $statusClass ?>"><?= htmlspecialchars($order['status'] ?? '') ?></span>
                    </p>
                    <p><strong>Tổng tiền:</strong> <?= number_format($order['total_amount'],0,',','.') ?> đ</p>
                    <?php if (!empty($order['discount_amount']) && $order['discount_amount'] > 0): ?>
                        <p><strong>Giảm giá:</strong> -<?= number_format($order['discount_amount'],0,',','.') ?> đ</p>
                    <?php endif; ?>
                    <p><strong>Phương thức:</strong> <?= htmlspecialchars($order['payment_method'] ?? '') ?><?php if (!empty($order['bank'])): ?> (<?= htmlspecialchars($order['bank']) ?>)<?php endif; ?></p>
                    <p><strong>Họ tên:</strong> <?= htmlspecialchars($order['contact_name'] ?? '') ?></p>
                    <p><strong>SĐT:</strong> <?= htmlspecialchars($order['contact_phone'] ?? '') ?></p>
                    <p><strong>Địa chỉ:</strong> <?= nl2br(htmlspecialchars($order['shipping_address'] ?? '')) ?></p>

                    <?php if (in_array((string)($order['status'] ?? ''), ['pending', 'processing'], true)): ?>
                        <a href="<?= BASE_URL ?>?controller=user&action=cancel-order&id=<?= $order['id'] ?>" class="btn btn-danger mb-3">Hủy đơn</a>
                    <?php endif; ?>
                </div>
            </div>

            <?php if (!empty($statusHistory)): ?>
                <div class="card mb-4">
                    <div class="card-header">Lịch sử trạng thái</div>
                    <div class="card-body">
                        <ul class="timeline list-unstyled mb-0">
                            <?php foreach ($statusHistory as $h): ?>
                                <li class="mb-2 status-history">
                                    <span class="badge bg-dark text-light"><?= htmlspecialchars($h['status'] ?? '') ?></span>
                                    <small class="status-time"><?= htmlspecialchars(!empty($h['changed_at']) ? date('d/m/Y H:i', strtotime($h['changed_at'])) : '') ?></small>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (!empty($orderItems)): ?>
                <div class="card mb-4">
                    <div class="card-header">Chi tiết sản phẩm</div>
                    <div class="card-body p-0">
                        <table class="table mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Sản phẩm</th>
                                    <th class="text-center">Số lượng</th>
                                    <th class="text-end">Đơn giá</th>
                                    <th class="text-end">Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($orderItems as $item): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($item['product_name'] ?? '') ?></td>
                                        <td class="text-center"><?= (int)$item['quantity'] ?></td>
                                        <td class="text-end"><?= number_format($item['unit_price'],0,',','.') ?> đ</td>
                                        <td class="text-end"><?= number_format($item['subtotal'],0,',','.') ?> đ</td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <h3 class="mb-3">Đơn hàng của bạn</h3>
        <?php if (!empty($orders)): ?>
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Mã ĐH</th>
                        <th>Ngày</th>
                        <th>Trạng thái</th>
                        <th class="text-end">Tổng tiền</th>
                        <th class="text-center">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $o): ?>
                        <tr>
                            <td>#<?= htmlspecialchars((string)($o['id'] ?? '')) ?></td>
                            <td><?= htmlspecialchars(!empty($o['created_at']) ? date('d/m/Y H:i', strtotime($o['created_at'])) : '') ?></td>
                            <td><span class="badge bg-secondary"><?= htmlspecialchars($o['status'] ?? '') ?></span></td>
                            <td class="text-end"><?= number_format($o['total_amount'],0,',','.') ?> đ</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2 flex-wrap">
                                    <a href="<?= BASE_URL ?>?controller=user&action=order-status&order_id=<?= (int)$o['id'] ?>" class="btn btn-sm btn-outline-primary">
                                        Chi tiết
                                    </a>
                                    <?php if (in_array((string)($o['status'] ?? ''), ['pending', 'processing'], true)): ?>
                                        <a href="<?= BASE_URL ?>?controller=user&action=cancel-order&id=<?= (int)$o['id'] ?>"
                                           class="btn btn-sm btn-danger"
                                           onclick="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này?');">
                                            Hủy đơn
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted small align-self-center">Không thể hủy</span>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="alert alert-info">Bạn chưa có đơn hàng nào.</div>
        <?php endif; ?>

        <a href="<?= BASE_URL ?>?controller=user&action=products" class="btn btn-outline-secondary mt-3">Quay lại cửa hàng</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>