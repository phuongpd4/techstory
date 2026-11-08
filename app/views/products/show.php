<?php
$defaultVariant = $variants[0] ?? null;
$sellingPoints  = !empty($product['selling_points']) ? explode('|', $product['selling_points']) : [];
?>

<!-- Đường dẫn Breadcrumb -->
<nav aria-label="breadcrumb" class="mb-3">
  <ol class="breadcrumb small">
    <li class="breadcrumb-item"><a href="/">Trang chủ</a></li>
    <li class="breadcrumb-item"><a href="/san-pham?category=<?= e($product['category_slug']) ?>"><?= e($product['category_name']) ?></a></li>
    <li class="breadcrumb-item active"><?= e($product['name']) ?></li>
  </ol>
</nav>

<div class="row g-4 mb-5">
  <!-- Cột trái: Ảnh sản phẩm -->
  <div class="col-12 col-md-5">
    <div class="card border-0 shadow-sm">
      <img id="mainProductImage"
           src="<?= e($defaultVariant['image'] ?? '') ?>"
           class="card-img-top rounded"
           alt="<?= e($product['name']) ?>">
    </div>
  </div>

  <!-- Cột phải: Thông tin & Chọn biến thể -->
  <div class="col-12 col-md-7">
    <div class="small text-muted mb-1">
      Thương hiệu: <strong><?= e($product['brand_name']) ?></strong> •
      Mã model: <span><?= e($product['model_code']) ?></span> •
      SKU: <strong id="variantSku"><?= e($defaultVariant['sku'] ?? '') ?></strong>
    </div>

    <h1 class="h3 fw-bold mb-2"><?= e($product['name']) ?></h1>
    <p class="text-secondary"><?= e($product['short_desc']) ?></p>

    <!-- Giá bán (Đổi động theo biến thể) -->
    <div class="bg-light p-3 rounded mb-3">
      <span id="variantSalePrice" class="fs-3 fw-bold text-danger">
        <?= money($defaultVariant['sale_price'] ?? $defaultVariant['price'] ?? 0) ?>
      </span>
      <del id="variantOldPrice" class="text-muted ms-2 <?= (!empty($defaultVariant['sale_price']) && $defaultVariant['sale_price'] < $defaultVariant['price']) ? '' : 'd-none' ?>">
        <?= money($defaultVariant['price'] ?? 0) ?>
      </del>
      <div class="small mt-1">
        Tình trạng:
        <span id="variantStock" class="fw-semibold text-success">
          Còn <?= (int)($defaultVariant['stock'] ?? 0) ?> sản phẩm
        </span>
        • Bảo hành: <strong><?= (int)$product['warranty_months'] ?> tháng</strong>
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
                  data-variant='<?= e(json_encode($v, JSON_UNESCAPED_UNICODE)) ?>'>
            <span style="width:14px;height:14px;border-radius:50%;background:<?= e($v['color_hex']) ?>;border:1px solid #ccc;display:inline-block;"></span>
            <?= e($label) ?>
          </button>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- Form Thêm vào giỏ hàng (sẽ xử lý ở Cột mốc 5) -->
    <form method="POST" action="/gio-hang/them" class="d-flex gap-2 align-items-center mt-4">
      <?= csrf_field() ?>
      <input type="hidden" name="variant_id" id="selectedVariantId" value="<?= (int)($defaultVariant['id'] ?? 0) ?>">
      <input type="number" name="quantity" value="1" min="1" max="10" class="form-control" style="width: 90px;">
      <button type="submit" id="addToCartBtn" class="btn btn-primary px-4">
        🛒 Thêm vào giỏ hàng
      </button>
    </form>

    <?php if (!empty($product['in_the_box'])): ?>
      <div class="small text-muted mt-3">
        📦 <strong>Trong hộp có:</strong> <?= e($product['in_the_box']) ?>
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