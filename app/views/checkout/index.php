<?php

$items = $summary['items'];
$subtotal = $summary['subtotal'];
$discount = $summary['discount'];
$finalTotal = $summary['total'] + $shippingFee;
?>

<h1 class="h4 fw-bold mb-4">Thanh toán và đặt hàng</h1>
<?php 
if(!empty($error)): ?>
    <div class="alert alert-danger small"><?=  e($error); ?></div>
<?php endif; ?>

<form method="POST" action="/thanh-toan" class="row g-4">
    <?=  csrf_field() ?>

<!-- Cột trái: thông tin giao hàng và thanh toán -->
 <div class="col-12 col-lg-7">
    <div class="card border-0 shadow-sm mb-3">
        <div class="card-body p-4">
           <h5 class="card-title mb-3">Thông tin người nhận</h5>
           <div class="mb-3">
                <label class="form-label small fw-semibold">Họ và tên người nhận *</label>
                <input type="text" name="receiver_name" class="form-control"
                 required value="<?= e($old['receiver_name'] ?? $user['name'] ?? '') ?>">
           </div>
           <div class="mb-3">
                <label class="form-label small fw-semibold">Số điện thoại liên hệ *</label>
                <input type="text" name="receiver_phone" class="form-control"
                 required value="<?= e($old['receiver_phone'] ?? '') ?>" placeholder="VD: 0912345678">
           </div>
           <div class="mb-3">
            <label class="form-label small fw-semibold">Địa chỉ nhận hàng *</label>
            <textarea name="shipping_addr" class="form-control"
             required placeholder="Số nhà, tên đường, phường/xã, quận/huyện, tỉnh/thành phố"><?= e($old['shipping_addr'] ?? '') ?></textarea>
           </div>
           <div class="mb-3">
            <label class="form-label small fw-semibold">Ghi chú đơn hàng(tùy chọn)</label>
            <input type="text" name="note" class="form-control"
            value="<?= e($old['note'] ?? '') ?>" placeholder="Giao giờ hành chính, gọi trước khi giao...">
           </div>

          <h6 class="fw-bold mt-4 mb-3">Phương thức thanh toán</h6>
          <div class="d-grid gap-2">
            <label for="payCod" class="ratio-card">
                <input type="radio" class="form-check-input mt-0" name="payment_method" id="payCod" value="cod" checked>
                <i class="bi bi-cash-stack fs-4 text-dark"></i>
                <div>
                    <div class="fw-semibold small">
                        Thanh toán khi nhận hàng (COD)
                    </div>
                    <div class="text-muted" style="font-size: 0.78rem;">
                        Kiểm tra sản phẩm trước khi thanh toán tiền mặt
                    </div>
                </div>
            </label>
            <label for="payQr" class="ratio-card">
                <input type="radio" class="form-check-input mt-0" name="payment_method" id="payQr" value="qr">
                <i class="bi bi-qr-code-scan fs-4 text-dark"></i>
                <div>
                    <div class="fw-semibold small">
                        Chuyển khoản ngân hàng (Mã VietQR)
                    </div>
                    <div class="text-muted" style="font-size:0.78rem;">
                        Tự động điền sẵn số tiền và mã đơn hàng, xác nhận nhanh chóng
                    </div>
                </div>
            </label>
          </div>
        </div>
    </div>
 </div>

 <!-- Cột phải: Tóm tắt đơn hàng -->
 <div class="col-12 col-lg-5">
    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <h5 class="card-title mb-3">Đơn hàng của bạn (<?= count($items) ?> sản phẩm)</h5>
            <ul class="list-group list-group-flush mb-3">
                <?php
                    foreach ($items as $item): ?>
                <li class="list-group-item px-0 d-flex justify-content-between align-items-center gap-2 small">
                    <div class="d-flex.align-items-center gap-2">
                        <img src="<?= e($item['image']) ?>" alt="" style="width:48px;height:48px;object-fit:contain;" class="rounded border bg-white p-1">
                    <div>
                        <div class="fw-semibold"><?= e($item['product_name']) ?>(x<?= (int)$item['qty'] ?>)</div>
                        <div class="text-muted"><?= e($item['color']) ?><?= !empty($item['storage']) ? '. ' . e($item['storage']) : '' ?></div>
                    </div>    
                    </div>
                    <span class="fw-semibold text-nowrap"><?= money($item['line_total']) ?></span>
                </li>
                <?php endforeach; ?>
            </ul>
            <div class="d-flex justify-content-between small mb-2">
                <span>Tạm tính:</span>
                <span><?= money($subtotal) ?></span>
            </div>
            <div class="d-flex justify-content-between small mb-2 text-success">
                <span>Giảm giá:</span>
                <span>-<?= money($discount) ?></span>
            </div>
            <div class="d-flex justify-content-between small mb-2">
                <span>Phí vận chuyển:</span>
                <span><?= $shippingFee == 0 ? 'Miễn phí' : money($shippingFee) ?></span>
            </div>
            <hr>
            <div class="d-flex justify-content-between fw-bold fs-5 mb-4">
                <span>Tổng thanh toán:</span>
                <span class="text-danger"><?= money($finalTotal) ?></span>
            </div>
            <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold"><i class="bi bi-check2-circle me-1"></i> Xác nhận đặt hàng</button>
            <a href="/gio-hang" class="btn btn-outline-dark btn-sm w-100 mt-2 text-decoration-none">← Quay lại giỏ hàng</a>
        </div>
    </div>
 </div>
</form>