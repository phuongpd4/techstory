<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($title ?? '') ?> | TechStore</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/css/style.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="/">⚡ TechStore</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="/">Trang chủ</a></li>
                    <li class="nav-item"><a class="nav-link" href="/san-pham">Sản phẩm</a></li>
                </ul>

                <form class="d-flex me-3" action="/san-pham" method="GET">
                    <input class="form-control form-control-sm me-2" type="search" name="q" placeholder="Tìm điện thoại, laptop...">
                    <button class="btn btn-outline-light btn-sm" type="submit">Tìm</button>
                </form>

                <ul class="navbar-nav align-items-lg-center gap-2">
                    <li class="nav-item">
                        <a class="btn btn-outline-warning btn-sm" href="/gio-hang">
                            🛒 Giỏ hàng (<?= array_sum($_SESSION['cart'] ?? []) ?>)
                        </a>
                    </li>
                    <?php if ($u = current_user()): ?>
                        <?php if ($u['role'] === 'admin'): ?>
                            <li class="nav-item">
                                <a class="btn btn-danger btn-sm" href="/admin">⚙️ Admin</a>
                            </li>
                        <?php endif; ?>
                        <li class="nav-item">
                            <a href="/tai-khoan/don-hang" class="btn btn-outline-light btn-sm">Đơn mua</a>
                        </li>
                        <li class="nav-item text-light small ms-lg-2">
                            Chào, <strong><?= e($u['name']) ?></strong>
                        </li>  
                        <li class="nav-item">
                            <form method="POST" action="/dang-xuat" class="d-inline">
                                <?= csrf_field() ?>
                                <button type="submit" class="btn btn-outline-secondary btn-sm">Đăng xuất</button>
                            </form>
                        </li>
                    <?php else: ?>
                        <li class="nav-item"><a class="nav-link" href="/dang-nhap">Đăng nhập</a></li>
                        <li class="nav-item"><a class="btn btn-primary btn-sm" href="/dang-ky">Đăng ký</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container py-4">
        <?= $content ?>
    </main>

    <footer class="bg-light py-3 mt-auto text-center text-muted border-top">
        © <?= date('Y') ?> TechStore - Hệ thống bán lẻ đồ công nghệ
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>