<h1 class="h4 mb-4">
    Địa chỉ nhận hàng
</h1>
<div class="row g-4">
        <div class="col-md-5">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h2 class="h6 mb-3">
                        Thêm địa chỉ mới
                    </h2>
                    <form method="POST" action="/tai-khoan/dia-chi">
                        <?= csrf_field() ?>
                        <input type="text" name="receiver" class="form-control form-control-sm mb-2" placeholder="Họ tên người nhận" required>
                        <input type="text" name="phone" class="form-control form-control-sm mb-2" placeholder="Số điện thoại" required>
                        <input type="text" name="province" class="form-control form-control-sm mb-2" placeholder="Tỉnh/Thành phố" required>
                        <input type="text" name="district" class="form-control form-control-sm mb-2" placeholder="Quận/Huyện" required>
                        <input type="text" name="ward" class="form-control form-control-sm mb-2" placeholder="Phường/Xã" required>
                        <input type="text" name="detail" class="form-control form-control-sm mb-3" placeholder="Số nhà, tên đường" required>
                        <button type="submit" class="btn btn-primary btn-sm w-100">Lưu địa chỉ</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <?php if(empty($addresses)): ?>
                <div class="alert alert-info">Bạn chưa lưu địa chỉ nhận hàng nào</div>
            <?php else: ?>
                <?php foreach($addresses as $a): ?>
                <div class="card border-0 shadow-sm mb-2">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <strong>
                                <?= e($a['receiver']) ?>
                            </strong> -
                            <span class="text-muted">
                                <?= e($a['phone']) ?>
                            </span>
                            <div class="small text-secondary mt-1">
                                <?= e($a['detail']) ?>,<?= e($a['ward']) ?>,
                                <?= e($a['district']) ?>,<?= e($a['province']) ?>
                                
                            </div>
                        </div>
                        <form method="POST" action="/tai-khoan/dia-chi/xoa" onsubmit="return confirm('Bạn muốn xóa địa chỉ này ?');">
                            <?= csrf_field() ?>
                            <input type="hidden" name="id" value="<?= (int)$a['id'] ?>">
                            <button type="submit" class="btn btn-sm btn-outline-danger">Xóa</button>
                        </form>
                    </div>
                </div>    
                <?php endforeach; ?>
            <?php endif; ?>    
        </div>
    </div>