<?php

class Coupon
{
    // Tìm mã giảm giá đang hoạt động theo code
    public static function findActive(string $code): ?array
    {
        $sql = "
            SELECT * FROM coupons
            WHERE code = :code
              AND status = 'active'
              AND used_count < usage_limit
              AND (start_at IS NULL OR start_at <= NOW())
              AND (end_at IS NULL OR end_at >= NOW())
            LIMIT 1
        ";
        $stmt = Database::pdo()->prepare($sql);
        $stmt->execute([':code' => strtoupper(trim($code))]);
        $coupon = $stmt->fetch();
        return $coupon ?: null;
    }

    // Tính số tiền được giảm dựa trên tạm tính (subtotal)
    public static function calculateDiscount(array $coupon, int $subtotal): int
    {
        if ($subtotal < (int)$coupon['min_order']) {
            return 0;
        }

        if ($coupon['type'] === 'percent') {
            return (int)round($subtotal * ((int)$coupon['value'] / 100));
        }

        return min((int)$coupon['value'], $subtotal);
    }
}