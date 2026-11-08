<?php

class CartController extends Controller
{
    // Lấy danh sách sản phẩm trong giỏ kèm tính toán tiền
    public static function getCartSummary(): array
    {
        $cartSession = $_SESSION['cart'] ?? [];
        $variants    = Product::findVariantsByIds(array_keys($cartSession));

        $items    = [];
        $subtotal = 0;

        foreach ($variants as $v) {
            $vid       = (int)$v['variant_id'];
            $qty       = min((int)($cartSession[$vid] ?? 1), (int)$v['stock']);
            if ($qty <= 0) {
                continue;
            }
            $unitPrice = (int)($v['sale_price'] ?: $v['price']);
            $lineTotal = $unitPrice * $qty;
            $subtotal += $lineTotal;

            $v['qty']        = $qty;
            $v['unit_price'] = $unitPrice;
            $v['line_total'] = $lineTotal;
            $items[]         = $v;
        }

        $coupon   = null;
        $discount = 0;
        if (!empty($_SESSION['coupon_code'])) {
            $coupon = Coupon::findActive($_SESSION['coupon_code']);
            if ($coupon) {
                $discount = Coupon::calculateDiscount($coupon, $subtotal);
            } else {
                unset($_SESSION['coupon_code']);
            }
        }

        return [
            'items'    => $items,
            'subtotal' => $subtotal,
            'coupon'   => $coupon,
            'discount' => $discount,
            'total'    => max(0, $subtotal - $discount),
        ];
    }

    public function index(): void
    {
        $summary = self::getCartSummary();
        $this->render('cart/index', [
            'title'   => 'Giỏ hàng của bạn',
            'summary' => $summary,
            'msg'     => $_SESSION['cart_msg'] ?? null,
        ]);
        unset($_SESSION['cart_msg']);
    }

    public function add(): void
    {
        verify_csrf();
        $variantId = (int)($_POST['variant_id'] ?? 0);
        $quantity  = max(1, (int)($_POST['quantity'] ?? 1));

        if ($variantId > 0) {
            $_SESSION['cart'][$variantId] = ($_SESSION['cart'][$variantId] ?? 0) + $quantity;
            $_SESSION['cart_msg'] = 'Đã thêm sản phẩm vào giỏ hàng!';
        }

        $this->redirect('/gio-hang');
    }

    public function update(): void
    {
        verify_csrf();
        $quantities = $_POST['qty'] ?? [];

        foreach ($quantities as $vid => $qty) {
            $vid = (int)$vid;
            $qty = (int)$qty;
            if ($qty <= 0) {
                unset($_SESSION['cart'][$vid]);
            } else {
                $_SESSION['cart'][$vid] = $qty;
            }
        }

        $_SESSION['cart_msg'] = 'Đã cập nhật số lượng giỏ hàng.';
        $this->redirect('/gio-hang');
    }

    public function remove(): void
    {
        verify_csrf();
        $variantId = (int)($_POST['variant_id'] ?? 0);
        unset($_SESSION['cart'][$variantId]);
        $this->redirect('/gio-hang');
    }

    public function applyCoupon(): void
    {
        verify_csrf();
        $code = strtoupper(trim($_POST['coupon_code'] ?? ''));

        if ($code === '') {
            unset($_SESSION['coupon_code']);
            $this->redirect('/gio-hang');
        }

        $coupon = Coupon::findActive($code);
        if (!$coupon) {
            $_SESSION['cart_msg'] = 'Mã giảm giá không tồn tại hoặc đã hết lượt sử dụng.';
        } else {
            $_SESSION['coupon_code'] = $coupon['code'];
            $_SESSION['cart_msg']    = 'Đã áp dụng mã giảm giá ' . $coupon['code'] . '!';
        }

        $this->redirect('/gio-hang');
    }
}