<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <?php include(PATH_ROOT . 'views/components/navbar.php'); ?>

    <div class="d-flex" style="min-height:100vh; background-color: #f8f9fa;">
        <?php include(PATH_ROOT . 'views/admin/sidebar.php'); ?>

        <div class="container flex-grow-1 p-4">
            <div class="row">
                <div class="col-12">
                    <h1 class="mb-4 text-primary fw-bold">Trang Admin</h1>
                    <h3 class="mb-4 text-secondary">Quản lý sản phẩm</h3>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <p class="mb-0">Danh sách sản phẩm hiện tại</p>
                        <a href="<?= BASE_URL ?>?controller=admin&action=create" class="btn btn-success">
                            <i class="fas fa-plus"></i> Thêm sản phẩm mới
                        </a>
                    </div>

                    <?php if (!empty($products)): ?>
                        <div class="table-responsive">
                            <table class="table table-hover table-striped table-bordered shadow-sm">
                                <thead class="table-dark">
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>Tên sản phẩm</th>
                                        <th>Thể loại</th>
                                        <th class="text-end">Giá (VNĐ)</th>
                                        <th>Mô tả</th>
                                        <th class="text-center">Ảnh</th>

                                        <th class="text-center">Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $stt = 1; foreach ($products as $product): ?>
                                        <tr>
                                            <td class="text-center fw-bold"><?= $stt++ ?></td>
                                            <td class="fw-semibold"><?= htmlspecialchars($product['name']) ?></td>
                                            <td><?= htmlspecialchars($product['category_name'] ?? 'N/A') ?></td>
                                            <td class="text-end text-success fw-bold"><?= htmlspecialchars(number_format($product['price'], 0, ',', '.')) ?> VNĐ</td>
                                            <td>
                                                <div style="max-height: 60px; overflow: hidden; text-overflow: ellipsis;">
                                                    <?= $product['description'] ?? '' ?>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <?php if (!empty($product['image'])): ?>
                                                    <img src="/uploads/<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="img-thumbnail" style="max-width: 80px; max-height: 80px;" />
                                                <?php else: ?>
                                                    <span class="text-muted">Không có ảnh</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group" role="group">
                                                    <a href="<?= BASE_URL ?>?controller=admin&action=detail&id=<?= $product['id'] ?>" class="btn btn-sm btn-outline-info" title="Xem chi tiết">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="<?= BASE_URL ?>?controller=admin&action=edit&id=<?= $product['id'] ?>" class="btn btn-sm btn-outline-warning" title="Chỉnh sửa">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="<?= BASE_URL ?>?controller=admin&action=delete&id=<?= $product['id'] ?>" class="btn btn-sm btn-outline-danger" title="Xóa" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info text-center">
                            <i class="fas fa-info-circle fa-2x mb-3"></i>
                            <h5>Chưa có sản phẩm nào</h5>
                            <p>Hãy thêm sản phẩm đầu tiên để bắt đầu quản lý.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <style>
        .sidebar-link {
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
        }
        .sidebar-link:hover {
            background-color: rgba(255, 255, 255, 0.1) !important;
            border-left-color: #007bff;
            transform: translateX(5px);
        }
        .table th {
            vertical-align: middle;
        }
        .table td {
            vertical-align: middle;
        }
        .btn-group .btn {
            margin-right: 2px;
        }
        .alert-info {
            border-radius: 10px;
        }
        @media (max-width: 768px) {
            nav {
                width: 100% !important;
                min-height: auto;
            }
            .d-flex {
                flex-direction: column;
            }
            .table-responsive {
                font-size: 0.9rem;
            }
        }
    </style>
    <script>
        document.querySelectorAll('nav ul li > a').forEach(menu => {
            const sibling = menu.nextElementSibling;
            if (sibling && (sibling.tagName === 'UL' || sibling.tagName === 'DIV')) {
                menu.addEventListener('click', function(e) {
                    e.preventDefault();
                    sibling.style.display = (sibling.style.display === 'block') ? 'none' : 'block';
                });
            }
        });
    </script>
</body>
</html>