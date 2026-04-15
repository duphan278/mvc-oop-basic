<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sản phẩm - Luxe Watches</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .product-grid-item {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            background: #fff;
            padding: 10px;
            height: 100%;
            display: flex;
            flex-direction: column;
            transition: all 0.3s ease;
        }
        .product-grid-item:hover {
            box-shadow: 0 10px 20px rgba(0,0,0,0.08);
            transform: translateY(-3px);
            border-color: #bbb;
        }
        .product-grid-item img {
            width: 100%;
            height: 220px;
            object-fit: cover;
            background: #f8f9fa;
        }
        .product-name {
            font-size: 0.95rem;
            height: 2.8em;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
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
            $rolexFallbackImages = [
                'https://images.unsplash.com/photo-1523170335258-f5ed11844a49?auto=format&fit=crop&w=900&q=80',
                'https://images.unsplash.com/photo-1547996160-81dfa63595aa?auto=format&fit=crop&w=900&q=80',
                'https://images.unsplash.com/photo-1522312346375-d1a52e2b99b3?auto=format&fit=crop&w=900&q=80'
            ];
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
        <?php if (empty($products)): ?>
            <div class="alert alert-warning">
                Không tìm thấy sản phẩm phù hợp.
            </div>
        <?php endif; ?>

        <div class="row justify-content-center">
            <?php foreach ($products as $product): ?>
                <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                    <div class="product-grid-item">
                        <a href="<?= BASE_URL ?>?controller=user&action=detail&id=<?= $product['id'] ?>">
                            <?php $productImage = resolveProductImage($product['image'] ?? '', $rolexFallbackImages, (int)($product['id'] ?? 0)); ?>
                            <img src="<?= htmlspecialchars($productImage) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="img-fluid">
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
                        <div class="mt-auto pt-3 d-flex gap-2">
                            <a href="<?= BASE_URL ?>?controller=user&action=detail&id=<?= $product['id'] ?>"
                               class="btn btn-sm btn-outline-secondary flex-grow-1">
                                <i class="fas fa-eye me-1"></i> Chi tiết
                            </a>
                            <a href="<?= BASE_URL ?>?controller=user&action=addToCart&id=<?= $product['id'] ?>"
                               class="btn btn-sm btn-danger flex-grow-1">
                                <i class="fas fa-cart-plus me-1"></i> Giỏ hàng
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