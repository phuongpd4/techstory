<?php

class CheckoutController extends Controller{

    public function index():void
    {
        $summary = Cartcontroller::getCartSummary();
        if(empty($summary['items'])){
            $this->redirect('/gio-hang');
            
        }

        $shippingFee = Order::calculateShippingFee($summary['subtotal']);
        $this->render('checkout/index', [
            'title' => 'Thanh toán đơn hàng',
            'summary' => $summary,
            'shippingFee' => $shippingFee,
            'user' =>current_user(),
        ]);
    }
    public function placeOrder():void
    {
        verify_csrf();
        $summary = CartController::getCartSummary();
        if(empty($summary['items'])) {
            $this->redirect('/gio-hang');
        }

        $receiverName = trim($_POST['receiver_name'] ?? '');
        $receiverPhone = trim($_POST['receiver_phone'] ?? '');
        $shippingAddr = trim($_POST['shipping_addr'] ?? '');
        $note = trim($_POST['note'] ?? ''); 
        $paymentMethod = in_array($_POST['payment_method'] ?? '', ['cod','qr'],true) ? $_POST['payment_method'] : 'cod';

        $shippingFee = Order::calculateShippingFee($summary['subtotal']);

        if($receiverName === '' || $receiverPhone === '' || $shippingAddr === ''){
            $this->render('checkout/index', [
                'title' => 'Thanh toán đơn hàng',
                'summary' => $summary,
                'shippingFee' => $shippingFee,
                'user' => current_user(),
                'error' => 'Vui lòng điền đầy đủ họ tên, số diện thoại và địa chỉ nhận hàng.',
                'old' => $_POST,
            ]);
            return;
        }    
            try{
                $user = current_user();
                $orderCode = Order::createOrder([
                    'user_id' =>$user ? (int)$user['id'] : null,
                    'receiver_name' => $receiverName,
                    'receiver_phone' => $receiverPhone,
                    'shipping_addr' => $shippingAddr,
                    'note' => $note,
                    'payment_method' => $paymentMethod,
                ],$summary);
                // Đặt hàng thành công, trống giỏ hàng và mã giảm giá
                unset($_SESSION['cart']);
                unset($_SESSION['coupon_code']);
                $this->redirect('/dat-hang-thanh-cong/' . $orderCode);
            } catch ( Throwable $e){
                $this->render('checkout/index', [
                    'title' => 'Thanh toán đơn hàng',
                    'summary' => $summary,
                    'shippingFee' => $shippingFee,
                    'user' => current_user(),
                    'error' => $e->getMessage(),
                    'old' => $_POST,
                ]);
            }
    }
    
    public function success(string $orderCode): void
    {
        $order = Order::findByCode($orderCode);
        if(!$order){
            http_response_code(404);
            echo '404 - Không tìm thấy đơn hàng'; 
            return;
        }
        $this->render('checkout/success', [
            'title' => 'Đặt hàng thành công',
            'order' => $order,
        ]);
    }
}