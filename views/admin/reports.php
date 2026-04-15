<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Báo cáo thống kê</title>
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

        .report-card {
            border-radius: 16px;
            overflow: hidden;
        }

        .report-kpi {
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            background: #fff;
            height: 100%;
            box-shadow: 0 8px 22px rgba(15, 23, 42, 0.06);
        }

        .report-kpi .kpi-label {
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: #64748b;
            font-weight: 700;
        }

        .report-kpi .kpi-value {
            font-size: 1.7rem;
            font-weight: 800;
            color: #0f172a;
            line-height: 1.2;
        }

        .report-kpi .kpi-sub {
            font-size: 0.85rem;
            color: #64748b;
        }

        .status-chip {
            padding: 0.35rem 0.65rem;
            border-radius: 999px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: capitalize;
        }

        .status-pending { background: #fef3c7; color: #92400e; }
        .status-shipping { background: #dbeafe; color: #1d4ed8; }
        .status-completed { background: #dcfce7; color: #166534; }
        .status-canceled { background: #fee2e2; color: #991b1b; }
        .status-default { background: #e2e8f0; color: #334155; }

        .donut-wrap {
            display: flex;
            flex-wrap: wrap;
            gap: 18px;
            justify-content: center;
        }

        .donut-card {
            text-align: center;
            min-width: 140px;
        }

        .donut {
            --size: 110px;
            --thickness: 14px;
            --p1: 0;
            --p2: 0;
            --p3: 0;
            --p4: 0;
            width: var(--size);
            height: var(--size);
            border-radius: 50%;
            margin: 0 auto 10px;
            background:
                conic-gradient(
                    #22c55e 0 calc(var(--p1) * 1%),
                    #f59e0b calc(var(--p1) * 1%) calc((var(--p1) + var(--p2)) * 1%),
                    #3b82f6 calc((var(--p1) + var(--p2)) * 1%) calc((var(--p1) + var(--p2) + var(--p3)) * 1%),
                    #ef4444 calc((var(--p1) + var(--p2) + var(--p3)) * 1%) 100%
                );
            position: relative;
            box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.6), 0 8px 20px rgba(15, 23, 42, 0.1);
            transition: transform 0.25s ease;
        }

        .donut:hover {
            transform: translateY(-2px) scale(1.02);
        }

        .donut::before {
            content: "";
            position: absolute;
            inset: var(--thickness);
            background: #fff;
            border-radius: 50%;
        }

        .donut-value {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            color: #0f172a;
            font-size: 1rem;
            z-index: 2;
        }

        .legend-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 6px;
        }

        .trend-chart {
            display: grid;
            grid-template-columns: repeat(7, minmax(40px, 1fr));
            gap: 10px;
            align-items: end;
            min-height: 230px;
            padding: 10px 4px 0;
        }

        .trend-col {
            text-align: center;
        }

        .trend-bar-wrap {
            height: 160px;
            display: flex;
            align-items: end;
            justify-content: center;
        }

        .trend-bar {
            width: 26px;
            border-radius: 10px 10px 6px 6px;
            background: linear-gradient(180deg, #3b82f6 0%, #1d4ed8 100%);
            box-shadow: 0 8px 16px rgba(59, 130, 246, 0.24);
            height: 8px;
            transition: height 0.9s ease;
        }

        .trend-label {
            margin-top: 8px;
            font-size: 0.78rem;
            color: #64748b;
            font-weight: 600;
        }

        .trend-value {
            font-size: 0.72rem;
            color: #334155;
            font-weight: 700;
            margin-bottom: 6px;
        }
    </style>
</head>
<body>
    <?php include(PATH_ROOT . '/views/admin/topbar.php'); ?>

    <div class="d-flex" style="min-height:100vh; background-color: #f8f9fa;">
        <?php include(PATH_ROOT . '/views/admin/sidebar.php'); ?>

        <div class="container-fluid flex-grow-1 p-4 admin-main">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-4">
                <h1 class="mb-0 text-primary fw-bold">Báo cáo tổng quát hệ thống</h1>
                <div class="d-flex align-items-center gap-2">
                    <span class="text-muted small">Cập nhật theo dữ liệu hiện tại</span>
                    <a href="<?= BASE_URL ?>?controller=admin&action=reports&export=csv" class="btn btn-sm btn-success">
                        <i class="fas fa-file-export me-1"></i>Export báo cáo
                    </a>
                </div>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-xl-3 col-md-6">
                    <div class="report-kpi p-3">
                        <div class="kpi-label mb-2">Tổng doanh thu</div>
                        <div class="kpi-value"><?= number_format($totalRevenue, 0, ',', '.') ?> VNĐ</div>
                        <div class="kpi-sub mt-2"><i class="fas fa-chart-line me-1"></i> Doanh thu đơn hoàn thành</div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="report-kpi p-3">
                        <div class="kpi-label mb-2">Tổng đơn hàng</div>
                        <div class="kpi-value"><?= (int)$totalOrders ?></div>
                        <div class="kpi-sub mt-2"><i class="fas fa-shopping-bag me-1"></i> Toàn bộ đơn trong hệ thống</div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="report-kpi p-3">
                        <div class="kpi-label mb-2">Đơn hôm nay</div>
                        <div class="kpi-value"><?= (int)$todayOrders ?></div>
                        <div class="kpi-sub mt-2"><i class="fas fa-calendar-day me-1"></i> Phát sinh trong ngày</div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="report-kpi p-3">
                        <div class="kpi-label mb-2">Giá trị trung bình / đơn</div>
                        <div class="kpi-value"><?= number_format($avgOrderValue, 0, ',', '.') ?> VNĐ</div>
                        <div class="kpi-sub mt-2"><i class="fas fa-scale-balanced me-1"></i> Trung bình toàn kỳ</div>
                    </div>
                </div>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-xl-3 col-md-6">
                    <div class="report-kpi p-3">
                        <div class="kpi-label mb-2">Tổng người dùng</div>
                        <div class="kpi-value"><?= (int)$totalUsers ?></div>
                        <div class="kpi-sub mt-2"><i class="fas fa-users me-1"></i> Tài khoản đã đăng ký</div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="report-kpi p-3">
                        <div class="kpi-label mb-2">Tổng sản phẩm</div>
                        <div class="kpi-value"><?= (int)$totalProducts ?></div>
                        <div class="kpi-sub mt-2"><i class="fas fa-box-open me-1"></i> Danh mục đang bán</div>
                    </div>
                </div>
                <div class="col-xl-6 col-md-12">
                    <div class="report-kpi p-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div class="kpi-label mb-0">Xu hướng 7 ngày</div>
                            <span class="badge text-bg-light">Dữ liệu thật từ đơn hàng</span>
                        </div>
                        <div class="trend-chart">
                            <?php
                                $maxRevenue = !empty($dailyRevenue) ? max($dailyRevenue) : 0;
                                $maxRevenue = $maxRevenue > 0 ? $maxRevenue : 1;
                                foreach ($dailyLabels as $idx => $label):
                                    $rev = (float)($dailyRevenue[$idx] ?? 0);
                                    $barHeight = max(8, (int)round(($rev / $maxRevenue) * 160));
                            ?>
                                <div class="trend-col">
                                    <div class="trend-value"><?= number_format($rev, 0, ',', '.') ?></div>
                                    <div class="trend-bar-wrap">
                                        <div class="trend-bar" data-height="<?= $barHeight ?>"></div>
                                    </div>
                                    <div class="trend-label"><?= htmlspecialchars($label) ?></div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-xl-4">
                    <div class="card report-card shadow-sm h-100">
                        <div class="card-header bg-white fw-bold">Hiệu suất hôm nay</div>
                        <div class="card-body">
                            <p class="mb-2 text-muted">Doanh thu hoàn thành hôm nay</p>
                            <h4 class="mb-3 text-success"><?= number_format($todayRevenue, 0, ',', '.') ?> VNĐ</h4>
                            <?php $completionRate = $totalOrders > 0 ? round(($completedOrders / $totalOrders) * 100) : 0; ?>
                            <p class="mb-1 fw-semibold">Tỷ lệ hoàn thành: <?= $completionRate ?>%</p>
                            <div class="progress" role="progressbar" aria-label="Completion rate">
                                <div class="progress-bar bg-success" style="width: <?= $completionRate ?>%"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-8">
                    <div class="card report-card shadow-sm h-100">
                        <div class="card-header bg-white fw-bold">Bánh xe trạng thái đơn hàng</div>
                        <div class="card-body">
                            <?php
                                $totalSafe = max((int)$totalOrders, 1);
                                $pCompleted = round(($completedOrders / $totalSafe) * 100, 1);
                                $pPending = round(($pendingOrders / $totalSafe) * 100, 1);
                                $pShipping = round(($shippingOrders / $totalSafe) * 100, 1);
                                $pCanceled = round(($canceledOrders / $totalSafe) * 100, 1);
                            ?>
                            <div class="donut-wrap">
                                <div class="donut-card">
                                    <div class="donut" style="--p1:<?= $pCompleted ?>;--p2:<?= $pPending ?>;--p3:<?= $pShipping ?>;--p4:<?= $pCanceled ?>;">
                                        <div class="donut-value"><?= (int)$totalOrders ?></div>
                                    </div>
                                    <div class="small fw-semibold">Tổng đơn</div>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span><span class="legend-dot" style="background:#22c55e;"></span>Hoàn thành</span>
                                        <strong><?= (int)$completedOrders ?> (<?= $pCompleted ?>%)</strong>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span><span class="legend-dot" style="background:#f59e0b;"></span>Đang chờ</span>
                                        <strong><?= (int)$pendingOrders ?> (<?= $pPending ?>%)</strong>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span><span class="legend-dot" style="background:#3b82f6;"></span>Đang giao</span>
                                        <strong><?= (int)$shippingOrders ?> (<?= $pShipping ?>%)</strong>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span><span class="legend-dot" style="background:#ef4444;"></span>Đã hủy</span>
                                        <strong><?= (int)$canceledOrders ?> (<?= $pCanceled ?>%)</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card report-card shadow-sm admin-fill-card">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-history me-2"></i>Đơn hàng gần đây</h5>
                    <a href="<?= BASE_URL ?>?controller=admin&action=list-orders" class="btn btn-sm btn-outline-primary">Xem tất cả</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Mã ĐH</th>
                                    <th>Khách hàng</th>
                                    <th>Ngày đặt</th>
                                    <th class="text-end">Tổng tiền</th>
                                    <th class="text-center">Trạng thái</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($recentOrders)): ?>
                                    <?php foreach ($recentOrders as $order): ?>
                                        <?php
                                            $status = strtolower((string)$order['status']);
                                            $statusClass = 'status-default';
                                            if ($status === 'pending') $statusClass = 'status-pending';
                                            if ($status === 'shipping') $statusClass = 'status-shipping';
                                            if ($status === 'completed') $statusClass = 'status-completed';
                                            if ($status === 'canceled') $statusClass = 'status-canceled';
                                        ?>
                                        <tr>
                                            <td>#<?= (int)$order['id'] ?></td>
                                            <td><?= htmlspecialchars($order['fullname']) ?></td>
                                            <td><?= date('d/m/Y H:i', strtotime($order['created_at'])) ?></td>
                                            <td class="text-end fw-bold"><?= number_format($order['total_amount'], 0, ',', '.') ?> VNĐ</td>
                                            <td class="text-center">
                                                <span class="status-chip <?= $statusClass ?>"><?= htmlspecialchars($order['status']) ?></span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-4">Chưa có dữ liệu đơn hàng.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelectorAll('.trend-bar').forEach(function (bar) {
            const h = bar.getAttribute('data-height') || 8;
            requestAnimationFrame(function () {
                bar.style.height = h + 'px';
            });
        });
    </script>
</body>
</html>