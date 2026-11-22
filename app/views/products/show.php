<?php
$defaultVariant = $variants[0] ?? null;
$sellingPoints  = !empty($product['selling_points']) ? explode('|', $product['selling_points']) : [];
?>

<!-- Đường dẫn Breadcrumb -->
<nav aria-label="breadcrumb" class="mb-4 breadcrumb-ts"> 
  <ol class="breadcrumb mb-0">
    <li class="breadcrumb-item">
      <a href="/">
        <i class="bi bi-house-door me-1"></i>
        Trang chủ
      </a>
    </li>
    <li class="breadcrumb-item">
      <a href="/san-pham?category=<?= e($product['category_slug']) ?>">
        <?= e($product['category_name']) ?>
      </a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">
      <?= e($product['name']) ?>
    </li>
  </ol>
</nav>

<div class="row g-4 mb-5">
  <!-- Cột trái: Ảnh sản phẩm -->
  <div class="col-12 col-md-5">
    <div class="card bg-white p-3">
      <img src="<?= e($defaultVariant['image'] ?? '') ?>" alt="<?= e($product['name']) ?>" id="mainProductImage" class="w-100 rounded" style="aspect-ratio:1/1;object-fit:contain;">
    </div>
    <?php if (!empty($media)): ?>
      <div class="d-flex flex-wrap gap-2 mt-3">
        <?php foreach ($media as $m): if ($m['type'] !== 'image') continue; ?>
        <button type="button" class="ts-thumb"
        onclick="const b = document.querySelector('.variant-btn[data-variant_id=\'<?= (int)($m['variant_id'] ?? 0) ?>\']');
         if(b) b.click(); else document.getElementById('mainProductImage').src='<?= e($m['file_path']) ?>';">
         <img src="<?= e($m['file_path']) ?>" alt="<?= e($m['alt_text']) ?>" class="w-100 h-100 rounded" style="object-fit:cover;">
        </button>
        <?php endforeach; ?>
      </div>
      <?php foreach ($media as $m): if($m['type'] !== 'video') continue; ?>
      <video src="<?= e($m['file_path']) ?>" controls preload="metadata" class="w-100 rounded-4 border mt-3">
      </video>
      <?php endforeach; ?>
    <?php endif; ?>     
  </div>

  <!-- Cột phải: Thông tin & Chọn biến thể -->
  <div class="col-12 col-md-7">
    <?php $stock = (int)($defaultVariant['stock'] ?? 0); ?>
    <h1 class="h3 fw-bold mb-1">
      <?= e($product['name']) ?>
    </h1>
    <div class="small text-muted mb-3">
      <?= e($product['brand_name']) ?>• Model: <?= e($product['model_code']) ?>• SKU: <strong id="variantSku">
        <?= e($defaultVariant['sku'] ?? '') ?>
      </strong> 
    </div>
    <p class="text-secondary mb-3">
      <?= e($product['short_desc']) ?>
    </p>
    <div class="ts-price-box mb-3">
      <span class="fs-3 fw-bold" id="variantSalePrice" style="color: var(--ts-price);">
        <?= money($defaultVariant['sale_price'] ?? $defaultVariant['price'] ?? 0) ?>
      </span>
      <del id="variantOldPrice" class="text-muted ms-2 <?= (!empty($defaultVariant['sale_price']) && $defaultVariant['sale_price']< $defaultVariant['price'] ? '' : 'd-none') ?>">
        
      <?= money($defaultVariant['price']) ?? 0 ?>
      </del>
      <div class="small mt-2 pt-2 border-top d-flex flex-wrap gap-3">
        <span>
          <i class="bi bi-check-circle me-1"></i>
          <strong id="variantStock" class="<?= $stock > 0 ? 'text-success' : 'text-danger' ?>">
            <?= $stock > 0 ? " Còn {$stock} sản phẩm" : 'Hết hàng' ?>
          </strong>
        </span>
        <span>
          <i class="bi bi-shield-check me-1"></i>
          Bảo hành <strong><?= (int)$product['warranty_months'] ?> Tháng</strong>
        </span>
        <span>
          <i class="bi bi-qr-code-scan me-1"></i>
          Hỗ trợ COD và VietQE
        </span>
      </div>
    </div>

    

    <!-- Điểm nổi bật (Selling points) -->
    <?php if ($sellingPoints): ?>
      <ul class="small text-secondary mb-3">
        <?php foreach ($sellingPoints as $sp): ?>
          <li><?= e($sp) ?></li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>

    <!-- Chọn biến thể Màu sắc / Dung lượng -->
    <div class="mb-3">
      <label class="form-label fw-semibold small">Chọn phiên bản (Màu sắc / Dung lượng):</label>
      <div class="d-flex flex-wrap gap-2">
        <?php foreach ($variants as $idx => $v): ?>
          <?php
            $label = $v['color'];
            if (!empty($v['ram']) || !empty($v['storage'])) {
                $label .= ' (' . trim(($v['ram'] ?? '') . ' ' . ($v['storage'] ?? '')) . ')';
            }
          ?>
          <button type="button"
                  class="btn btn-outline-dark btn-sm d-flex align-items-center gap-2 variant-btn <?= $idx === 0 ? 'active' : '' ?>"
                  data-variant_id="<?= (int)$v['id'] ?>"
                  data-variant='<?= e(json_encode($v, JSON_UNESCAPED_UNICODE)) ?>'>
            <span style="width:14px;height:14px;border-radius:50%;background:<?= e($v['color_hex']) ?>;border:1px solid #ccc;display:inline-block;"></span>
            <?= e($label) ?>
          </button>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- Thêm vào giỏ hàng  -->
     <div class="d-flex flex-wrap align-items-center gap-2 mt-4">
      <form action="/gio-hang/them" method="POST" class="d-flex gap-2 align-items-center">
        <?= csrf_field() ?>
        <input type="hidden" name="variant_id" id='selectedVariantId' value="<?= (int)($defaultVariant['id'] ?? 0) ?>">
        <input type="number" name="quantity" value="1" min="1" max="<?= max(1,$stock) ?>" aria-label="Số lượng" class="form-control" style="width: 80px;">
        <button type="submit" id="addToCartBtn" class="btn btn-dark px-4" <?= $stock <=0 ? 'disabled' : '' ?>>
          <i class="bi bi-bag-plus me-1"></i>Thêm vào giỏ hàng
        </button>
      </form>
      <?php if (current_user()): ?>
        <form method="POST" action="/yeu-thich/toggle">
          <?= csrf_field(); ?>
          <input type="hidden" name="product_id" value="<?= (int)$product['id'] ?>">
          <button type="submit" class="btn my-2 <?= !empty($inWishlist) ? 'btn-danger' : 'btn-outline-dark' ?>" title="Yêu thích">
            <i class="bi <?= !empty($inWishlist) ? 'bi-heart-fill' : 'bi-heart' ?>"></i>
          </button>
        </form>
      <?php endif; ?>
      <a href="/so-sanh?ids[]=<?= (int)$product['id'] ?>" class="btn btn-outline-dark" title="So sánh cấu hình">
        <i class="bi bi-arrow-left-right me-1"></i>So sánh
      </a>    
     </div>     
    <?php if (!empty($product['in_the_box'])): ?>
      <div class="small text-muted mt-3">
        <i class="bi bi-box-seam me-1"></i>
        <strong>Trong hộp có:</strong><?= e($product['in_the_box']) ?>
      </div>
    <?php endif; ?>  
  </div>
</div>

<!-- Mô tả & Thông số kỹ thuật -->
<div class="row g-4">
  <div class="col-12 col-lg-7">
    <div class="card border-0 shadow-sm">
      <div class="card-body">
        <h2 class="h5 mb-3">Mô tả sản phẩm</h2>
        <p><?= nl2br(e($product['description'])) ?></p>
        <?php if (!empty($product['design_desc'])): ?>
          <p class="small text-muted mb-0"><strong>Thiết kế chuẩn:</strong> <?= e($product['design_desc']) ?></p>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <div class="col-12 col-lg-5">
    <div class="card border-0 shadow-sm">
      <div class="card-body">
        <h2 class="h5 mb-3">Thông số kỹ thuật</h2>
        <div class="table-responsive">
          <table class="table table-sm table-striped mb-0 small">
          <tbody>
            <?php foreach ($specs as $s): ?>
              <tr>
                <th class="text-muted" style="width: 40%;"><?= e($s['spec_key']) ?></th>
                <td><?= e($s['spec_value']) ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Đánh giá sản phẩm -->
 <div class="card border-0 shadow-sm mt-4">
  <div class="card-body">
    <h2 class="h5 mb-3">
      Đánh giá sản phẩm (<?= count($reviews) ?>)
    </h2>
    <?php if(current_user()): ?>
      <form method="POST" action="/san-pham/<?= e($product['slug']) ?>/danh-gia" class="mb-4 pb-3 border-bottom">
        <?= csrf_field() ?>
        <div class="row g-2">
          <div class="col-md-3">
            <select name="rating" id="" class="form-select form-select-sm">
              <option value="5">⭐⭐⭐⭐⭐(5 sao - Tuyệt vời)</option>
              <option value="4">⭐⭐⭐⭐ (4 sao - Tốt)</option>
              <option value="3">⭐⭐⭐ (3 sao - Bình thường)</option>
              <option value="2">⭐⭐ (2 sao - Tệ)</option>
              <option value="1">⭐ (1 sao - Rất tệ)</option>
            </select>
          </div>
          <div class="col-md-7">
            <input type="text" name="content" class="form-control form-control-sm" placeholder="Chia sẻ cảm nhận của bạn về sản phẩm" required>
          </div>
          <div class="col-md-2 d-grid">
            <button class="btn btn-dark btn-sm" type="submit">
              Gửi đánh giá
            </button>
          </div>
        </div>
      </form>
      <?php else: ?>
        <p class="small text-muted border-bottom pb-3">
          Vui lòng <a href="/dang-nhap">đăng nhập</a> để gửi đánh giá
        </p>
        <?php endif; ?>
        <?php if(empty($reviews)): ?>
          <p class="text-muted small mb-0">
            Chưa có đánh giá nào cho sản phẩm này
          </p>
          <?php else: ?>
            <?php foreach ($reviews as $r): ?>
              <div class="mb-3 pb-2 border-bottom">
                <div class="d-flex justify-content-between flex-wrap gap-1">
                  <strong>
                    <?= e($r['user_name']) ?>
                    <span class="ms-2">
                      <?= str_repeat('<i class="bi bi-star-fill text-warning"></i>',(int)$r['rating']) ?>
                    </span>
                  </strong>
                  <span class="text-muted small">
                    <?= e($r['created_at']) ?>
                  </span>
                </div>
                <p class="mb-0 small mt-1">
                  <?= e($r['content']) ?>
                </p>
              </div>
              <?php endforeach;  ?>
              <?php endif; ?> 
  </div>
 </div>
<!-- JavaScript đổi biến thể động -->
<script>
document.querySelectorAll('.variant-btn').forEach(btn => {
  btn.addEventListener('click', () => {
    document.querySelectorAll('.variant-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');

    const v = JSON.parse(btn.dataset.variant);
    const fmt = n => new Intl.NumberFormat('vi-VN').format(n) + 'đ';

    document.getElementById('mainProductImage').src = v.image;
    document.getElementById('variantSku').textContent = v.sku;
    document.getElementById('selectedVariantId').value = v.id;

    const salePrice = v.sale_price ? Number(v.sale_price) : Number(v.price);
    document.getElementById('variantSalePrice').textContent = fmt(salePrice);

    const oldPriceEl = document.getElementById('variantOldPrice');
    if (v.sale_price && Number(v.sale_price) < Number(v.price)) {
      oldPriceEl.textContent = fmt(v.price);
      oldPriceEl.classList.remove('d-none');
    } else {
      oldPriceEl.classList.add('d-none');
    }

    const stockEl = document.getElementById('variantStock');
    if (Number(v.stock) > 0) {
      stockEl.textContent = 'Còn ' + v.stock + ' sản phẩm';
      stockEl.className = 'fw-semibold text-success';
      document.getElementById('addToCartBtn').disabled = false;
    } else {
      stockEl.textContent = 'Hết hàng';
      stockEl.className = 'fw-semibold text-danger';
      document.getElementById('addToCartBtn').disabled = true;
    }
  });
});
</script>
<script type="application/ld+json">
  <?= json_encode([
              '@context' => 'https://schema.org/',
              '@type' => 'Product',
              'name' => $product['name'],
              'description' => $product['short_desc'] ?? '',
              'offers' => [
              '@type' => 'Offer',
              'priceCurrency' => 'VND',
              'price' => (int)($defaultVariant['sale_price'] ?? $defaultVariant['price'] ?? 0), 
              'availability' => ((int)($defaultVariant['stock'] ?? 0) > 0) ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock',
              ],
  ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>

</script>