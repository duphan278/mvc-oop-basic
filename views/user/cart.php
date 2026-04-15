<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ hàng - Luxe Watches</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --accent-color: #e74c3c;
            --text-primary: #1a1a1a;
            --text-secondary: #6c757d;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            line-height: 1.7;
            color: var(--text-primary);
            -webkit-font-smoothing: antialiased;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Playfair Display', serif;
            font-weight: 600;
            line-height: 1.3;
            letter-spacing: -0.02em;
            color: var(--text-primary);
        }

        .price-red {
            color: #dc3545;
            font-weight: 700;
            font-size: 1.1rem;
        }

        .btn {
            font-weight: 500;
            letter-spacing: 0.025em;
            border-radius: 8px;
        }
    </style>
    <style>
        body { background: #f5f5f5; }
        .cart-wrap { max-width: 1200px; margin: 0 auto; }
        .cart-box { background: #fff; border: 1px solid #eee; }
        .shop-row { background: #fff; border: 1px solid #eee; }
        .product-cell { min-width: 360px; }
        .qty-box { border: 1px solid #ddd; border-radius: 4px; overflow: hidden; display: inline-flex; align-items: center; }
        .qty-btn { width: 28px; height: 28px; display: inline-flex; justify-content: center; align-items: center; text-decoration: none; color: #333; background: #fff; }
        .qty-num { width: 36px; text-align: center; border-left: 1px solid #ddd; border-right: 1px solid #ddd; font-size: 14px; }
        .price-red { color: #ee4d2d; font-weight: 600; }
        .checkout-bar { position: sticky; bottom: 0; z-index: 5; }
    </style>
</head>
<body>
    <?php include PATH_ROOT . '/views/components/navbar.php'; ?>
    <div class="container-fluid mt-3 mb-4 cart-wrap">
        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php
                $errorMsg = '';
                switch ($_GET['error']) {
                    case 'missing_info':
                        $errorMsg = 'Vui lòng nhập đầy đủ thông tin giao hàng.';
                        break;
                    case 'select_bank':
                        $errorMsg = 'Vui lòng chọn ngân hàng khi thanh toán bằng chuyển khoản.';
                        break;
                    case 'empty_cart':
                        $errorMsg = 'Giỏ hàng trống.';
                        break;
                    case 'order_failed':
                        $errorMsg = 'Có lỗi xảy ra khi đặt hàng. Vui lòng thử lại.';
                        break;
                    case 'invalid_voucher':
                        $errorMsg = 'Mã voucher không hợp lệ hoặc đã hết hạn.';
                        break;
                    default:
                        $errorMsg = 'Có lỗi xảy ra.';
                }
                echo htmlspecialchars($errorMsg);
                ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        <h4 class="mb-3 fw-bold">Giỏ Hàng</h4>
        <?php if (empty($cartItems)): ?>
            <div class="cart-box p-4 text-center">
                <p class="mb-3">Giỏ hàng trống.</p>
                <a href="<?= BASE_URL ?>?controller=user&action=products" class="btn btn-danger">Tiếp tục mua sắm</a>
            </div>
        <?php else: ?>
            <div class="cart-box px-3 py-2 mb-2">
                <div class="row fw-semibold text-muted small">
                    <div class="col-md-6">Sản phẩm</div>
                    <div class="col-md-2 text-center">Đơn Giá</div>
                    <div class="col-md-2 text-center">Số Lượng</div>
                    <div class="col-md-1 text-center">Số Tiền</div>
                    <div class="col-md-1 text-center">Thao Tác</div>
                </div>
            </div>

            <?php foreach ($cartItems as $item): ?>
                <div class="shop-row p-3 mb-2">
                    <div class="row align-items-center">
                        <div class="col-md-6 product-cell">
                            <div class="d-flex align-items-center gap-3">
                                <?php
                                    $img = $item['image'] ?? '';
                                    $imgSrc = resolveProductImage($img, [], (int)($item['id'] ?? 0));
                                ?>
                                <img src="<?= htmlspecialchars($imgSrc) ?>" alt="<?= htmlspecialchars($item['name']) ?>" width="80" height="80" style="object-fit:cover;border:1px solid #eee;">
                                <div>
                                    <div class="fw-semibold"><?= htmlspecialchars($item['name']) ?></div>
                                    <small class="text-muted">Mã SP: #<?= (int)$item['id'] ?></small>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-2 text-center">
                            <?= number_format($item['price'], 0, ',', '.') ?>đ
                        </div>

                        <div class="col-md-2 text-center">
                            <div class="qty-box">
                                <a class="qty-btn" href="<?= BASE_URL ?>?controller=user&action=decrementCartItem&id=<?= (int)$item['id'] ?>">-</a>
                                <span class="qty-num"><?= (int)$item['quantity'] ?></span>
                                <a class="qty-btn" href="<?= BASE_URL ?>?controller=user&action=addToCart&id=<?= (int)$item['id'] ?>">+</a>
                            </div>
                        </div>

                        <div class="col-md-1 text-center price-red">
                            <?= number_format($item['subtotal'], 0, ',', '.') ?>đ
                        </div>

                        <div class="col-md-1 text-center">
                            <a href="<?= BASE_URL ?>?controller=user&action=removeCartItem&id=<?= (int)$item['id'] ?>" class="text-danger text-decoration-none">
                                Xóa
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

            <!-- Phần chọn phương thức thanh toán và địa chỉ -->
            <div class="cart-box p-3 mt-3">
                <h5 class="mb-3">Thông tin thanh toán và giao hàng</h5>
                <?php
                    $checkoutInfo = $checkoutInfo ?? [];
                    $prefillName = (string)($checkoutInfo['contact_name'] ?? '');
                    $prefillPhone = (string)($checkoutInfo['contact_phone'] ?? '');
                    $prefillAddress = (string)($checkoutInfo['shipping_address'] ?? '');
                    $prefillPayment = (string)($checkoutInfo['payment_method'] ?? 'cod');
                    $prefillBank = (string)($checkoutInfo['bank'] ?? '');
                    $hasSavedCheckout = ($prefillName !== '' || $prefillPhone !== '' || $prefillAddress !== '');
                ?>
                <form method="POST" action="<?= BASE_URL ?>?controller=user&action=checkout">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Phương thức thanh toán</h6>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment" id="cod" value="cod" <?= $prefillPayment !== 'bank' ? 'checked' : '' ?>>
                                <label class="form-check-label" for="cod">
                                    Thanh toán khi nhận hàng (COD)
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment" id="bank" value="bank" <?= $prefillPayment === 'bank' ? 'checked' : '' ?>>
                                <label class="form-check-label" for="bank">
                                    Chuyển khoản ngân hàng
                                </label>
                            </div>
                            <div id="bank-options" class="mt-3" style="display: none;">
                                <h6>Chọn ngân hàng</h6>
                                <select name="bank" class="form-select" id="bank-select">
                                    <option value="">-- Chọn ngân hàng --</option>
                                    <option value="vietcombank" <?= $prefillBank === 'vietcombank' ? 'selected' : '' ?>>Vietcombank</option>
                                    <option value="bidv" <?= $prefillBank === 'bidv' ? 'selected' : '' ?>>BIDV</option>
                                    <option value="vietinbank" <?= $prefillBank === 'vietinbank' ? 'selected' : '' ?>>VietinBank</option>
                                    <option value="agribank" <?= $prefillBank === 'agribank' ? 'selected' : '' ?>>Agribank</option>
                                </select>
                                <div id="qr-code" class="mt-3" style="display: none;">
                                    <h6>Quét QR để thanh toán</h6>
                                    <img id="qr-image" src="" alt="QR Code" width="200" height="200">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h6>Địa chỉ giao hàng</h6>
                            <?php if ($hasSavedCheckout): ?>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="use_saved_info" checked>
                                    <label class="form-check-label" for="use_saved_info">
                                        Dùng thông tin từ đơn gần nhất
                                    </label>
                                </div>
                            <?php endif; ?>
                            <div class="mb-2">
                                <input type="text" name="name" class="form-control" placeholder="Họ và tên" value="<?= htmlspecialchars($prefillName) ?>" required>
                            </div>
                            <div class="mb-2">
                                <input type="tel" name="phone" class="form-control" placeholder="Số điện thoại" value="<?= htmlspecialchars($prefillPhone) ?>" required>
                            </div>
                            <div class="mb-2">
                                <textarea name="address" class="form-control" rows="3" placeholder="Địa chỉ giao hàng" required><?= htmlspecialchars($prefillAddress) ?></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Phần voucher -->
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <h6>Mã giảm giá (Voucher)</h6>
                            <div class="input-group">
                                <input type="text" name="voucher_code" id="voucher_code" class="form-control" placeholder="Nhập mã voucher (nếu có)">
                                <button type="button" id="apply_voucher" class="btn btn-outline-primary">Áp dụng</button>
                            </div>
                            <small class="text-muted">Ví dụ: WELCOME10, SAVE50K, FLASH20</small>
                            <div id="voucher_message" class="mt-2" style="display: none;"></div>
                        </div>
                    </div>

                    <div class="mt-3 d-flex justify-content-between align-items-center checkout-bar">
                        <a href="<?= BASE_URL ?>?controller=user&action=products" class="btn btn-outline-secondary">Mua thêm</a>
                        <div class="d-flex align-items-center gap-3">
                            <div id="total_display">
                                Tổng cộng:
                                <span class="price-red fs-5" id="total_amount"><?= number_format($total, 0, ',', '.') ?>đ</span>
                            </div>
                            <button type="submit" class="btn btn-danger px-4">Đặt hàng</button>
                        </div>
                    </div>
                </form>
            </div>
        <?php endif; ?>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const codRadio = document.getElementById('cod');
            const bankRadio = document.getElementById('bank');
            const bankOptions = document.getElementById('bank-options');
            const bankSelect = document.getElementById('bank-select');
            const qrCode = document.getElementById('qr-code');
            const qrImage = document.getElementById('qr-image');
            const useSavedInfoCheckbox = document.getElementById('use_saved_info');
            const nameInput = document.querySelector('input[name="name"]');
            const phoneInput = document.querySelector('input[name="phone"]');
            const addressInput = document.querySelector('textarea[name="address"]');
            const savedCheckoutInfo = {
                name: <?= json_encode($prefillName, JSON_UNESCAPED_UNICODE) ?>,
                phone: <?= json_encode($prefillPhone, JSON_UNESCAPED_UNICODE) ?>,
                address: <?= json_encode($prefillAddress, JSON_UNESCAPED_UNICODE) ?>
            };

            function toggleBankOptions() {
                if (bankRadio.checked) {
                    bankOptions.style.display = 'block';
                } else {
                    bankOptions.style.display = 'none';
                    qrCode.style.display = 'none';
                    bankSelect.value = '';
                }
            }

            function updateQR() {
                const selectedBank = bankSelect.value;
                if (selectedBank) {
                    qrImage.src = 'https://via.placeholder.com/200x200?text=QR+' + selectedBank.toUpperCase();
                    qrCode.style.display = 'block';
                } else {
                    qrCode.style.display = 'none';
                }
            }

            codRadio.addEventListener('change', toggleBankOptions);
            bankRadio.addEventListener('change', toggleBankOptions);
            bankSelect.addEventListener('change', updateQR);
            toggleBankOptions();
            updateQR();

            if (useSavedInfoCheckbox) {
                useSavedInfoCheckbox.addEventListener('change', function() {
                    if (this.checked) {
                        nameInput.value = savedCheckoutInfo.name;
                        phoneInput.value = savedCheckoutInfo.phone;
                        addressInput.value = savedCheckoutInfo.address;
                        return;
                    }
                    nameInput.value = '';
                    phoneInput.value = '';
                    addressInput.value = '';
                });
            }

            // Xử lý voucher
            const applyVoucherBtn = document.getElementById('apply_voucher');
            const voucherCodeInput = document.getElementById('voucher_code');
            const voucherMessage = document.getElementById('voucher_message');
            const totalAmountSpan = document.getElementById('total_amount');
            let appliedVoucher = null;
            let originalTotal = <?= $total ?>;

            applyVoucherBtn.addEventListener('click', function() {
                const voucherCode = voucherCodeInput.value.trim();
                if (!voucherCode) {
                    showVoucherMessage('Vui lòng nhập mã voucher', 'danger');
                    return;
                }

                // Disable button while processing
                applyVoucherBtn.disabled = true;
                applyVoucherBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Đang kiểm tra...';

                fetch('<?= BASE_URL ?>?controller=user&action=apply-voucher', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'voucher_code=' + encodeURIComponent(voucherCode) + '&order_amount=' + originalTotal
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        appliedVoucher = {
                            code: voucherCode,
                            discount: data.discount,
                            final_amount: data.final_amount
                        };
                        totalAmountSpan.textContent = new Intl.NumberFormat('vi-VN').format(data.final_amount) + 'đ';
                        showVoucherMessage(data.message + ' Giảm ' + new Intl.NumberFormat('vi-VN').format(data.discount) + 'đ', 'success');
                        voucherCodeInput.disabled = true;
                        applyVoucherBtn.style.display = 'none';
                    } else {
                        showVoucherMessage(data.message, 'danger');
                        appliedVoucher = null;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showVoucherMessage('Có lỗi xảy ra. Vui lòng thử lại.', 'danger');
                    appliedVoucher = null;
                })
                .finally(() => {
                    applyVoucherBtn.disabled = false;
                    applyVoucherBtn.innerHTML = 'Áp dụng';
                });
            });

            function showVoucherMessage(message, type) {
                voucherMessage.innerHTML = `<div class="alert alert-${type} alert-dismissible fade show" role="alert">
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>`;
                voucherMessage.style.display = 'block';
            }

            // Reset voucher khi thay đổi giỏ hàng (có thể thêm sau)
        });
    </script>
</body>
</html>