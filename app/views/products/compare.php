<h1 class="h4 mb-4"> So sánh cấu hình sản phẩm</h1>
    <form action="/so-sanh" method="GET" class="card border-0 shadow-sm p-3 mb-4">
        <div class="row g-2 align-items-center">
            <?php for($i = 0; $i < 3; $i++): ?>
                <div class="col-md-3">
                    <select name="ids[]" id="" class="form-select form-select-sm">
                        <option value="">
                            -- Chọn sản phẩm <?= $i + 1 ?> --
                        </option>
                        <?php foreach ($allProducts as $p): ?>
                            <option value="<?= (int)$p['id'] ?>" <?= (($selectedIds[$i] ?? 0) == $p['id']) ? 'selected' : '' ?>>
                                <?= e($p['name']) ?>
                            </option>
                        <?php endforeach; ?>    
                    </select>
                </div>
            <?php endfor; ?>
                <div class="col-md-3 d-grid">
                    <button class="btn btn-primary btn-sm">
                        So sánh ngay
                    </button>
                </div>
        </div>
    </form>
    <?php if(count($items) < 2): ?>
        <div class="alert alert-info">
            Vui lòng chọn ít nhất 2 sản phẩm phía trên và bấm <strong>So sánh ngay</strong>
        </div>
    <?php else: ?>
    <!-- Giao diện PC -->
        <div class="table-responsive bg-white shadow-sm rounded d-none d-md-block">
            <table class="table table-bordered align-middle mb-0 compare-table-ts">
                <thead class="table-light text-center">
                    <tr>
                        <th>Thông số</th>
                        <?php foreach ($items as $item): ?>
                        <th>
                            <img src="<?= e($item['image'] ?? '/assets/images/placeholder.svg') ?>" alt="" style="height: 80px; object-fit:contain;" class="mb-2 d-block mx-auto">
                            <a href="/san-pham/<?= e($item['slug']) ?>" class="text-decoration-none text-dark fw-semibold small">
                                <?= e($item['name']) ?>
                            </a>
                            <div class="text-danger fw-bold small mt-1">
                                <?= money((int)($item['sale_price'] ?? $item['price'])) ?>
                            </div>
                        </th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($specKeys as $key): ?>
                        <tr>
                            <th class="bg-light small">
                                <?= e($key) ?>
                            </th>
                            <?php foreach($items as $item): ?>
                            <td class="text-center small">
                                <?= e($item['specs'][$key] ?? '-') ?>
                            </td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>    
                </tbody>
            </table>
        </div>
        <!-- Giao diện so sánh dọc cho mobile -->
         <div class="d-md-none">
            <div class="row g-2 mb-3">
                <?php foreach($items as $item): ?>
                    <div class="col">
                        <div class="card p-2 text-center h-100">
                            <img src="<?= e($item['image']) ?>" alt="Ảnh sản phẩm" style="height:76px; object-fit:contain" class="mx-auto mb-2">
                            <a href="/san-pham/<?= e($item['slug']) ?>" class="text-dark text-decoration-none fw-semibold d-block" style="font-size:0.78rem;">
                                <?= e($item['name']) ?>
                            </a>
                            <div class="text-danger fw-bold mt-auto pt-1" style="font-size:0.8rem;">
                                <?= money((int)($item['sale_price'] ?? $item['price'])) ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="d-grid gap-2">
                <?php foreach($specKeys as $key): ?>
                    <div class="card p-2">
                        <div class="fw-bold small text-dark bg-light rounded px-2 py-1 mb-2 text-center">
                            <?= e($key) ?>
                        </div>
                        <div class="row g-2 text-center" style="font-size: 0.8rem;">
                            <?php foreach($items as $item): ?>
                                <div class="col border-end last-border-0">
                                    <?= e($item['specs'][$key] ?? '-') ?>
                                </div>
                            <?php endforeach; ?>    
                        </div>
                    </div>
                <?php endforeach; ?>                
            </div>
         </div>                       
    <?php endif; ?>    
