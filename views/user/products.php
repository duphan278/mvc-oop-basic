<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sản phẩm - Luxe Watches</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .product-grid-item {
            border: 1px solid #eee;
            background: #fff;
            padding: 10px;
            height: 100%;
        }
        .product-grid-item img {
            width: 100%;
            height: 220px;
            object-fit: cover;
        }
        .product-name {
            font-size: 0.95rem;
            min-height: 42px;
        }
        .product-price {
            color: #d0021b;
            font-weight: 700;
        }
        .product-meta {
            font-size: 0.8rem;
            color: #666;
        }
        .content-wrap {
            max-width: 1220px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <?php include PATH_ROOT . '/views/components/navbar.php'; ?>
    <div class="container-fluid mt-3">
        <div class="content-wrap">
        <?php
            $categories = (new Category())->getAll();
            $currentCat = $_GET['id'] ?? '';
        ?>

        <!-- Dải thương hiệu / danh mục ở trên cùng -->
        <div class="bg-light border rounded px-3 py-2 mb-3">
            <div class="d-flex flex-wrap align-items-center gap-2">
                <span class="fw-bold me-2">Thương hiệu:</span>
                <a href="<?= BASE_URL ?>?controller=user&action=products"
                   class="btn btn-sm <?= $currentCat === '' ? 'btn-warning' : 'btn-outline-secondary' ?>">
                    Tất cả
                </a>
                <?php foreach ($categories as $cat): ?>
                    <a href="<?= BASE_URL ?>?controller=user&action=products&id=<?= $cat['id'] ?>"
                       class="btn btn-sm <?= $currentCat == $cat['id'] ? 'btn-warning' : 'btn-outline-secondary' ?>">
                        <?= htmlspecialchars($cat['name']) ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>

        <h5 class="mb-3">Đồng hồ chính hãng</h5>

        <div class="row justify-content-center">
            <?php foreach ($products as $product): ?>
                <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                    <div class="product-grid-item">
                        <a href="<?= BASE_URL ?>?controller=user&action=detail&id=<?= $product['id'] ?>">
                            <img src="<?= BASE_URL . $product['image'] ?>" alt="<?= htmlspecialchars($product['name']) ?>">
                        </a>
                        <div class="mt-2 product-name">
                            <a href="<?= BASE_URL ?>?controller=user&action=detail&id=<?= $product['id'] ?>"
                               class="text-decoration-none text-dark">
                                <?= htmlspecialchars($product['name']) ?>
                            </a>
                        </div>
                        <div class="product-price mt-1">
                            <?= number_format($product['price'], 0, ',', '.') ?> VND
                        </div>
                        <div class="product-meta mt-1">
                            Danh mục: <?= htmlspecialchars($product['category_name'] ?? 'N/A') ?>
                        </div>
                        <div class="mt-2 d-flex gap-2">
                            <a href="<?= BASE_URL ?>?controller=user&action=detail&id=<?= $product['id'] ?>"
                               class="btn btn-sm btn-outline-secondary">
                                Xem chi tiết
                            </a>
                            <a href="<?= BASE_URL ?>?controller=user&action=addToCart&id=<?= $product['id'] ?>"
                               class="btn btn-sm btn-danger">
                                Thêm vào giỏ
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        </div>
    </div>
</body>
</html>