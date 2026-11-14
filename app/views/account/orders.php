<?php
$statusLabels = [
    'pending' =>['Chờ xác nhận', 'warning'],
    'confirmed' => ['Đã xác nhận', 'info'],
    'shipping' => ['Đang giao', 'primary'],
    'completed' => ['Hoàn thành', 'success'],
    'cancelled' => ['Đã hủy', 'secondary']
];
?>

<h1 class="h4 fw-bold mb-4">
    Lịch sử đơn hàng của bạn
</h1>
<?php if(!empty($msg)):  ?>
    <div class="alert alert-success small">
        <?= e($msg) ?>
    </div>
<?php endif; ?>
<?php if(!empty($error)):  ?>
    <div class="alert alert-danger small">
        <?= e($error) ?>
    </div>
<?php endif; ?>

<?php if(empty($orders)): ?>
    <div class="card border-0 shadow-sm text-center p-5">
        <p class="text-muted mb-3">
            Bạn chưa có đơn hàng nào
        </p>
        <div>
                <a href="/san-pham" class="btn btn-primary btn-sm">
                    Mua sắm ngay
                </a>
        </div>
    </div>
<?php else: ?>
    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table align-middle small mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Mã đơn</th>
                        <th>Ngày đặt</th>
                        <th>Người nhận và địa chỉ</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái</th>
                        <th class="text-end">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($orders as $o): ?>
                    <?php [$label, $badge] = $statusLabels[$o['status']] ?? [$o['status'], 'secondary']; ?>
                    <tr>
                        <td>
                            <a href="/dat-hang-thanh-cong/<?= e($o['order_code']) ?>" class="fw-bold text-decoration-none">
                                <?= e($o['order_code']) ?>
                            </a>
                        </td>
                        <td class="text-muted">
                            <?= e($o['created_at'])  ?>
                        </td>
                        <td>
                            <div class="fw-semibold">
                                <?= e($o['receiver_name']) ?>
                                (<?= e($o['receiver_phone']) ?>)
                            </div>
                            <div class="text-muted">
                                <?= e($o['shipping_addr']) ?>
                            </div>
                        </td>
                        <td>
                            <div class="fw-bold text-danger">
                                <?= money($o['total']) ?>
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-<?= $badge ?>">
                                <?= $label ?>
                            </span>
                        </td>
                        <td class="text-end">
                            <a href="/dat-hang-thanh-cong/<?= e($o['order_code']) ?>" class="btn btn-sm btn-outline-primary">
                                Chi tiết
                            </a>
                            <?php if($o['status'] === 'pending'): ?>
                                <form method="POST" action="/tai-khoan/don-hang/huy" class="d-inline" onsubmit="return confirm('Bạn chắc chắn muốn hủy đơn hàng này');">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="order_id" value="<?= (int)$o['id'] ?>">
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        Hủy đơn
                                    </button>    
                                </form>
                                <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php endif; ?>    