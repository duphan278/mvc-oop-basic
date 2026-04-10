<?php

class Voucher
{
    private $conn;

    public function __construct()
    {
        // Dùng chung cấu hình CSDL từ commons/env.php
        $this->conn = connectDB();
    }

    /**
     * Tìm voucher theo code
     */
    public function findByCode($code)
    {
        $stmt = $this->conn->prepare("SELECT * FROM vouchers WHERE code = ? AND is_active = 1");
        $stmt->execute([$code]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Kiểm tra voucher có hợp lệ không
     */
    public function isValid($voucher, $orderAmount)
    {
        if (!$voucher) return false;

        // Kiểm tra ngày hết hạn
        $now = date('Y-m-d H:i:s');
        if ($voucher['expiry_date'] < $now) return false;

        // Kiểm tra số tiền đơn hàng tối thiểu
        if ($orderAmount < $voucher['min_order_amount']) return false;

        // Kiểm tra giới hạn sử dụng
        if ($voucher['usage_limit'] !== null && $voucher['used_count'] >= $voucher['usage_limit']) {
            return false;
        }

        return true;
    }

    /**
     * Tính số tiền giảm giá
     */
    public function calculateDiscount($voucher, $orderAmount)
    {
        if (!$this->isValid($voucher, $orderAmount)) return 0;

        if ($voucher['discount_type'] === 'percent') {
            $discount = $orderAmount * ($voucher['discount_value'] / 100);
        } else {
            $discount = min($voucher['discount_value'], $orderAmount);
        }

        return $discount;
    }

    /**
     * Tăng số lần sử dụng voucher
     */
    public function incrementUsage($voucherId)
    {
        $stmt = $this->conn->prepare("UPDATE vouchers SET used_count = used_count + 1 WHERE id = ?");
        return $stmt->execute([$voucherId]);
    }

    /**
     * Lấy danh sách voucher active
     */
    public function getActiveVouchers()
    {
        $now = date('Y-m-d H:i:s');
        $stmt = $this->conn->prepare("SELECT * FROM vouchers WHERE is_active = 1 AND expiry_date > ? ORDER BY expiry_date ASC");
        $stmt->execute([$now]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>