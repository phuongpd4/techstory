<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h4 mb-4">
        Sản phẩm yêu thích
        <span class="text-muted fw-normal fs-6">
            (<?= count($items) ?>)
        </span>
    </h1>
    <a href="/san-pham" class="btn btn-sm btn-outline-dark rounded-pill px-3">
        Khám phá thêm
    </a>    
</div>
<?php if (empty($items)): ?>
    <div class="card p-5 text-center">
        <i class="bi bi-heart fs-1 text-muted mb-2"></i>
        <h2 class="h6 mb-1">
            Chưa có sản phẩm yêu thích nào
        </h2>
        <p class="small text-muted mb-3">
            Hãy lưu lại những thiết bị bạn quan tâm để tiện theo dõi và so sánh
        </p>
        <div>
            <a href="/san-pham" class="btn btn-dark btn-sm rounded-pill px-4">
                Xem sản phẩm ngay
            </a>
        </div>
    </div>
        
        <?php else: ?>
            <div class="row g-4">
                <?php foreach ($items as $ite): ?>
                    <div class="col-6 col-md-3">
                        <div class="product-card h-100 d-flex flex-column">
                            <a href="/san-pham/<?= e($ite['slug']) ?>" class="product-media">
                                <img src="<?= e($ite['image']) ?>" alt="<?= e($ite['name']) ?>">
                            </a>
                        
                        <div class="p-3 d-flex flex-column flex-grow-1">
                            <div class="small text-muted mb-1">
                                <?= e($ite['brand_name']) ?>
                            </div>
                            <a href="/san-pham/<?= e($ite['slug']) ?>" class="text-decoration-none text-dark">
                             <h2 class="h6 mb-2"><?= e($ite['name']) ?></h2>   
                            </a>
                            <div class="text-danger fw-bold mt-auto mb-3">
                                <?= money((int)$ite['min_price']) ?>
                            </div>
                            <div class="d-flex gap-2">
                                <a href="/san-pham/<?= e($ite['slug']) ?>" class="btn btn-sm btn-dark flex-grow-1">
                                    Xem chi tiết
                                </a>
                                <form action="/yeu-thich/toggle" method="POST">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="product_id" value="<?= (int)$ite['id']  ?>">
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Bỏ yêu thích">
                                        <i class="bi bi-heartbreak"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                        </div>
                    </div>
                <?php endforeach; ?>        
            </div>
        <?php endif; ?>    