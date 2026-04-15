<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm sản phẩm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <?php include(PATH_ROOT . '/views/admin/topbar.php'); ?>

    <div class="d-flex" style="min-height:100vh; background-color: #f8f9fa;">
        <?php include(PATH_ROOT . '/views/admin/sidebar.php'); ?>

        <div class="container-fluid flex-grow-1 p-4 admin-main">
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-lg border-0 w-100 admin-fill-card">
                        <div class="card-header bg-primary text-white">
                            <h2 class="mb-0"><i class="fas fa-plus-circle"></i> Thêm sản phẩm mới</h2>
                        </div>
                        <div class="card-body p-4 p-lg-5">
                            <form method="post" action="<?= BASE_URL ?>?controller=admin&action=create" enctype="multipart/form-data" class="w-100">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="name" class="form-label fw-bold">Tên sản phẩm <span class="text-danger">*</span></label>
                                        <input type="text" name="name" id="name" class="form-control" required placeholder="Nhập tên sản phẩm" value="<?= htmlspecialchars($_POST['name'] ?? '') ?>">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="category_id" class="form-label fw-bold">Thương hiệu</label>
                                        <input type="number" name="category_id" id="category_id" class="form-control" placeholder="ID thương hiệu (có thể để trống)" value="<?= htmlspecialchars($_POST['category_id'] ?? '') ?>">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="price" class="form-label fw-bold">Giá (VNĐ) <span class="text-danger">*</span></label>
                                        <input type="number" step="0.01" name="price" id="price" class="form-control" required placeholder="0.00" value="<?= htmlspecialchars($_POST['price'] ?? '') ?>">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="image" class="form-label fw-bold">Ảnh sản phẩm</label>
                                        <input type="file" name="image" id="image" class="form-control" accept="image/*" onchange="previewImage(event)">
                                        <div class="mt-2">
                                            <img id="imagePreview" src="" alt="Preview" style="max-width: 200px; max-height: 200px; display: none; border: 1px solid #ddd; border-radius: 5px;">
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="description" class="form-label fw-bold">Mô tả sản phẩm</label>
                                    <textarea name="description" id="description" class="form-control" rows="6" placeholder="Mô tả chi tiết về sản phẩm"><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea>
                                </div>
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-success btn-lg">
                                        <i class="fas fa-save"></i> Lưu sản phẩm
                                    </button>
                                    <a href="<?= BASE_URL ?>?act=admin" class="btn btn-secondary btn-lg">
                                        <i class="fas fa-arrow-left"></i> Quay lại
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
function previewImage(event) {
    const file = event.target.files[0];
    const preview = document.getElementById('imagePreview');
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(file);
    } else {
        preview.src = '';
        preview.style.display = 'none';
    }
}
</script>
</html>