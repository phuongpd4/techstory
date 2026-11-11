<?php

class AdminController extends Controller
{
    // Hiển thị thống kê và danh sách đơn hàng
    public function dashboard(): void
    {
        require_admin();
        $this->render('admin/dashboard',[
            'title' => 'Quản trị hệ thống',
            'stats' => Order::stats(),
            'orders' => Order::all(),
            'msg' => $_SESSION['admin_msg'] ?? null,]);

         unset($_SESSION['admin_msg']);
    }
    
    // Đổi trạng thái đơn hàng
    public function updateOrderStatus(): void
    {
        require_admin();
        verify_csrf();

        $orderId = (int)($_POST['order_id'] ?? 0);
        $status = $_POST['status'] ?? '';

        if($orderId > 0){
            Order::updateStatus($orderId, $status);
            $_SESSION['admin_msg'] = 'Đã cập nhật trạng thái đơn hàng ' . $orderId;
        }
        $this->redirect('/admin');
    }
}