<?php
class AccountController extends Controller
{
    public function orders():void{
        $user = current_user();
        if(!$user){
            $this->redirect('/dang-nhap');
        }
        $this->render('account/orders',[
            'title' => 'Đơn hàng của bạn',
            'orders' => Order::byUser((int)$user['id']),
            'msg' => $_SESSION['acc_msg'] ?? null,
            'error' => $_SESSION['acc_err'] ?? null,
        ]);
        unset($_SESSION['acc_msg'], $_SESSION['acc_err']);
    }
    public function cancelOrder():void{
        verify_csrf();
        $user = current_user();
        if(!$user){
            $this->redirect('/dang-nhap');
        }
        $orderID = (int)($_POST['order_id'] ?? 0);
        try{
            Order::cancelByCustomer($orderID,(int)$user['id']);
            $_SESSION['acc_msg'] = 'Đã hủy đơn hàng thành công';
        }catch(Throwable $e){
            $_SESSION['acc_err'] = $e->getMessage();
        }
        $this->redirect('/tai-khoan/don-hang');
    }
    public function wishlist() : void {
        $user = current_user();
        if(!$user){
            $this->redirect('/dang-nhap');
        }
        $this->render('account/wishlist',[
            'title' => 'Sản phẩm yêu thích',
            'items' => Wishlist::byUser((int)$user['id']),
        ]);
    }
    public function toggleWishlist(): void{
        verify_csrf();
        $user = current_user();
        if(!$user){
            $this->redirect('/dang-nhap');
        }
        $productId = (int)($_POST['product_id'] ?? 0);
        if($productId > 0){
            Wishlist::toggle((int)$user['id'], $productId);
        }
        $this->redirect($_SERVER['HTTP_REFERER'] ?? '/yeu-thich');
    }
}