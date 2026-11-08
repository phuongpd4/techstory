<div class="row g-4">
  <!-- Cột trái: Bộ lọc -->
  <div class="col-12 col-lg-3">
    <form method="GET" action="/san-pham" class="card shadow-sm border-0">
      <div class="card-body">
        <h5 class="card-title mb-3">Bộ lọc tìm kiếm</h5>

        <!-- Từ khóa -->
        <div class="mb-3">
          <label class="form-label small fw-semibold">Từ khóa</label>
          <input type="text" name="q" class="form-control form-control-sm"
                 value="<?= e($filters['q']) ?>" placeholder="Tên sản phẩm...">
        </div>

        <!-- Danh mục -->
        <div class="mb-3">
          <label class="form-label small fw-semibold">Danh mục</label>
          <select name="category" class="form-select form-select-sm">
            <option value="">-- Tất cả danh mục --</option>
            <?php foreach ($categories as $c): ?>
              <option value="<?= e($c['slug']) ?>" <?= $filters['category'] === $c['slug'] ? 'selected' : '' ?>>
                <?= e($c['name']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <!-- Thương hiệu -->
        <div class="mb-3">
          <label class="form-label small fw-semibold">Thương hiệu</label>
          <select name="brand" class="form-select form-select-sm">
            <option value="">-- Tất cả thương hiệu --</option>
            <?php foreach ($brands as $b): ?>
              <option value="<?= e($b['slug']) ?>" <?= $filters['brand'] === $b['slug'] ? 'selected' : '' ?>>
                <?= e($b['name']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <!-- Khoảng giá -->
        <div class="mb-3">
          <label class="form-label small fw-semibold">Khoảng giá (VNĐ)</label>
          <div class="d-flex gap-2">
            <input type="number" name="min_price" class="form-control form-control-sm"
                   value="<?= e((string)$filters['min_price']) ?>" placeholder="Từ">
            <input type="number" name="max_price" class="form-control form-control-sm"
                   value="<?= e((string)$filters['max_price']) ?>" placeholder="Đến">
          </div>
        </div>

        <!-- Sắp xếp -->
        <div class="mb-3">
          <label class="form-label small fw-semibold">Sắp xếp theo</label>
          <select name="sort" class="form-select form-select-sm">
            <option value="">Mới nhất</option>
            <option value="price_asc"  <?= $filters['sort'] === 'price_asc'  ? 'selected' : '' ?>>Giá tăng dần</option>
            <option value="price_desc" <?= $filters['sort'] === 'price_desc' ? 'selected' : '' ?>>Giá giảm dần</option>
            <option value="name_asc"   <?= $filters['sort'] === 'name_asc'   ? 'selected' : '' ?>>Tên A → Z</option>
          </select>
        </div>

        <div class="d-grid gap-2">
          <button type="submit" class="btn btn-primary btn-sm">Áp dụng lọc</button>
          <a href="/san-pham" class="btn btn-outline-secondary btn-sm">Xóa bộ lọc</a>
        </div>
      </div>
    </form>
  </div>

  <!-- Cột phải: Kết quả sản phẩm -->
  <div class="col-12 col-lg-9">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h1 class="h4 mb-0">Danh sách sản phẩm</h1>
      <span class="text-muted small">Tìm thấy <strong><?= count($products) ?></strong> sản phẩm</span>
    </div>

    <?php if (empty($products)): ?>
      <div class="alert alert-warning">
        Không tìm thấy sản phẩm nào khớp với bộ lọc của bạn.
      </div>
    <?php else: ?>
      <div class="row g-4">
        <?php foreach ($products as $p): ?>
          <div class="col-12 col-sm-6 col-md-4">
            <div class="card h-100 shadow-sm">
              <img src="<?= e($p['image']) ?>" class="card-img-top" alt="<?= e($p['name']) ?>">
              <div class="card-body d-flex flex-column">
                <div class="small text-muted mb-1"><?= e($p['brand_name']) ?> • <?= e($p['category_name']) ?></div>
                <h5 class="card-title fs-6"><?= e($p['name']) ?></h5>
                <p class="card-text small text-secondary flex-grow-1"><?= e($p['short_desc']) ?></p>
                <div class="mt-2">
                  <span class="fs-6 fw-bold text-danger"><?= money($p['sale_price'] ?? $p['price']) ?></span>
                  <?php if (!empty($p['sale_price']) && $p['sale_price'] < $p['price']): ?>
                    <del class="small text-muted ms-1"><?= money($p['price']) ?></del>
                  <?php endif; ?>
                </div>
              </div>
              <div class="card-footer bg-white border-0 pt-0 pb-3">
                <a href="/san-pham/<?= e($p['slug']) ?>" class="btn btn-outline-primary btn-sm w-100">Xem chi tiết</a>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</div>