<div class="row justify-content-center">
    <div class="col-12 col-lg-8">
        <div class="card border-0 shadow-sm p-4">
            <div class="text-center mb-4">
                <div class="display-4 mb-2">
                    <i class="bi bi-check-circle-fill text-success" style="font-size: 3rem;"></i>
                </div>
                <h1 class="h4 fw-bold text-success">
                    Đặt hàng thành công!
                </h1>
                <p class="text-muted mb-1">
                    Mã đơn hàng của bạn là: <strong class="text-dark"><?= e($order['order_code']) ?></strong>
                </p>
                  
            </div> 
            <div class="bg-light p-3 rounded small mb-4">
                <div><strong>Người nhận: </strong><?= e($order['receiver_name']) ?></div>
                <div><strong>Điện thoại: </strong><?= e($order['receiver_phone']) ?></div>
                <div><strong>Địa chỉ giao hàng: </strong><?= e($order['shipping_addr']) ?></div>
                <div><strong>Phương thức thanh toán: </strong><?= $order['payment_method'] === 'qr' ? 'Chuyển khoản QR' : 'Thanh toán khi nhận hàng (COD)' ?>
            </div>
            </div>
                        <?php if ($order['payment_method'] === 'qr' && $order['payment_status'] === 'pending' && $order['status'] === 'pending'): ?>
                <?php $qrInfo = urlencode('TECHSTORE ' . $order['order_code']);
                $qrUrl = "https://img.vietqr.io/image/ACB-27046651-compact2.png?amount=" . (int)$order['total'] . "&addInfo={$qrInfo}&accountName=" . urlencode('CONG TY TECHSTORE'); ?>
                <div class="border rounded-4 p-4 text-center mb-4 bg-white">
                    <h6 class="fw-bold mb-2">
                        <i class="bi bi-qr-code-scan me-1"></i>
                        Quét mã VietQR để thanh toán
                    </h6>
                    <img src="<?= e($qrUrl) ?>" alt="VietQR" class="img-fluid rounded border p-2 mb-3" style="max-width: 240px;">
                    <div class="small">Số tiền:
                        <strong class="text-danger">
                            <?= money((int)$order['total']) ?>
                        </strong>
                    </div>
                    <div class="small text-muted">
                        Nội dung chuyển khoản:
                        <strong class="text-dark">
                            TECHSTORE <?= e($order['order_code']) ?>
                        </strong>
                    </div>
                    <?php $timePayment = strtotime($order['created_at']) + 900; ?>
                    <div class="small text-danger fw-semibold mt-2" id="qrTimer"></div>
                    <div class="text-muted mt-1" style="font-size: 0.78rem;">
                        Vui lòng hoàn tất chuyển khoản trong 15 phút để xác nhận đơn hàng. Quá hạn đơn hàng sẽ tự hủy!
                    </div>
                    <script>
                       ( function(){
                            const end = <?= $timePayment ?> * 1000,
                            el = document.getElementById('qrTimer');
                            const tick = () => {
                                const s = Math.max(0, Math.floor((end - Date.now()) / 1000));
                                el.textContent = s > 0
                                 ? `Thời gian giữ đơn còn lại: ${String(Math.floor(s/60)).padStart(2,'0')}:${String(s%60).padStart(2,'0')}`
                            : 'Đã hết 15 phút giữ đơn — Vui lòng liên hệ cửa hàng nếu bạn đã chuyển khoản.';
                            }; 
                             tick(); setInterval(tick, 1000);
                        })();
                    </script>
                </div>
                <?php endif; ?>
            <h6 class="fw-bold mb-2">Chi tiết sản phẩm đã đặt</h6>
            <!-- Bảng chi tiết cho PC -->
             <div class="table-responsive d-none d-md-block mb-3">
                 <table class="table table-sm align-middle small mb-0">
                    <thead class="table-light">
                        <tr>
                            <td>Sản phẩm</td>
                            <td>Phiên bản</td>
                            <td>Mã phiên bản</td>
                            <td>Số lượng</td>
                            <td class="text-end">Thành tiền</td>
                        </tr>    
                    </thead>
                    <tbody>
                        <?php foreach($order['items'] as $it): ?>
                            <tr>
                                <td>
                                    <div class="d-lex align-items-center gap-2">
                                        <img src="<?= e($it['image']) ?>" alt=""
                                        style="width: 44px;height: 44px;object-fit:contain;"
                                        class="rounded border bg-white p-1 flex-shrink-0">
                                        <span class="fw-semibold">
                                            <?= e($it['product_name']) ?>
                                        </span>
                                    </div>
                                </td>
                                <td><?= e($it['variant_info']) ?></td>
                                <td>(<code><?= e($it['sku']) ?></code>)</td>
                                <td><?= (int)$it['quantity'] ?></td>
                                <td class="text-end fw-semibold">
                                    <?= money($it['price'] * $it['quantity']) ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>    
                    </tbody>
                 </table>           
             </div>  
            <!-- Danh sách thẻ dọc mobile -->     
            <div class="d-md-none d-grid gap-2 mb-3">
                <?php foreach ($order['items'] as $it): ?>
                <div class="border rounded-3 p-2 d-flex gap-2 align-items-center bg-white small">
                    <img src="<?= e($it['image']) ?>" alt=""
                    style="width:52px;height: 52px;object-fit:contain;" class="rounded border bg-white p-1 flex-shrink-0">
                    <div class="flex-grow-1">
                        <div class="fw-semibold text-dark">
                            <?= e($it['product_name']) ?>
                        </div>
                        <div class="text-muted" style="font-size: 0.76rem;">
                            <?= e($it['variant_info']) ?> • <code><?= e($it['sku']) ?></code>
                        </div>
                        <div class="d-flex justify-content-between mt-1">
                            <span class="text-muted">Số lương: <?= (int)$it['quantity'] ?></span>
                            <strong class="text-danger"><?= money($it['price'] * $it['quantity']) ?></strong>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
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
            <div class="d-flex flex-wrap justify-content-center gap-2 mt-4">
                <a href="/tai-khoan/don-hang" class="btn btn-outline-dark">Xem đơn hàng của tôi</a>
                <a href="/san-pham" class="btn btn-dark">Tiếp tục mua sắm</a>
            </div>
        </div>
    </div>
</div>