<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($title ?? '') ?> | TechStore</title>
    <?php $metaDesc = $product['short_desc'] ?? 'TechStore - Hệ thống bán lẻ điện thoại, laptop, tai nghe, đồng hồ thông minh chính hãng giá tốt' ?>
    <meta name="description" content="<?= e($metaDesc) ?>">
    <meta property="og:title" content="<?= e($title ?? 'TechStore') ?> | TechStore">
    <meta property="og:description" content="<?= e($metaDesc) ?>">
    <meta property="og:type" content="website">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="/assets/css/style.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light ts-navbar sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="/"><i class="bi bi-cpu-fill text-dark me-1">
                
            </i>TechStore</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="/">Trang chủ</a></li>
                    <li class="nav-item"><a class="nav-link" href="/san-pham">Sản phẩm</a></li>
                    <li class="nav-item"><a href="/so-sanh" class="nav-link">So sánh</a></li>
                </ul>

                <form action="/san-pham" method="GET" class="me-lg-3 my-2 my-lg-0" style="min-width: 240px">
                    <div class="input-group input-group-sm">
                        <input type="search" name="q" placeholder="Tìm sản phẩm..." class="form-control rounded-start-pill border-end-0 ps-3 bg-light">
                        <button class="btn btn-light border border-start-0 rounded-end-pill px-3" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </form>

                <ul class="navbar-nav align-items-lg-center gap-2">
                    <li class="nav-item">
                        <a class="btn btn-outline-dark btn-sm" href="/gio-hang">
                            <i class="bi bi-bag me-1">
                                
                            </i>
                            (<?= array_sum($_SESSION['cart'] ?? []) ?>)
                        </a>
                    </li>
                    <?php if ($u = current_user()): ?>
                                               <li class="nav-item dropdown">
                            <button class="btn btn-dark btn-sm dropdown-toggle rounded-pill px-3" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle me-1"></i><?= e($u['name']) ?>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2 small">
                                <?php if ($u['role'] === 'admin'): ?>
                                    <li><a class="dropdown-item text-danger fw-semibold" href="/admin"><i class="bi bi-sliders me-2"></i>Quản trị (Admin)</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                <?php endif; ?>
                                <li><a class="dropdown-item" href="/tai-khoan/don-hang"><i class="bi bi-box-seam me-2"></i>Đơn mua của tôi</a></li>
                                <li><a class="dropdown-item" href="/yeu-thich"><i class="bi bi-heart me-2"></i>Sản phẩm yêu thích</a></li>
                                <li><a class="dropdown-item" href="/tai-khoan/dia-chi"><i class="bi bi-geo-alt me-2"></i>Sổ địa chỉ</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="/dang-xuat">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="dropdown-item text-muted"><i class="bi bi-box-arrow-right me-2"></i>Đăng xuất</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a href="/dang-nhap" class="btn btn-outline-dark btn-sm rounded-pill px-3">
                                Đăng nhập
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/dang-ky" class="btn btn-dark btn-sm rounded-pill px-3">
                                Đăng ký
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container py-4 flex-grow-1">
        <?= $content ?>
    </main>

    <footer class="bg-light py-3 mt-auto text-center text-muted border-top">
        © <?= date('Y') ?> TechStore - Hệ thống bán lẻ đồ công nghệ
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>