<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết sản phẩm - Luxe Watches</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --accent-gold: #b8860b;
            --text-primary: #1a1a1a;
            --light-gray: #f8f9fa;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            line-height: 1.7;
            color: var(--text-primary);
            background-color: #fff;
        }

        .detail-container {
            padding: 60px 0;
        }

        h1 {
            font-family: 'Playfair Display', serif;
            font-weight: 600;
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
            color: var(--primary-color);
        }

        .category-label {
            text-transform: uppercase;
            letter-spacing: 2px;
            font-size: 0.85rem;
            color: #888;
            margin-bottom: 1.5rem;
            display: block;
        }

        .product-image-wrapper {
            overflow: hidden;
            border-radius: 12px;
            background: var(--light-gray);
            transition: all 0.5s ease;
        }

        .product-image-wrapper img {
            transition: transform 0.5s ease;
            mix-blend-mode: multiply;
        }

        .product-image-wrapper:hover img {
            transform: scale(1.05);
        }

        .price-display {
            font-size: 1.8rem;
            font-weight: 700;
            color: #d0021b;
            margin: 1.5rem 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .description-box {
            background: #ffffff;
            padding: 18px 20px;
            border-radius: 14px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 8px 24px rgba(15, 23, 42, 0.08);
            margin-bottom: 2rem;
        }
        .description-box p {
            margin: 0;
            color: #475569 !important;
            font-size: 1.02rem;
            line-height: 1.75;
        }

        .action-group {
            display: flex;
            gap: 15px;
            margin-top: 2rem;
        }

        .btn {
            font-weight: 500;
            border-radius: 8px;
            padding: 12px 25px;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 0.9rem;
        }

        .btn-cart {
            background-color: var(--primary-color);
            color: white;
            flex: 2;
        }

        .btn-cart:hover {
            background-color: #1a252f;
            color: white;
            text-decoration: none;
            transform: translateY(-2px);
        }

        .back-to-list {
            display: inline-flex;
            align-items: center;
            margin-top: 30px;
            color: #6c757d;
            transition: all 0.3s ease;
        }
        .back-to-list:hover {
            color: var(--primary-color);
            transform: translateX(-5px);
        }
        .comments-section-title {
            font-family: 'Inter', sans-serif;
            font-size: 1.85rem;
            font-weight: 700;
            letter-spacing: -0.2px;
        }
        .comment-item {
            display: flex;
            gap: 12px;
            margin-bottom: 14px;
            align-items: flex-start;
        }
        .comment-avatar {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: linear-gradient(135deg, #2c3e50, #3f5a75);
            color: #fff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.95rem;
            flex-shrink: 0;
            text-transform: uppercase;
        }
        .comment-bubble {
            flex: 1;
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            padding: 12px 14px;
            box-shadow: 0 6px 20px rgba(15, 23, 42, 0.06);
        }
        .comment-head {
            display: flex;
            justify-content: space-between;
            gap: 8px;
            margin-bottom: 6px;
            align-items: baseline;
        }
        .comment-author {
            font-weight: 700;
            color: #0f172a;
            font-size: 0.95rem;
        }
        .comment-time {
            font-size: 0.78rem;
            color: #64748b;
            white-space: nowrap;
        }
        .comment-content {
            color: #334155;
            line-height: 1.55;
            font-size: 0.95rem;
            word-break: break-word;
        }
        .comment-composer {
            margin-top: 22px;
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 16px;
            padding: 14px;
            box-shadow: 0 8px 24px rgba(15, 23, 42, 0.07);
        }
        .comment-composer-label {
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 10px;
        }
        .comment-textarea {
            border-radius: 12px;
            border: 1px solid #d1d5db;
            min-height: 110px;
            resize: vertical;
            padding: 12px 14px;
            transition: border-color .2s ease, box-shadow .2s ease;
        }
        .comment-textarea:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.12);
        }
        .comment-submit {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 10px 18px;
            font-weight: 600;
            text-transform: none;
            letter-spacing: 0;
        }
        .comment-submit:hover {
            color: #fff;
            transform: translateY(-1px);
            box-shadow: 0 8px 20px rgba(37, 99, 235, 0.25);
        }
    </style>
</head>
<body>
    <?php include PATH_ROOT . '/views/components/navbar.php'; ?>
    <?php
        $rolexFallbackImages = [
            'https://images.unsplash.com/photo-1523170335258-f5ed11844a49?auto=format&fit=crop&w=900&q=80',
            'https://images.unsplash.com/photo-1547996160-81dfa63595aa?auto=format&fit=crop&w=900&q=80',
            'https://images.unsplash.com/photo-1522312346375-d1a52e2b99b3?auto=format&fit=crop&w=900&q=80'
        ];
    ?>
    <div class="container detail-container">
        <div class="row">
            <div class="col-md-6 mb-4 mb-md-0">
                <div class="product-image-wrapper shadow-sm">
                <?php $productImage = resolveProductImage($product['image'] ?? '', $rolexFallbackImages, (int)($product['id'] ?? 0)); ?>
                    <img src="<?= htmlspecialchars($productImage) ?>" class="img-fluid" alt="<?= htmlspecialchars($product['name']) ?>">
                </div>
            </div>
            <div class="col-md-6">
                <span class="category-label"><?= htmlspecialchars($product['category_name'] ?? 'N/A') ?></span>
                <h1><?= htmlspecialchars($product['name'] ?? '') ?></h1>
                <div class="price-display">
                    <?= number_format($product['price'], 0, ',', '.') ?> <small style="font-size: 1rem;">VND</small>
                </div>
                <div class="description-box">
                    <p class="mb-0 text-muted"><?= nl2br(htmlspecialchars($product['description'] ?? '')) ?></p>
                </div>
                <div class="action-group mb-4">
                    <a href="<?= BASE_URL ?>?controller=user&action=addToCart&id=<?= $product['id'] ?>" class="btn btn-cart">
                        <i class="fas fa-cart-plus me-1"></i>Thêm vào giỏ hàng
                    </a>
                </div>
                <a href="<?= BASE_URL ?>?controller=user&action=products" class="text-decoration-none back-to-list small fw-medium">
                    <i class="fas fa-long-arrow-alt-left me-1"></i> Quay lại danh sách sản phẩm
                </a>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-lg-8">
                <h4 class="mb-3 comments-section-title">Bình luận sản phẩm</h4>

                <?php if (!empty($comments)): ?>
                    <?php foreach ($comments as $c): ?>
                        <?php $commentAuthor = (string)($c['fullname'] ?? $c['email'] ?? 'Khách'); ?>
                        <div class="comment-item">
                            <span class="comment-avatar"><?= htmlspecialchars(mb_substr($commentAuthor, 0, 1)) ?></span>
                            <div class="comment-bubble">
                                <div class="comment-head">
                                    <span class="comment-author"><?= htmlspecialchars($commentAuthor) ?></span>
                                    <span class="comment-time"><?= htmlspecialchars($c['created_at']) ?></span>
                                </div>
                                <div class="comment-content"><?= nl2br(htmlspecialchars($c['content'])) ?></div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-muted">Chưa có bình luận nào cho sản phẩm này.</p>
                <?php endif; ?>

                <?php if (isset($_SESSION['user'])): ?>
                    <form method="POST" action="<?= BASE_URL ?>?controller=user&action=addComment&id=<?= (int)$product['id'] ?>" class="comment-composer">
                        <label class="form-label comment-composer-label">Viết bình luận của bạn</label>
                        <textarea name="content" class="form-control comment-textarea mb-2" rows="3" required placeholder="Chia sẻ cảm nhận của bạn về sản phẩm..."></textarea>
                        <button type="submit" class="btn comment-submit">Gửi bình luận</button>
                    </form>
                <?php else: ?>
                    <p class="mt-3">
                        <a href="<?= BASE_URL ?>?controller=auth&action=loginPage">Đăng nhập</a> để bình luận sản phẩm.
                    </p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php include PATH_ROOT . '/views/components/footer.php'; ?>
</body>
</html>