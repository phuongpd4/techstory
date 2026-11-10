<div class="row justify-content-center">
    <div class="col-12 col-lg-8">
        <div class="card border-0 shadow-sm p-4">
            <div class="text-center mb-4">
                <div class="display-4 mb-2">
                    🎉
                </div>
                <h1 class="h4 fw-bold text-success">
                    Đặt hàng thành công!
                </h1>
                <p class="text-muted mb-1">
                    Mã đơn hàng của bạn là: <strong class="text-dark"><?= e($order['order_code']) ?></strong>
                </p>
                <span class="badge bg-warning text-dark">Chờ xác nhận</span>
            </div> 
            <div class="bg-light p-3 rounded small mb-4">
                <div><strong>Người nhận: </strong><?= e($order['receiver_name']) ?></div>
                <div><strong>Điện thoại: </strong><?= e($order['receiver_phone']) ?></div>
                <div><strong>Địa chỉ giao hàng: </strong><?= e($order['shipping_addr']) ?></div>
                <div><strong>Phương thức thanh toán: </strong><?= $order['payment_method'] === 'qr' ? 'Chuyển khoản QR' : 'Thanh toán khi nhận hàng (COD)' ?>
            </div>
            </div>
            <h6 class="fw-bold mb-2">Chi tiết sản phẩm đã đặt</h6>
            <table class="table table-sm small mb-3">
                <thead class="table-light">
                    <tr>
                        <th>Sản phẩm: </th>
                        <th>Phiên bản: </th>
                        <th>Số lượng: </th>
                        <th class="text-end">Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($order['items'] as$it): ?>
                    <tr>
                        <td><?= e($it['product_name']) ?></td>
                        <td><?= e($it['variant_info']) ?>(<code><?= e($it['sku']) ?></code>)</td>
                        <td><?= (int)$it['quantity'] ?></td>
                        <td class="text-end"><?= money($it['price']* $it['quantity']) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="text-end small">
                <div>Tạm tính: <strong>
                    <?= money($order['subtotal']) ?>
                </strong></div>
                <div>Giảm giá: <strong class="text-success">
                    -<?= money($order['discount']) ?>
                </strong></div>
                <div>Phí vận chuyển: <strong> 
                    <?= money($order['shipping_fee']) ?>
                </strong></div>
                <div class="fs-5 fw-bold text-danger mt-1">
                    Tổng cộng: <?= money($order['total']) ?>
                </div>
            </div>
            <div class="text-center mt-4">
                <a href="/san-pham" class="btn btn-primary">Tiếp tục mua sắm</a>
            </div>
        </div>
    </div>
</div>