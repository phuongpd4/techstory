<!-- Banner chính -->
<div class="p-4 p-md-5 mb-4 rounded-3 bg-dark text-white">
  <div class="col-md-8 px-0">
    <span class="badge bg-primary mb-2">Flagship 2026</span>
    <h1 class="display-6 fw-bold">Nova X Pro – Đỉnh cao nhiếp ảnh & hiệu năng</h1>
    <p class="lead my-3">Màn hình AMOLED 120Hz, khung viền Titan siêu bền, sạc siêu nhanh 67W.</p>
    <a href="/san-pham/dien-thoai-nova-x-pro" class="btn btn-primary">Khám phá ngay</a>
  </div>
</div>

<h1 class="h4 mb-4">Thương hiệu</h1>
<div class="row g-3 mb-4">
  <?php foreach ($brands as $b): ?>
    <div class="col-6 col-md-4">
      <div class="card h-100">
        <div class="card-body">
          <h5 class="card-title"><?= e($b['name']) ?></h5>
          <p class="text-muted mb-0">Slug: <?= e($b['slug']) ?></p>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
</div>


<h1 class="h4 mb-4">Danh mục sản phẩm</h1>
<div class="row g-3 mb-5">
  <?php foreach ($categories as $c): ?>
    <div class="col-6 col-md-3">
      <div class="card h-100">
        <div class="card-body">
          <h5 class="card-title"><?= e($c['name']) ?></h5>
          <p class="text-muted mb-0">Slug: <?= e($c['slug']) ?></p>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
</div>

<div class="d-flex justify-content-between align-items-center mb-3">
  <h2 class="h4 mb-0">Sản phẩm nổi bật</h2>
  <a href="/san-pham" class="btn btn-sm btn-outline-dark">Xem tất cả →</a>
</div>
<div class="row g-4">
  <?php foreach ($products as $p): ?>
    <div class="col-12 col-sm-6 col-lg-4">
      <div class="card h-100 shadow-sm">
        <img src="<?= e($p['image']) ?>" class="card-img-top" alt="<?= e($p['name']) ?>">
        <div class="card-body d-flex flex-column">
          <div class="small text-muted mb-1"><?= e($p['brand_name']) ?> • <?= e($p['category_name']) ?></div>
          <h5 class="card-title"><?= e($p['name']) ?></h5>
          <p class="card-text small text-secondary flex-grow-1"><?= e($p['short_desc']) ?></p>
          <div class="mt-2">
            <span class="fs-5 fw-bold text-danger"><?= money($p['sale_price'] ?? $p['price']) ?></span>
            <?php if (!empty($p['sale_price']) && $p['sale_price'] < $p['price']): ?>
              <del class="small text-muted ms-2"><?= money($p['price']) ?></del>
            <?php endif; ?>
          </div>
        </div>
        <div class="card-footer bg-white border-0 pt-0 pb-3">
          <a href="/san-pham/<?= e($p['slug']) ?>" class="btn btn-outline-primary w-100">Xem chi tiết</a>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
</div>


