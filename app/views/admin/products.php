<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h4 fw-bold mb-0">
        Quản lý sản phẩm
    </h1>
    <a href="/admin" class="btn btn-outline-secondary btn-sm">
        Về Dashboard
    </a>
</div>
<?php if (!empty($msg)): ?>
    <div class="alert alert-success small">
        <?= e($msg) ?>
    </div>
<?php endif; ?>
<?php if (!empty($error)): ?>
    <div class="alert alert-danger small">
        <?= e($error) ?>
    </div>
<?php endif; ?>    

<div class="row g-4">
    <!-- Cột trái: Thêm sản phẩm mới -->
     <div class="col-12 col-lg-5">
        <form method="POST" action="/admin/san-pham" class="card border-0 shadow-sm">
            <?= csrf_field(); ?>
            <div class="card-header bg-dark text-white py-2">
                <h6 class="mb-0">
                    Thêm sản phẩm mới
                </h6>
            </div>
            <div class="card-body small">
                <div class="row g-2 mb-2">
                    <div class="col-6">
                        <label class="form-label fw-semibold">
                            Danh mục
                        </label>
                        <select name="category_id" class="form-select form-select-sm" require>
                            <?php foreach($categories as $c): ?>
                                <option value="<?= (int)$c['id'] ?>">
                                    <?= e($c['name']) ?>
                                </option>
                            <?php endforeach; ?>    
                        </select>
                    </div>
                    <div class="col-6">
                        <label class="form-label fw-semibold">Thương hiệu *</label>
                        <select name="brand_id" class="form-select form-select-sm" required>
                            <?php foreach ($brands as $b): ?>
                            <option value="<?= (int)$b['id'] ?>"><?= e($b['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="mb-2">
                    <label class="form-label fw-semibold">Tên sản phẩm *</label>
                    <input type="text" name="name" class="form-control form-control-sm" required placeholder="VD: Điện thoại Nova Z5">
                </div>
                <div class="row g-2 mb-2">
                    <div class="col-7">
                        <label class="form-label fw-semibold">Mã Model *</label>
                        <input type="text" name="model_code" class="form-control form-control-sm" required placeholder="VD: NV-Z5-2026">
                    </div>
                    <div class="col-5">
                        <label class="form-label fw-semibold">Bảo hành (tháng)</label>
                        <input type="number" name="warranty_months" value="12" class="form-control form-control-sm">
                    </div>
                </div>
                <div class="mb-2">
                    <label class="form-label fw-semibold">Điểm bán hàng (ngăn cách bởi dấu |)</label>
                    <input type="text" name="selling_points" class="form-control form-control-sm" placeholder="Màn hình 120Hz|Pin 5000mAh|Sạc 67W">
                </div>
                 <div class="mb-3">
                    <label class="form-label fw-semibold">Mô tả chi tiết</label>
                    <textarea name="description" rows="2" class="form-control form-control-sm"></textarea>
                 </div>
                 <hr>
                <h6 class="fw-bold text-primary mb-2">Biến thể mặc định & Giá</h6>
                <div class="row g-2 mb-2">
                    <div class="col-6">
                        <label class="form-label fw-semibold">Mã SKU *</label>
                        <input type="text" name="sku" class="form-control form-control-sm" required placeholder="VD: NV-Z5-BLK-256">
                    </div>
                    <div class="col-4">
                        <label class="form-label fw-semibold">Màu sắc *</label>
                        <input type="text" name="color" value="Đen titan" class="form-control form-control-sm" required>
                    </div>
                    <div class="col-2">
                        <label class="form-label fw-semibold">Hex</label>
                        <input type="color" name="color_hex" value="#1C1C1E" class="form-control form-control-color form-control-sm w-100">
                    </div>
                </div>
                <div class="row g-2 mb-2">
                    <div class="col-6">
                    <label class="form-label fw-semibold">RAM</label>
                    <input type="text" name="ram" class="form-control form-control-sm" placeholder="VD: 12GB">
                    </div>
                    <div class="col-6">
                    <label class="form-label fw-semibold">Bộ nhớ</label>
                    <input type="text" name="storage" class="form-control form-control-sm" placeholder="VD: 256GB">
                    </div>
            </div>
            <div class="row g-2 mb-2">
                <div class="col-5">
                    <label class="form-label fw-semibold">Giá gốc (VNĐ) *</label>
                    <input type="number" name="price" class="form-control form-control-sm" required placeholder="15990000">
                </div>
                <div class="col-5">
                    <label class="form-label fw-semibold">Giá KM (VNĐ)</label>
                    <input type="number" name="sale_price" class="form-control form-control-sm" placeholder="14990000">
                </div>
                <div class="col-2">
                    <label class="form-label fw-semibold">Kho *</label>
                    <input type="number" name="stock" value="10" class="form-control form-control-sm" required>
                </div>
            </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Link ảnh đại diện (để trống tự tạo ảnh mẫu)</label>
                    <input type="text" name="image_url" class="form-control form-control-sm" placeholder="https://...">
                </div>
                <button type="submit" class="btn btn-primary btn-sm w-100 py-2 fw-semibold">Lưu sản phẩm</button>
          </div>
        </form>
     </div>
     <!-- Cột phải: Danh sách sản phẩm hiện có -->
      <div class="col-12 col-lg-7">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h6 class="mg-0 fw-bold">
                    Danh sách sản phẩm trong kho (<?= count($products) ?>)
                </h6>
            </div>
            <div class="table-responsive">
                <table class="table align-middle small mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Sản phẩm</th>
                            <th>SKU / Màu</th>
                            <th>Giá bán</th>
                            <th>Kho</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $p): ?>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <img src="<?= e($p['image']) ?>" alt=""
                                         style="width:44px; object-fit:cover" class="rounded"> 
                                    </div>
                                    <a href="/san-pham/<?= e($p['slug']) ?>"
                                     class="fw-semibold text-dark text-decoration-none">
                                     <?= e($p['name']) ?>
                                    </a>
                                    <div class="text-muted">
                                        <?= e($p['brand_name']) ?> . <?= e($p['category_name']) ?>
                                    </div>
                                </td>
                                <td>
                                    <code><?= e($p['sku']) ?></code>
                                    <div class="text-muted">
                                        <?= e($p['color']) ?>
                                    </div>
                                </td>
                                <td class="fw-bold text-danger">
                                    <?= money($p['sale_price'] ?: $p['price']) ?>
                                </td>
                                <td>
                                    <span class="badge bg-secondary">
                                        <?= (int)$p['stock'] ?>
                                    </span>
                                </td>
                                <td class="text-end">
                                    <a href="/admin/san-pham/<?= (int)$p['id'] ?>/bien-the" class="btn btn-sm btn-outline-primary">
                                        Biến thể
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
      </div>
</div>