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
    <div class="card d-none d-md-block">
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
                            <a href="/dat-hang-thanh-cong/<?= e($o['order_code']) ?>" class="fw-bold text-dark text-decoration-none">
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
                        <td class="text-end text-nowrap">
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
        <!-- Giao diện thẻ dọc cho Điện thoại (Mobile) -->
    <div class="d-md-none d-grid gap-3">
        <?php foreach ($orders as $o): ?>
            <?php [$label, $badge] = $statusLabels[$o['status']] ?? [$o['status'], 'secondary']; ?>
            <div class="card p-3">
                <div class="d-flex justify-content-between align-items-center pb-2 mb-2 border-bottom">
                    <a href="/dat-hang-thanh-cong/<?= e($o['order_code']) ?>" class="fw-bold text-dark text-decoration-none"><?= e($o['order_code']) ?></a>
                    <span class="badge bg-<?= $badge ?>"><?= $label ?></span>
                </div>
                <div class="d-flex align-items-center gap-3 mb-2">
                    <img src="<?= e($o['first_image']) ?>" alt="Ảnh sản phẩm" style="width:56px;height:56px;object-fit:contain" class="rounded border bg-white p-1 flex-shrink-0">
                    <div class="small">
                        <div class="fw-semibold text-dark">
                            <?= e($o['first_product'] ?? 'Đơn hàng TechStore') ?>
                        </div>
                        <?php if((int)($o['item_count'] ?? 1) > 1): ?>
                            <div class="text-muted">và
                                <?= (int)$o['item_count'] - 1 ?> sản phẩm khác
                            </div>
                        <?php endif; ?>    
                    </div>
                </div>
                <div class="small text-muted mb-1"><i class="bi bi-clock me-1"></i><?= date('d/m/Y H:i', strtotime($o['created_at'])) ?></div>
                <div class="small fw-semibold"><?= e($o['receiver_name']) ?> • <?= e($o['receiver_phone']) ?></div>
                <div class="small text-muted mb-2"><?= e($o['shipping_addr']) ?></div>
                <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                    <span class="fw-bold text-danger"><?= money($o['total']) ?></span>
                    <div class="d-flex gap-2">
                        <a href="/dat-hang-thanh-cong/<?= e($o['order_code']) ?>" class="btn btn-sm btn-outline-dark">Chi tiết</a>
                        <?php if ($o['status'] === 'pending'): ?>
                            <form method="POST" action="/tai-khoan/don-hang/huy" onsubmit="return confirm('Bạn chắc chắn muốn hủy đơn hàng này?');">
                                <?= csrf_field() ?>
                                <input type="hidden" name="order_id" value="<?= (int)$o['id'] ?>">
                                <button type="submit" class="btn btn-sm btn-outline-danger">Hủy đơn</button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>    