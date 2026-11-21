<!-- Banner chính -->
<div class="p-4 p-md-5 mb-5 hero-showroom text-white">
  <div class="row align-items-center g-4">
    <div class="col-lg-7">
      <h1 class="display-5 fw-bold mb-3">
        Nova X Pro<br>Khung Titan, màn hình 120Hz
      </h1>
      <p class="lead text-white-50 mb-4">
        Cụm 3 camera 50MP chống rung OIS, vi xử lý Nova N3 4nm và sạc siêu nhanh 67W.
      </p>
      <div class="d-flex flex-wrap gap-2">
        <a href="/san-pham/dien-thoai-nova-x-pro" class="btn btn-light text-dark text-center px-4 py-2">
          Khám phá ngay
          <i class="bi bi-arrow-right ms-1 "></i>
        </a>
        
        <a href="/so-sanh" class="btn btn-outline-light px-4 py-2">
          So sánh cấu hình
        </a>
      </div>
    </div>
    <div class="col-lg-5 text-center">
      <img src="/uploads/products/nova-x-pro-blk.jpg" alt="Nova X Pro" class="img-fluid rounded-4 shadow" style="max-height: 320px;">
    </div>
  </div>
</div>

<!-- lọc danh mục và thương hiệu -->
<div class="d-flex flex-wrap align-items-center gap-2 mb-5">
  <a href="/san-pham" class="ts-pill bg-dark text-white border-dark">
    Tất cả
  </a>
  <?php foreach ($categories as $c): ?>
    <a href="/san-pham?category=<?= e($c['slug']) ?>" class="ts-pill"><?= e($c['name']) ?></a>
  <?php endforeach; ?>
  <span class="mx-2 text-muted">|</span>
  <?php foreach ($brands as $b): ?>
    <a href="/san-pham?brand=<?= e($b['slug']) ?>" class="ts-pill">
      <i class="bi bi-award me-1"></i><?= e($b['name']) ?>
    </a>  
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


