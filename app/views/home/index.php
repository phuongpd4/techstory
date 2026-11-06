<h1 class="mb-4">Danh mục sản phẩm</h1>
<div class="row g-3">
  <?php foreach ($categories as $c): ?>
    <div class="col-6 col-md-4">
      <div class="card h-100">
        <div class="card-body">
          <h5 class="card-title"><?= e($c['name']) ?></h5>
          <p class="text-muted mb-0">Slug: <?= e($c['slug']) ?></p>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
</div>