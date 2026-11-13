<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h4 fw-bold mb-1">
            Biến thể: <?= e($product['name']) ?>
        </h1>
        <div class="small text-muted">
            Mã Model:
            <strong>
                <?= e($product['model_code']) ?>
            </strong>
        </div>
    </div>
    <div class="d-flex gap-2">
        <a href="/san-pham/<?= e($product['slug']) ?>" 
        class="btn btn-outline-primary btn-sm" target="_blank">Xem trên shop
        </a>
        <a href="/admin/san-pham" class="btn btn-outline-secondary btn-sm">
            Danh sách sản phẩm
        </a>
    </div>
</div> 

<?php if (!empty($msg)): ?>
    <div class="alert alert-success small">
        <?= e($msg) ?>
    </div>
<?php endif; ?>
<?php if(!empty($error)): ?>
    <div class="alert alert-dark small">
        <?= e($error) ?>
    </div>
<?php endif; ?>

<div class="row g-4">
    <!-- Cột trái : Thêm biến thể màu, dung lượng mới -->
     <div class="col-12 col-lg-5">
        <form method="POST" action="/admin/san-pham/<?= (int)$product['id'] ?>/bien-the"
        enctype="multipart/form-data" class="card border-0 shadow-sm">
        <?= csrf_field() ?>
        <div class="card-header bg-primary text-white py-2">
            <h6 class="mg-0">
                Thêm màu sắc/ dung lượng mới
            </h6>
        </div>
        <div class="card-body small">
            <div class="mb-2">
                <label for="" class="form-label fw-semibold">
                    Mã SKU riêng của biến thể
                </label>
                <input type="text" name="sku" class="form-control form-control-sm" require placeholder="VD: LT-AR-SLV-14-1TB">
            </div>
            <div class="row g-2 mb-2">
                <div class="col-8">
                    <label for="" class="form-label fw-semibold">
                        Tên màu sắc
                    </label>
                    <input type="text" name="color" class="form-control form-control-sm" require placeholder="VD: Bạc ánh kim">
                </div>
                <div class="col-4">
                    <label for="" class="form-label fw-semibold">
                        Mã màu(Hex)
                    </label>
                    <input type="color" name="color_hex" value="#3B82F6" class="form-control form-control-color form-control-sm w-100">
                </div>
            </div>
            <div class="row g-2 mb-2">
                <div class="col-6">
                    <label for="" class="form-label fw-semibold">
                        RAM
                    </label>
                    <input type="text" name="ram" class="form-comtrol form-control-sm" placeholder="VD: 16GB">
                </div>
                <div class="col-6">
                    <label for="" class="form-label fw-semibold">
                        Bộ nhớ
                    </label>
                    <input type="text" name="storage" class="form-control form-control-sm" placeholder="VD: 1TB">
                </div>
            </div>
            <div class="row g-2 mb-3">
                <div class="col-5">
                    <label for="" class="form-label fw-semibold">
                        Giá gốc (VNĐ)
                    </label>
                    <input type="number" name="price" class="form-control form-control-sm" require placeholder="24990000">
                </div>
                <div class="col-5">
                    <label for="" class="form-label fw-semibold">
                        Giá khuyến mãi
                    </label>
                    <input type="number" name="sale_price" class="form-control form-control-sm" placeholder="23990000">
                </div>
                <div class="col-2">
                    <div class="form-label fw-semibold">
                        Kho
                    </div>
                    <input type="number" name="stock" value="10" class="form-control form-control-sm" require>
                </div>
            </div>

            <hr>
            <h6 class="fw-bold text-dark mb-2">
                Ảnh của riêng màu này
            </h6>
            <div class="mb-2">
                <label for="" class="form-label fw-semibold">
                    Cách 1: Chọn file ảnh từ máy tính của bạn (JPG, PNG, WebP)
                </label>
                <input type="file" name="image_file" accept="image/*" class="form-control form-control-sm">
            </div>
            <div class="mb-3">
                <label for="" class="form-label fw-semibold">
                    Cách 2: Hoặc dán link ảnh (nếu không upload file)
                </label>
                <input type="text" name="image_url" class="form-control form-control-sm" placeholder="https://...">
            </div>
            <button type="submit" class="btn btn-primary btn-sm w-100 py-2 fw-semibold">
                Lưu biến thể mới
            </button>
          </div>
        </form>
     </div>

     <!-- Cột phải : Danh sách các biến thể hiện có của sản phẩm này -->

     <div class="col-12 col-lg-7">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold">
                    Các phiên bản hiện có (<?= count($variants) ?>)
                </h6>
            </div>
            <div class="table-responsive">
                <table class="table align-middle small mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Ảnh và màu</th>
                            <th>SKU</th>
                            <th>RAM / Bộ nhớ</th>
                            <th>Giá bán</th>
                            <th>Kho</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($variants as $v): ?>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <img src="<?= e($v['image']) ?>" alt="" style="width: 48px; height: 40px; object-fit:cover;" class="rounded border">
                                        <div>
                                            <span class="d-inline-block rounded-circle border me-1"
                                            style="width:12px; height: 12px; background: <?= e($v['color_hex']) ?>">
                                            </span>
                                            <strong><?= e($v['color']) ?></strong>
                                            <?php if($v['is_default']): ?>
                                                <span class="badge bg-dark ms-1">
                                                    Mặc định
                                                </span>
                                                <?php endif; ?>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <code>
                                        <?= e($v['sku']) ?>
                                    </code>
                                </td>
                                <td>
                                    <?= e(trim(($v['ram']) ?? '') . ' ' . ($v['storage'] ?? '')) ?: '-' ?>
                                </td>
                                <td>
                                    <div class="fw-bold text-danger">
                                        <?= money($v['sale_price'] ?: $v['price']) ?>
                                    </div>
                                    <?php if(!empty($v['sale_price']) && $v['sale_price'] < $v['price']): ?>
                                    <del class="text-muted">
                                        <?= money($v['price']) ?>
                                    </del>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="badge bg-secondary">
                                        <?= (int)$v['stock'] ?>
                                    </span>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
     </div>
</div>