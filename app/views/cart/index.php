<?php
$items    = $summary['items'];
$subtotal = $summary['subtotal'];
$discount = $summary['discount'];
$total    = $summary['total'];
$coupon   = $summary['coupon'];
?>

<h1 class="h4 fw-bold mb-4">🛒 Giỏ hàng của bạn</h1>

<?php if (!empty($msg)): ?>
  <div class="alert alert-info small"><?= e($msg) ?></div>
<?php endif; ?>

<?php if (empty($items)): ?>
  <div class="card border-0 shadow-sm text-center p-5">
    <p class="text-muted mb-3">Giỏ hàng của bạn đang trống.</p>
    <div>
      <a href="/san-pham" class="btn btn-primary">Tiếp tục mua sắm</a>
    </div>
  </div>
<?php else: ?>
  <div class="row g-4">
    <!-- Cột trái: Danh sách mặt hàng -->
    <div class="col-12 col-lg-8">
      <form method="POST" action="/gio-hang/cap-nhat" class="card border-0 shadow-sm">
        <?= csrf_field() ?>
        <div class="table-responsive">
          <table class="table align-middle mb-0">
            <thead class="table-light small">
              <tr>
                <th>Sản phẩm</th>
                <th>Đơn giá</th>
                <th style="width: 110px;">Số lượng</th>
                <th>Thành tiền</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($items as $item): ?>
                <tr>
                  <td>
                    <div class="d-flex align-items-center gap-3">
                      <img src="<?= e($item['image']) ?>" alt="" style="width:60px;height:60px;object-fit:cover;" class="rounded">
                      <div>
                        <a href="/san-pham/<?= e($item['product_slug']) ?>" class="fw-semibold text-dark text-decoration-none">
                          <?= e($item['product_name']) ?>
                        </a>
                        <div class="small text-muted">
                          Phiên bản: <?= e($item['color']) ?>
                          <?= !empty($item['storage']) ? '• ' . e($item['storage']) : '' ?>
                          (SKU: <?= e($item['sku']) ?>)
                        </div>
                      </div>
                    </div>
                  </td>
                  <td><?= money($item['unit_price']) ?></td>
                  <td>
                    <input type="number"
                           name="qty[<?= (int)$item['variant_id'] ?>]"
                           value="<?= (int)$item['qty'] ?>"
                           min="0" max="<?= (int)$item['stock'] ?>"
                           class="form-control form-control-sm">
                  </td>
                  <td class="fw-bold text-danger"><?= money($item['line_total']) ?></td>
                  <td class="text-end">
                    <button type="submit" form="removeForm-<?= (int)$item['variant_id'] ?>" class="btn btn-sm btn-outline-danger">✕</button>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <div class="card-footer bg-white d-flex justify-content-between">
          <a href="/san-pham" class="btn btn-outline-secondary btn-sm">← Mua thêm sản phẩm</a>
          <button type="submit" class="btn btn-dark btn-sm">Cập nhật số lượng</button>
        </div>
      </form>

      <!-- Các form ẩn dùng để xóa từng dòng sản phẩm -->
      <?php foreach ($items as $item): ?>
        <form id="removeForm-<?= (int)$item['variant_id'] ?>" method="POST" action="/gio-hang/xoa" class="d-none">
          <?= csrf_field() ?>
          <input type="hidden" name="variant_id" value="<?= (int)$item['variant_id'] ?>">
        </form>
      <?php endforeach; ?>
    </div>

    <!-- Cột phải: Mã giảm giá & Tổng tiền -->
    <div class="col-12 col-lg-4">
      <div class="card border-0 shadow-sm mb-3">
        <div class="card-body">
          <h6 class="fw-bold mb-2">Mã khuyến mãi</h6>
          <form method="POST" action="/gio-hang/ma-giam-gia" class="d-flex gap-2">
            <?= csrf_field() ?>
            <input type="text" name="coupon_code" class="form-control form-control-sm"
                   value="<?= e($coupon['code'] ?? '') ?>" placeholder="VD: TECH50K, WELCOME10">
            <button type="submit" class="btn btn-outline-primary btn-sm text-nowrap">Áp dụng</button>
          </form>
          <div class="small text-muted mt-2">
            Gợi ý: Nhập <code>TECH50K</code> (giảm 50k) hoặc <code>WELCOME10</code> (giảm 10% đơn từ 5tr).
          </div>
        </div>
      </div>

      <div class="card border-0 shadow-sm">
        <div class="card-body">
          <h6 class="fw-bold mb-3">Tóm tắt đơn hàng</h6>
          <div class="d-flex justify-content-between small mb-2">
            <span>Tạm tính:</span>
            <span><?= money($subtotal) ?></span>
          </div>
          <div class="d-flex justify-content-between small mb-2 text-success">
            <span>Giảm giá <?= $coupon ? '(' . e($coupon['code']) . ')' : '' ?>:</span>
            <span>-<?= money($discount) ?></span>
          </div>
          <hr>
          <div class="d-flex justify-content-between fw-bold fs-5 mb-3">
            <span>Tổng cộng:</span>
            <span class="text-danger"><?= money($total) ?></span>
          </div>
          <a href="/thanh-toan" class="btn btn-primary w-100">Tiến hành đặt hàng →</a>
        </div>
      </div>
    </div>
  </div>
<?php endif; ?>