<?php

class Order
{
    // Tính phí vận chuyển: đơn từ 2.000.000đ miễn phí ship, dưới 2 triệu phí 30.000đ
    public static function calculateShippingFee(int $subtotal): int
    {
        return $subtotal >= 2000000 ? 0 : 30000;
    }

    // Tạo đơn hàng mới trong Transaction (Trả về mã đơn order_code)
    public static function createOrder(array $customer, array $summary): string
    {
        $pdo = Database::pdo();
        $pdo->beginTransaction();

        try {
            // 1. Kiểm tra và khóa tồn kho từng sản phẩm (SELECT ... FOR UPDATE)
            $checkStockStmt = $pdo->prepare(
                'SELECT stock FROM product_variants WHERE id = :vid FOR UPDATE'
            );
            $deductStockStmt = $pdo->prepare(
                'UPDATE product_variants SET stock = stock - :qty WHERE id = :vid'
            );

            foreach ($summary['items'] as $item) {
                $checkStockStmt->execute([':vid' => $item['variant_id']]);
                $currentStock = (int)$checkStockStmt->fetchColumn();

                if ($currentStock < (int)$item['qty']) {
                    throw new RuntimeException(
                        'Sản phẩm "' . $item['product_name'] . ' (' . $item['color'] . ')" không đủ tồn kho.'
                    );
                }
            }

            // 2. Sinh mã đơn hàng duy nhất (VD: TS20261108-4829)
            $orderCode   = 'TS' . date('Ymd') . '-' . random_int(1000, 9999);
            $shippingFee = self::calculateShippingFee($summary['subtotal']);
            $finalTotal  = $summary['total'] + $shippingFee;
            $couponCode  = $summary['coupon']['code'] ?? null;

            // 3. Lưu vào bảng orders
            $orderStmt = $pdo->prepare("
                INSERT INTO orders (
                    order_code, user_id, receiver_name, receiver_phone, shipping_addr,
                    note, subtotal, shipping_fee, discount, coupon_code, total,
                    payment_method, payment_status, status
                ) VALUES (
                    :order_code, :user_id, :receiver_name, :receiver_phone, :shipping_addr,
                    :note, :subtotal, :shipping_fee, :discount, :coupon_code, :total,
                    :payment_method, 'pending', 'pending'
                )
            ");

            $orderStmt->execute([
                ':order_code'     => $orderCode,
                ':user_id'        => $customer['user_id'],
                ':receiver_name'  => $customer['receiver_name'],
                ':receiver_phone' => $customer['receiver_phone'],
                ':shipping_addr'  => $customer['shipping_addr'],
                ':note'           => $customer['note'],
                ':subtotal'       => $summary['subtotal'],
                ':shipping_fee'   => $shippingFee,
                ':discount'       => $summary['discount'],
                ':coupon_code'    => $couponCode,
                ':total'          => $finalTotal,
                ':payment_method' => $customer['payment_method'],
            ]);

            $orderId = (int)$pdo->lastInsertId();

            // 4. Lưu chi tiết đơn hàng (Snapshot) và trừ tồn kho
            $itemStmt = $pdo->prepare("
                INSERT INTO order_items (
                    order_id, variant_id, product_name, sku, variant_info, price, quantity
                ) VALUES (
                    :order_id, :variant_id, :product_name, :sku, :variant_info, :price, :quantity
                )
            ");

            foreach ($summary['items'] as $item) {
                $variantInfo = trim($item['color'] . ' ' . ($item['ram'] ?? '') . ' ' . ($item['storage'] ?? ''));

                $itemStmt->execute([
                    ':order_id'     => $orderId,
                    ':variant_id'   => $item['variant_id'],
                    ':product_name' => $item['product_name'],
                    ':sku'          => $item['sku'],
                    ':variant_info' => $variantInfo,
                    ':price'        => $item['unit_price'],
                    ':quantity'     => $item['qty'],
                ]);

                $deductStockStmt->execute([
                    ':qty' => $item['qty'],
                    ':vid' => $item['variant_id'],
                ]);
            }

            // 5. Tăng số lượt sử dụng mã giảm giá (nếu có)
            if ($couponCode) {
                $couponStmt = $pdo->prepare(
                    'UPDATE coupons SET used_count = used_count + 1 WHERE code = :code'
                );
                $couponStmt->execute([':code' => $couponCode]);
            }

            $pdo->commit();
            return $orderCode;
        } catch (Throwable $e) {
            $pdo->rollBack();
            throw $e;
        }
    }

    // Tìm đơn hàng theo mã order_code kèm danh sách sản phẩm trong đơn
    public static function findByCode(string $orderCode): ?array
    {
        $stmt = Database::pdo()->prepare('SELECT * FROM orders WHERE order_code = :code LIMIT 1');
        $stmt->execute([':code' => $orderCode]);
        $order = $stmt->fetch();

        if (!$order) {
            return null;
        }

        $itemStmt = Database::pdo()->prepare('SELECT * FROM order_items WHERE order_id = :oid');
        $itemStmt->execute([':oid' => $order['id']]);
        $order['items'] = $itemStmt->fetchAll();

        return $order;
    }
    // Thống kê Admin Dashboard
    public static function stats(): array
    {
        $pdo = Database::pdo();
        return [
            'total_orders' => (int)$pdo->query('SELECT COUNT(*) FROM orders')->fetchColumn(),
            'total_revenue' => (int)$pdo->query("SELECT COALESCE(SUM(total),0) FROM orders WHERE status != 'cancelled'")->fetchColumn(),
            'total_products' => (int)$pdo->query('SELECT COUNT(*) FROM products')->fetchColumn(),
            'total_users' => (int)$pdo->query('SELECT COUNT(*) FROM users')->fetchColumn(),
        ];
    }

    // Lấy danh sách tất cả đơn hàng mới nhất cho Admin
    public static function all(): array
    {
        $stmt = Database::pdo()->query('SELECT * FROM orders ORDER BY id DESC');
        return $stmt->fetchAll();
    }

    // Cập nhật trạng thái đơn hàng
    public static function updateStatus(int $orderId, string $status): void
    {
        $allowed = ['pending', 'confirmed', 'shipping', 'completed', 'cancelled'];
        if(!in_array($status, $allowed, true))
            {
                return;
            }
        $stmt = Database::pdo()->prepare('UPDATE orders SET status = :status WHERE id = :id');
        $stmt->execute([':status' => $status, ':id' => $orderId]);    
    }

    // Lấy danh sách đơn hàng của 1 khách hàng
    public static function byUser(int $userID) : array {
        $stmt = Database::pdo()->prepare('SELECT * FROM orders WHERE user_id = :uid ORDER BY id DESC');
        $stmt->execute([':uid' => $userID]);
        return $stmt->fetchAll();
    }
    //Khách  tự hủy đơn hàng khi đang trạng thái 'pending' hoàn lại tồn kho
    public static function cancelByCustomer(int $orderId, int $userID) :void{
       $pdo = Database::pdo();
       $pdo->beginTransaction();
       try{
        $stmt = $pdo->prepare('SELECT * FROM orders WHERE id = :id AND user_id = :uid FOR UPDATE');
        $stmt->execute([':id' => $orderId, ':uid' => $userID]);
        $order = $stmt->fetch();
        if(!$order){
            throw new RuntimeException('Không tìm thấy đơn hàng của bạn.');

        }
        if($order['status'] !== 'pending'){
            throw new RuntimeException('Chỉ có thể hủy đơn hàng khi ở trạng thái chờ xác nhận');

        }
        // Lấy các sản phẩm trong đơn để cộng trả lại tồn kho
        $itemStmt= $pdo->prepare('SELECT variant_id, quantity FROM order_items WHERE order_id = :oid' );
        $itemStmt->execute([':oid' => $orderId]);
        $item = $itemStmt->fetchAll();
        $restoreStock = $pdo->prepare('UPDATE product_variants SET stock = stock + :qty WHERE id = :vid');
        foreach($item as $it){
            if(!empty($it['variant_id'])){
                $restoreStock->execute([
                    ':qty' => (int)$it['quantity'],
                    ':vid' => (int)$it['variant_id'],
                ]);
            }
        }
        // Cập nhật trạng thái đơn hàng
        $upd = $pdo->prepare("UPDATE orders SET status = 'cancelled' WHERE id = :id");
        $upd->execute([':id'=> $orderId]);
        $pdo->commit();
       } catch(Throwable $e){
        $pdo->rollBack();
        throw $e;
       }
    }
}
