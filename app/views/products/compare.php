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
        <div class="table-responsive bg-white shadow-sm rounded">
            <table class="table table-bordered align-middle mb-0">
                <thead class="table-light text-center">
                    <tr>
                        <th style="width: 20%;">Thông số</th>
                        <?php foreach ($items as $item): ?>
                        <th>
                            <img src="<?= e($item['image'] ?? '/assets/images/placeholder.svg') ?>" alt="" style="height: 80px; object-fit:contain;" class="mb-2 d-block mx-auto">
                            <a href="/san-pham/<?= e($item['slug']) ?>" class="text-decoration-none">
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
    <?php endif; ?>    
