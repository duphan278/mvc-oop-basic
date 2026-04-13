<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý đơn hàng</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Playfair Display', serif;
            font-weight: 600;
        }

        .card-title {
            font-family: 'Playfair Display', serif;
            font-weight: 500;
        }

        .actions-cell {
            min-width: 390px;
        }

        .order-actions {
            display: grid;
            grid-template-columns: 1fr auto 1fr auto 1fr;
            align-items: center;
            justify-items: center;
            gap: 8px;
            width: 100%;
        }

        .order-actions .btn {
            min-width: 116px;
            justify-content: center;
        }

        .action-divider {
            width: 1px;
            height: 28px;
            background: #d1d5db;
            border-radius: 999px;
        }

        .action-placeholder {
            min-width: 116px;
            height: 32px;
            visibility: hidden;
        }

        .filter-card {
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            background: #fff;
        }
        .order-products-wrap {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 10px;
        }
        .order-products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 10px;
        }
        .order-product-card {
            display: flex;
            gap: 10px;
            align-items: center;
            padding: 8px;
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
        }
        .order-product-thumb {
            width: 48px;
            height: 48px;
            border-radius: 8px;
            object-fit: cover;
            border: 1px solid #e2e8f0;
            flex-shrink: 0;
        }
        .order-product-name {
            font-weight: 600;
            font-size: 0.92rem;
            margin-bottom: 2px;
        }
        .order-product-meta {
            font-size: 0.82rem;
            color: #475569;
            line-height: 1.3;
        }
    </style>
</head>
<body>
    <?php include(PATH_ROOT . '/views/admin/topbar.php'); ?>

    <div class="d-flex" style="min-height:100vh; background-color: #f8f9fa;">
        <?php include(PATH_ROOT . '/views/admin/sidebar.php'); ?>

        <div class="container-fluid flex-grow-1 p-4 admin-main">
            <h1 class="mb-4 text-primary fw-bold">Quản lý đơn hàng</h1>

            <?php
                $buildQuery = function(array $overrides = []) {
                    $query = $_GET;
                    foreach ($overrides as $k => $v) {
                        if ($v === null) {
                            unset($query[$k]);
                        } else {
                            $query[$k] = $v;
                        }
                    }
                    return http_build_query($query);
                };
            ?>

            <div class="filter-card p-3 mb-3">
                <form method="GET" class="row g-2 align-items-end">
                    <input type="hidden" name="controller" value="admin">
                    <input type="hidden" name="action" value="list-orders">
                    <div class="col-lg-3 col-md-6">
                        <label class="form-label mb-1">Tìm kiếm</label>
                        <input type="text" name="q" value="<?= htmlspecialchars($filters['q'] ?? '') ?>" class="form-control" placeholder="Mã đơn / khách hàng / email">
                    </div>
                    <div class="col-lg-2 col-md-6">
                        <label class="form-label mb-1">Trạng thái</label>
                        <select name="status" class="form-select">
                            <option value="">Tất cả</option>
                            <?php foreach (['pending' => 'Pending', 'processing' => 'Processing', 'shipping' => 'Shipping', 'completed' => 'Completed', 'canceled' => 'Canceled'] as $v => $label): ?>
                                <option value="<?= $v ?>" <?= (($filters['status'] ?? '') === $v) ? 'selected' : '' ?>><?= $label ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-lg-2 col-md-6">
                        <label class="form-label mb-1">Từ ngày</label>
                        <input type="date" name="date_from" value="<?= htmlspecialchars($filters['date_from'] ?? '') ?>" class="form-control">
                    </div>
                    <div class="col-lg-2 col-md-6">
                        <label class="form-label mb-1">Đến ngày</label>
                        <input type="date" name="date_to" value="<?= htmlspecialchars($filters['date_to'] ?? '') ?>" class="form-control">
                    </div>
                    <div class="col-lg-1 col-md-6">
                        <label class="form-label mb-1">Min</label>
                        <input type="number" step="0.01" name="min_total" value="<?= htmlspecialchars($filters['min_total'] ?? '') ?>" class="form-control">
                    </div>
                    <div class="col-lg-1 col-md-6">
                        <label class="form-label mb-1">Max</label>
                        <input type="number" step="0.01" name="max_total" value="<?= htmlspecialchars($filters['max_total'] ?? '') ?>" class="form-control">
                    </div>
                    <div class="col-lg-2 col-md-6">
                        <label class="form-label mb-1">Sắp xếp</label>
                        <select name="sort" class="form-select">
                            <?php
                                $sortOptions = [
                                    'created_desc' => 'Mới nhất',
                                    'created_asc' => 'Cũ nhất',
                                    'amount_desc' => 'Giá trị giảm dần',
                                    'amount_asc' => 'Giá trị tăng dần',
                                    'id_desc' => 'Mã đơn giảm dần',
                                    'id_asc' => 'Mã đơn tăng dần',
                                ];
                            ?>
                            <?php foreach ($sortOptions as $key => $label): ?>
                                <option value="<?= $key ?>" <?= (($filters['sort'] ?? '') === $key) ? 'selected' : '' ?>><?= $label ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-lg-4 col-md-6 d-flex gap-2">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-filter me-1"></i>Lọc</button>
                        <a href="<?= BASE_URL ?>?controller=admin&action=list-orders" class="btn btn-outline-secondary">Đặt lại</a>
                        <a href="<?= BASE_URL ?>?<?= $buildQuery(['export' => 'csv', 'page' => null]) ?>" class="btn btn-success">
                            <i class="fas fa-file-csv me-1"></i>Export CSV
                        </a>
                    </div>
                </form>
            </div>
            
            <div class="card shadow-sm admin-fill-card">
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
                                                <?php
                                                $statusClasses = [
                                                    'pending' => 'bg-warning',
                                                    'processing' => 'bg-info',
                                                    'shipping' => 'bg-primary',
                                                    'completed' => 'bg-success',
                                                    'canceled' => 'bg-danger'
                                                ];
                                                $statusKey = strtolower($order['status']);
                                                $statusClass = $statusClasses[$statusKey] ?? 'bg-secondary';
                                                ?>
                                                <span class="badge <?= $statusClass ?>"><?= htmlspecialchars($order['status']) ?></span>
                                            </td>
                                            <td class="text-center actions-cell">
                                                <div class="order-actions">
                                                    <a href="<?= BASE_URL ?>?controller=admin&action=edit-order&id=<?= $order['id'] ?>" class="btn btn-sm btn-outline-primary d-inline-flex align-items-center">
                                                        <i class="fas fa-edit"></i> Cập nhật
                                                    </a>
                                                    <span class="action-divider" aria-hidden="true"></span>

                                                    <?php if ($order['status'] === 'pending'): ?>
                                                        <a href="<?= BASE_URL ?>?controller=admin&action=confirm-order&id=<?= $order['id'] ?>" class="btn btn-sm btn-success d-inline-flex align-items-center">
                                                            <i class="fas fa-check-circle"></i> Xác nhận
                                                        </a>
                                                    <?php elseif ($order['status'] === 'shipping'): ?>
                                                        <a href="<?= BASE_URL ?>?controller=admin&action=ship-order&id=<?= $order['id'] ?>" class="btn btn-sm btn-warning d-inline-flex align-items-center">
                                                            <i class="fas fa-truck"></i> Giao hàng
                                                        </a>
                                                    <?php else: ?>
                                                        <span class="action-placeholder" aria-hidden="true"></span>
                                                    <?php endif; ?>

                                                    <span class="action-divider" aria-hidden="true"></span>
                                                    <a href="<?= BASE_URL ?>?controller=admin&action=edit-order&id=<?= $order['id'] ?>#history" class="btn btn-sm btn-outline-secondary d-inline-flex align-items-center">
                                                        <i class="fas fa-clock-rotate-left"></i> Lịch sử
                                                    </a>
                                                    <a href="#order-items-<?= (int)$order['id'] ?>" data-bs-toggle="collapse" class="btn btn-sm btn-outline-dark d-inline-flex align-items-center">
                                                        <i class="fas fa-box-open"></i> Sản phẩm
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="collapse" id="order-items-<?= (int)$order['id'] ?>">
                                            <td colspan="7" class="bg-light-subtle">
                                                <?php $items = $orderItemsMap[(int)$order['id']] ?? []; ?>
                                                <?php if (!empty($items)): ?>
                                                    <div class="order-products-wrap">
                                                        <div class="order-products-grid">
                                                            <?php foreach ($items as $item): ?>
                                                                <?php $itemImage = resolveProductImage((string)($item['product_image'] ?? ''), [], (int)($item['product_id'] ?? 0)); ?>
                                                                <div class="order-product-card">
                                                                    <img src="<?= htmlspecialchars($itemImage) ?>" alt="<?= htmlspecialchars($item['product_name'] ?? '') ?>" class="order-product-thumb">
                                                                    <div>
                                                                        <div class="order-product-name"><?= htmlspecialchars($item['product_name'] ?? '') ?></div>
                                                                        <div class="order-product-meta">SL: <?= (int)($item['quantity'] ?? 0) ?> | Đơn giá: <?= number_format((float)($item['unit_price'] ?? 0), 0, ',', '.') ?> VNĐ</div>
                                                                        <div class="order-product-meta">Tạm tính: <?= number_format((float)($item['subtotal'] ?? 0), 0, ',', '.') ?> VNĐ</div>
                                                                    </div>
                                                                </div>
                                                            <?php endforeach; ?>
                                                        </div>
                                                    </div>
                                                <?php else: ?>
                                                    <div class="text-muted small">Đơn hàng chưa có dữ liệu sản phẩm.</div>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <?php if (($totalPages ?? 1) > 1): ?>
                            <nav class="mt-3">
                                <ul class="pagination justify-content-end mb-0">
                                    <?php $prevPage = max(1, (int)$page - 1); ?>
                                    <li class="page-item <?= ((int)$page <= 1) ? 'disabled' : '' ?>">
                                        <a class="page-link" href="<?= BASE_URL ?>?<?= $buildQuery(['page' => $prevPage]) ?>">Trước</a>
                                    </li>
                                    <?php for ($p = 1; $p <= (int)$totalPages; $p++): ?>
                                        <li class="page-item <?= ((int)$page === $p) ? 'active' : '' ?>">
                                            <a class="page-link" href="<?= BASE_URL ?>?<?= $buildQuery(['page' => $p]) ?>"><?= $p ?></a>
                                        </li>
                                    <?php endfor; ?>
                                    <?php $nextPage = min((int)$totalPages, (int)$page + 1); ?>
                                    <li class="page-item <?= ((int)$page >= (int)$totalPages) ? 'disabled' : '' ?>">
                                        <a class="page-link" href="<?= BASE_URL ?>?<?= $buildQuery(['page' => $nextPage]) ?>">Sau</a>
                                    </li>
                                </ul>
                            </nav>
                        <?php endif; ?>
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