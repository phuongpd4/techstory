<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h4 fw-bold mb-0">
        Quản lý giảm giá
    </h1>
    <a href="/admin" class="btn btn-outline-secondary btn-sm">
        Bảng điều khiển
    </a>
</div>

<div class="row g-4">
    <div class="col-md-4">
        <form method="POST" action="/admin/ma-giam-gia" class="card border-0 shadow-sm p-3">
            <?= csrf_field(); ?>
            <h6 class="fw-bold mb-3">
                Tạo mã khuyến mãi mới
            </h6>
            <input type="text" name="code" class="form-control form-control-sm mb-2" placeholder="Mã (VD: TECH100K)" required>
            <select name="type" id="" class="form-select form-select-sm mb-2">
                <option value="fixed">
                    Giảm tiền mặt (VNĐ)
                </option>
                <option value="percent">
                    Giảm theo phần trăm (%)
                </option>
            </select>
            <input type="number" name="value" class="form-control form-control-sm mb-2" placeholder="giá trị giảm" required>
            <input type="number" name="min_order" class="form-control form-control-sm mb-2" placeholder="Đơn tối thiểu" value="0">
            <input type="number" name="usage_limit" class="form-control form-control-sm mb-3" placeholder="Giới hạn lượt dùng" value="100">
            <button type="submit" class="btn btn-primary btn-sm w-100">Lưu mã giảm giá</button>
        </form>
    </div>
    <div class="col-md-8">
        <div class="card border-0 shadow-sm">
            <table class="table align-middle small mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Mã Code</th>
                        <th>Mức giảm</th>
                        <th>Đơn tối thiểu</th>
                        <th>Đã dùng</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($coupons as $c): ?>
                        <tr>
                            <td>
                                <code class="fw-bold">
                                    <?= e($c['code']) ?>
                                </code>
                            </td>
                            <td class="text-danger fw-semibold">
                                <?= $c['type'] === 'percent' ? (int)$c['value'] . '%' : money((int)$c['value']) ?>
                            </td>
                            <td>
                                <?= money((int)$c['min_order']) ?>
                            </td>
                            <td>
                                <?= (int)$c['used_count'] ?> / <?= (int)$c['usage_limit'] ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>    
                </tbody>
            </table>
        </div>
    </div>
</div>