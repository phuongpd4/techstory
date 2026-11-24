<?php 
$statusLabel = [
    'pending' => ['Chờ xác nhận', 'warning'],
    'confirmed' => ['Đã xác nhận', 'info'],
    'shipping' => ['Đang giao', 'primary'],
    'completed' => ['Hoàn thành', 'success'],
    'cancelled' => ['Đã hủy', 'secondary'],
];?>

<div class="d-flex flex-wrap justify-conten-between align-items-center gap-2 mb-4">
    <h1 class="h4 fw-bold mb-0">
        <i class="bi bi-sliders me-2"></i>
        Bảng điều khiển Quản trị
    </h1>
    <div class="d-flex-gap-2">
        <a href="/admin/san-pham" class="btn btn-dark btn-sm">
        <i class="bi bi-box-seam me-1"></i>
        Sản phẩm
    </a>
    <a href="/admin/ma-giam-gia" class="btn btn-outline-dark btn-sm">
        <i class="bi bi-ticket-perforated me-1"></i>   
        Mã giảm giá
    </a>
    </div>
</div>

<?php if(!empty($msg)): ?>
<div class="alert alert-success small"><?= e($msg) ?></div>
<?php endif; ?>

<!-- Thống kê tổng quan -->
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="kpi-card h-100">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="kpi-icon">
                    <i class="bi bi-currency-dollar"></i>
                </span>
            </div>
            <div class="fs-5 fw-bold text-danger">
                <?= money($stats['total_revenue']) ?>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="kpi-card h-100">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="small text-muted fw-medium">
                    Tổng đơn hàng
                </span>
                <span class="kpi-icon">
                    <i class="bi bi-bag-check"></i>
                </span>
            </div>
            <div class="fs-5 fw-bold">
                <?= (int)$stats['total_orders'] ?> đơn
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="kpi-card h-100">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="small text-muted fw-medium">
                    Tổng sản phẩm
                </span>
                <span class="kpi-icon">
                    <i class="bi bi-box-seam"></i>
                </span>
            </div>
            <div class="fs-5 fw-bold">
                <?= (int)$stats['total_products'] ?> Mẫu
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="kpi-card h-100">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="small text-muted fw-medium">
                    Khách hàng
                </span>
                <span class="kpi-icon">
                    <i class="bi bi-people"></i>
                </span>
            </div>
            <div class="fs-5 fw-bold">
                <?= (int)$stats['total_users'] ?>Tài khoản
            </div>
        </div>
    </div>
</div>
<!-- Biểu đồ doanh thu 7 ngày gần nhất -->
 <div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <h6 class="fw-bold mb-3">
            Biểu đồ doanh thu theo ngày
        </h6>
        <canvas id="revChart" height="80"></canvas>
    </div>
 </div>
 <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
 <script>
    new Chart(document.getElementById('revChart'),
{
    type: 'bar',
    data: {
        labels: <?= json_encode(array_column($chartData ?? [], 'day')) ?>,
        datasets: [{
            label: 'Doanh thu (VNĐ)',
            data: <?= json_encode(array_column($chartData ?? [], 'revenue')) ?>,
            backgroundColor: '#09090b'
        }]
    }
});
 </script>
<!-- Bảng quản lý đơn hàng -->
 <div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3">
        <h5 class="card-title mb-0 fs-6 fw-bold">
            Danh sách đơn hàng gần đây
        </h5>
    </div>
    <div class="table-responsive d-none d-md-block">
        <table class="table align-middle small mb-0">
            <thead class="table-light">
                <tr>
                    <th>Mã đơn</th>
                    <th>Khách hàng</th>
                    <th>Địa chỉ nhận</th>
                    <th>Tổng tiền</th>
                    <th>Trạng thái</th>
                    <th>Đổi trạng thái</th>
                </tr>
            </thead>
            <tbody>
                <?php if(empty($orders)): ?>
                  <tr>
                    <td colspan="6" class="text-center text-muted py-4">
                        Chưa có đơn hàng nào
                    </td>
                  </tr>
                  <?php else: ?>
                   <?php foreach ($orders as $o): ?>
                    <?php [$label,$badge] = $statusLabel[$o['status']] ?? [$o['status'],'secondary']; ?>  
                  <tr>
                    <td>
                       <div class="d-flex align-items-center gap-2">
                        <img src="<?= e($o['first_image']) ?>" alt="" style="width: 44px;height: 44px;object-fit:contain;" class="rounded border bg-white p-1 flex-shrink-0">
                        <div>
                            <a href="/dat-hang-thanh-cong/<?= e($o['order_code']) ?>" class="fw-bold text-dark text-decoration-none">
                                <?= e($o['order_code']) ?>
                            </a>
                            <div class="text-muted" style="font-size:0.75rem">
                                <?= e($o['first_product'] ?? '') ?><?= (int)($o['item_count'] ?? 1) > 1 ? ' (+' . ((int)$o['item_count'] - 1) . ')' : '' ?>
                            </div>
                        </div>
                       </div>
                        <div class="text-muted">
                            <?= e($o['created_at']) ?>
                        </div>
                    </td>
                    <td>
                        <div class="fw-semibold">
                            <?= e($o['receiver_name']) ?>
                        </div>
                        <div class="text-muted">
                            <?= e($o['receiver_phone']) ?>
                        </div>
                    </td>
                    <td style="max-width: 240px;"><?= e($o['shipping_addr']) ?></td>
                    <td class="fw-bold text-danger">
                        <?= money($o['total']) ?>
                    </td>
                    <td>
                        <span class="badge bg-<?= $badge ?>">
                            <?= $label ?>
                        </span>
                    </td>
                    <td>
                        <form method="POST" action="/admin/don-hang/trang-thai" class="d-flex gap-1">
                            <?= csrf_field() ?>
                            <input type="hidden" name="order_id" value="<?= (int)$o['id'] ?>">
                            <select name="status" class="form-select form-select-sm" style="width: 140px;">
                                <?php foreach ($statusLabel as $key => [$text]): ?>
                                  <option value="<?= $key ?>" <?= $o['status'] === $key ? 'selected' : '' ?>>
                                    <?= $text ?>
                                  </option>  
                                <?php endforeach; ?>    
                            </select>
                            <button type="submit" class="btn btn-sm btn-outline-dark">Lưu</button>
                        </form>
                    </td>
                  </tr>
                  <?php endforeach; ?>
                  <?php endif; ?>   
            </tbody>
        </table>
        
    </div>
<!-- Đơn hàng mobile -->
    <div class="d-md-none p-3 d-grid gap-3">
       <?php foreach($orders as $o): ?>
        <?php [$label, $badge] = $statusLabel[$o['status']] ?? [$o['status'], 'secondary']; ?>
        <div class="border rounded-3 p-3 bg-white">
            <div class="d-flex align-items-center gap-3 mb-2">
                <img src="<?= e($o['first_image'] ?? '/assets/images/placeholder.svg') ?>" alt=""
                     style="width:52px;height:52px;object-fit:contain;" class="rounded border bg-white p-1 flex-shrink-0">
                <div class="small">
                    <div class="fw-semibold text-dark"><?= e($o['first_product'] ?? 'Đơn hàng TechStore') ?></div>
                    <?php if ((int)($o['item_count'] ?? 1) > 1): ?>
                        <div class="text-muted">và <?= (int)$o['item_count'] - 1 ?> sản phẩm khác</div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center pb-2 mb-2 border-bottom">
                
                <a href="/dat-hang-thanh-cong/<?= e($o['order_code']) ?>" class="fw-bold text-dark text-decoration-none">
                    <?= e($o['order_code']) ?>
                </a>
                <span class="badge bg-<?= $badge ?>">
                    <?= $label ?>
                </span>
                
            </div>
            <div class="small fw-semibold">
                <?= e($o['receiver_name']) ?> • <?= e($o['receiver_phone']) ?> 
            </div>
            <div class="small text-muted mb-2">
                <?= e($o['shipping_addr']) ?>
            </div>
            <div class="fw-bold text-danger mb-2">
                <?= money($o['total']) ?>
            </div>
            <form method="POST" action="/admin/don-hang/trang-thai" class="d-flex gap-2">
                <?= csrf_field() ?>
                <input type="hidden" name="order_id" value="<?= (int)$o['id'] ?>">
                <select name="status" id="" class="form-select form-select-sm">
                    <?php foreach ($statusLabel as $key => [$text]):  ?>
                        <option value="<?= $key ?>" <?= $o['status'] === $key ? 'selected' : '' ?>>
                            <?= $text ?>
                        </option>
                    <?php endforeach; ?>    
                </select>
                <button type="submit" class="btn btn-sm btn-dark text-nowrap">
                    Lưu
                </button>
            </form>
        </div>
        <?php endforeach; ?>                             
    </div>
 </div>
