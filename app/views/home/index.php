<!-- Banner chính -->
<?php $catIcons = [
  'dien-thoai' => 'bi-phone',
  'laptop' => 'bi-laptop',
  'may-tinh-bang' => 'bi-tablet',
  'tai-nghe' => 'bi-headphones',
  'dong-ho-thong-minh' => 'bi-smartwatch',
  'ban-phim-chuot' => 'bi-keyboard',
  'phu-kien-sac-cap' => 'bi-lightning-charge'
  ]; ?>
<section class="hero-showroom text-white mb-4 mb-md-5">
  <div class="row align-items-center g-3 g-lg-5">
<!-- Ảnh sản phẩm mobile and PC -->
 <div class="col-12 col-lg-5 order-1 order-lg-2">
  <div class="hero-stage">
    <img src="/uploads/products/nova-x-pro-blk.jpg" alt="Nova X Pro" class="img-fluid">
  </div>
 </div>
<!-- Nội dung nút --> 
 <div class="col-12 col-lg-7 order-2 order-lg-1">
  <div class="hero-eyebrow mb-2 mb-md-3">
    Flagship 2026 · Nova Series
  </div>
  <h1 class="hero-title mb-2 mb-md-3">
     Nova X Pro
  </h1>
  <p class="hero-desc mb-3 mb-md-4">
        Khung Titan, màn hình 120Hz,
        cụm 3 camera 50MP chống rung OIS, vi xử lý Nova N3 4nm và sạc siêu nhanh 67W.
  </p>
  <div class="hero-specs mb-3 mb-md-4">
    <div>
      <div class="">AMOLED 6.7"</div>
      <div class="d-flex gap-1 justify-content-center">
        <i class="bi bi-laptop"></i>
        <div class="">120HZ"</div>
      </div>
    </div>
    <div>
      <div class="">50MP OIS</div>
      <div class="">3 Camera Pro</div>
    </div>
    <div>
      <div class="">67W</div>
      <div class="">Pin 5.000mAh</div>
    </div>
  </div>
  <div class="d-flex flex-column flex-sm-row gap-2">
    <a href="/san-pham/dien-thoai-nova-x-pro" class="btn btn-light text-dark px-4 py-2">
      Khám phá ngay <i class="bi bi-arrow-right ms-1"></i>
    </a>
    <a href="/so-sanh" class="btn btn-outline-light px-4 py-2">
      So sánh cấu hình 
    </a>
  </div>
 </div>
</div>
</section>
<!-- Danh mục phổ biến và thương hiệu -->
 <section class="ts-filter-section mb-4 mb-md-5">
  <div class="ts-scroll-row" aria-label="Danh mục phổ biến">
    <a href="/san-pham" class="ts-pill bg-dark text-white border-dark">
      <i class="bi bi-grid me-1"></i>Tất cả
    </a>
    <?php foreach($categories as $c): ?>
      <a href="/san-pham?category=<?= e($c['slug']) ?>" class="ts-pill">
        <i class="bi <?= $catIcons[$c['slug']] ?? 'bi-tag' ?> me-1"></i><?= e($c['name']) ?>
      </a>
    <?php endforeach; ?>  
  </div>
  <div class="d-flex align-items-center gap-2">
    <span class="small text-muted fw-semibold flex-shrink-0">
      Thương hiệu:
    </span>
    <div class="ts-scroll-row" aria-label="Thương hiệu nổi bật">
      <?php foreach($brands as $b): ?>
        <a href="/san-pham?brand=<?= e($b['slug']) ?>" class="ts-pill ts-pill-brand">
          <i class="bi bi-award me-1"></i><?= e($b['name']) ?>
        </a>
      <?php endforeach; ?>  
    </div>
  </div>
 </section>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h2 class="h4 mb-0">Sản phẩm nổi bật</h2>
  <a href="/san-pham" class="btn btn-sm btn-outline-dark rounded-pill px-3">Xem tất cả
    <i class="bi bi-arrow-right ms-1"></i>
  </a>
</div>
  <div class="row g-4">
    <?php foreach($products as $p): ?>
      <?php 
        $hasSale = !empty($p['sale_price']) && $p['sale_price'] < $p['price']; 
        $percent = $hasSale ? round((1 - $p['sale_price'] / $p['price']) * 100) : 0;
      ?>
      <div class="col-12 col-sm-6 col-lg-4">
        <div class="product-card h-100 d-flex flex-column">
          <a href="/san-pham/<?= e($p['slug']) ?>" class="product-media">
            <?php if ($percent > 0): ?>
              <span class="discount-badge">-<?= $percent ?>%</span>
            <?php endif ?>
            <img src="<?= e($p['image']) ?>" alt="<?= e($p['name']) ?>">  
          </a>
          <div class="p-3 d-flex flex-column flex-grow-1">
              <div class="small text-muted mb-1">
                <?= e($p['brand_name']) ?> • <?= e($p['category_name']) ?>
              </div>
              <a href="/san-pham/<?= e($p['slug']) ?>" class="text-decoration-none text-dark">
                <h3 class="h6 mb-1">
                  <?= e($p['name']) ?>
                </h3>
              </a>
              <p class="small text-secondary line-2 mb-3">
                <?= e($p['short_desc']) ?>
              </p>
              <div class="mt-auto d-flex align-items-baseline justify-content-between">
                <div>
                  <span class="fs-5 fw-bold text-danger">
                    <?= money($p['sale_price'] ?? $p['price'])  ?>
                  </span>
                  <?php if($hasSale): ?>
                    <del class="small text-muted ms-1">
                      <?= money($p['price']) ?>
                    </del>
                  <?php endif; ?>  
                </div>
                <a href="/san-pham/<?= e($p['slug']) ?>" class="btn btn-sm btn-outline-dark rounded-pill px-3">
                  Chi tiết
                </a>
              </div>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
  </div>


