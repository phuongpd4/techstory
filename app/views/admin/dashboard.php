<?php 
$statusLabel = [
    'pending' => ['Chờ xác nhận', 'warning'],
    'confirmed' => ['Đã xác nhận', 'info'],
    'shipping' => ['Đang giao', 'primary'],
    'completed' => ['Hoàn thành', 'success'],
    'cancelled' => ['Đã hủy', 'secondary'],
];?>

<div class="d-flex justify-conten-between align-items-center mb-4">
    <h1 class="h4 fw-bold mb-0">
        ⚙️ Bảng điều khiển Quản trị (Admin)
    </h1>
    <a href="/admin/san-pham" class="btn btn-primary btn-sm">
        📱 Quản lý Sản phẩm
    </a>
</div>

<?php if(!empty($msg)): ?>
<div class="alert alert-success small"><?= e($msg) ?></div>
<?php endif; ?>

<!-- Thống kê tổng quan -->
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm bg-primary text-white">
            <div class="card-body">
                <div class="small opacity-75">
                    Doanh thu tạm tính
                </div>
                <div class="fs-5 fw-bold mt-1">
                    <?=  money($stats['total_revenue']) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm bg-success text-white">
            <div class="card-body">
                <div class="small opacity-75">
                    Tổng đơn hàng
                </div>
                <div class="fs-5 fw-bold mt-1">
                    <?= (int)$stats['total_orders'] ?> đơn
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm bg-dark text-white">
            <div class="card-body">
                <div class="small opacity-75">
                    Tổng sản phẩm
                </div>
                <div class="fs-5 fw-bold mt-1">
                    <?= (int)$stats['total_products'] ?> mẫu
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm bg-secondary text-white">
            <div class="card-body">
                <div class="small opacity-75">
                    Khách hàng
                </div>
                <div class="fs-5 fw-bold mt-1">
                    <?= (int)$stats['total_users'] ?> 
                    tài khoản
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Bảng quản lý đơn hàng -->
 <div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3">
        <h5 class="card-title mg-0 fs-6 fw-bold">
            Danh sách đơn hàng gần đây
        </h5>
    </div>
    <div class="table-responsive">
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
                        <a href="/dat-hang-thanh-cong/<?= e($o['order_code']) ?>" class="fw-bold text-decoration-none">
                           <?= e($o['order_code']) ?> 
                        </a>
                        <div class="text-muted">
                            <?= e($o['created_at']) ?>
                        </div>
                    </td>
                    <td>
                        <div class="fw-semibold">
                            <?= e($o['receiver_name']) ?>
                        </div>
                        <div class="fw-muted">
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
 </div>
</div>