<h1 class="h4 mb-4">
    Sản phẩm yêu thích (<?= count($items) ?>)
</h1>

<?php if(empty($items)):  ?>
    <div class="alert alert-info">
        Bạn chưa lưu sản phẩm yêu thích nào
        <a href="/san-pham">Khám phá ngay</a>
    </div>
<?php else: ?>
    <div class="row g-3">
        <?php foreach ($items as $p): ?>
            <div class="col-6 col-md-3">
                <div class="card h-100 border-0 shadow-sm">
                    <img src="<?= e($p['image'] ?? '/assets/images/placeholder.svg') ?>" class="card-img-top p-3" alt="<?= e($p['name']) ?>">                    
                
                <div class="card-body d-flex flex-column">
                    <span class="badge bg-light text-secondary align-self-start mb-1">
                        <?= e($p['brand_name']) ?>
                    </span>
                    <h2 class="h6 card-title">
                        <?= e($p['name']) ?>
                    </h2>
                    <p class="text-danger fw-bold mt-auto mb-2">
                        <?= money((int)$p['min_price']) ?>
                    </p>
                    <div class="d-flex gap-1">
                        <a href="/san-pham/<?= e($p['slug']) ?>" class="btn btn-sm btn-outline-primary flex-grow-1">
                            Xem
                        </a>
                        <form method="POST" action="/yeu-thich/toggle">
                            <?= csrf_field(); ?>
                            <input type="hidden" name="product_id" value="<?= (int)$p['id'] ?>">
                            <button class="btn btn-sm btn-outline-danger" title="Bỏ yêu thích">💔</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
            <?php endforeach; ?>
      </div>
<?php endif; ?>    
      
      