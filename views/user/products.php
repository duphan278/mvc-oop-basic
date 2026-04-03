<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sản phẩm - Watch Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include PATH_ROOT . '/views/components/navbar.php'; ?>
    <div class="container mt-4">
        <h1>Danh sách sản phẩm</h1>
        <form method="GET" action="">
            <input type="hidden" name="controller" value="user">
            <input type="hidden" name="action" value="products">
            <div class="mb-3">
                <label for="category" class="form-label">Lọc theo danh mục:</label>
                <select name="id" id="category" class="form-select" onchange="this.form.submit()">
                    <option value="">Tất cả</option>
                    <?php
                    $categories = (new Category())->getAll();
                    foreach ($categories as $cat) {
                        $selected = (isset($_GET['id']) && $_GET['id'] == $cat['id']) ? 'selected' : '';
                        echo "<option value='{$cat['id']}' $selected>{$cat['name']}</option>";
                    }
                    ?>
                </select>
            </div>
        </form>
        <div class="row">
            <?php foreach ($products as $product): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="<?= BASE_URL . $product['image'] ?>" class="card-img-top" alt="<?= $product['name'] ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= $product['name'] ?></h5>
                            <p class="card-text">Giá: <?= number_format($product['price']) ?> VND</p>
                            <p class="card-text">Danh mục: <?= $product['category_name'] ?></p>
                            <a href="<?= BASE_URL ?>?controller=user&action=detail&id=<?= $product['id'] ?>" class="btn btn-primary">Xem chi tiết</a>
                            <a href="<?= BASE_URL ?>?controller=user&action=addToCart&id=<?= $product['id'] ?>" class="btn btn-success">Thêm vào giỏ</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>