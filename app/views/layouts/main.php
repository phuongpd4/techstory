<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($title ?? '') ?> | PhuongStore</title>
    <?php $metaDesc = $product['short_desc'] ?? 'TechStore - Hệ thống bán lẻ điện thoại, laptop, tai nghe, đồng hồ thông minh chính hãng giá tốt' ?>
    <meta name="description" content="<?= e($metaDesc) ?>">
    <meta property="og:title" content="<?= e($title ?? 'TechStore') ?> | TechStore">
    <meta property="og:description" content="<?= e($metaDesc) ?>">
    <meta property="og:type" content="website">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="/assets/css/style.css?v=<?= filemtime(ROOT . '/public/assets/css/style.css') ?>" rel="stylesheet">
</head>
<body>
    <?php $cartCount = array_sum($_SESSION['cart'] ?? []); ?>
    <nav class="navbar navbar-expand-lg navbar-light ts-navbar sticky-top">
        <div class="container">
            <a href="/" class="navbar-brand fw-bold">
                <i class="bi bi-cpu-fill text-dark me-1"></i>PhuongStore
            </a>
            <div class="d-flex d-lg-none align-items-center gap-2 ms-auto">
                <button type="button" id="mobileSearchToggle" class="ts-icon-btn" aria-label="Tìm kiếm sản phẩm" aria-expanded="false" aria-controls="mobileSearchBar">
                    <i class="bi bi-search"></i>
                </button>
                <a href="/gio-hang" class="ts-icon-btn position-relative" aria-label="Giỏ hàng">
                    <i class="bi bi-bag"></i>
                    <?php if($cartCount > 0): ?>
                        <span class="ts-cart-dot">
                            <?= $cartCount ?>
                        </span>
                    <?php endif; ?>    
                </a>
                <button class="navbar-toggler ts-icon-btn border-0" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-label="Mở menu">
                    <i class="bi bi-list fs-5"></i>
                </button>
            </div>
            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav me-auto my-2 my-lg-0 ts-nav-list">
                    <li class="nav-item">
                        <a href="/" class="nav-link">Trang chủ</a>
                    </li>
                    <li class="nav-item">
                        <a href="/san-pham" class="nav-link">Sản phẩm</a>
                    </li>
                    <li class="nav-item">
                        <a href="/so-sanh" class="nav-link">So sánh</a>
                    </li>
                    <?php if(!current_user()): ?>
                        <li class="nav-item d-lg-none">
                            <a href="/dang-nhap" class="nav-link">Đăng nhập</a>
                        </li>
                    <?php endif; ?>    
                </ul>
                 <!-- PC -->
                <form action="/san-pham" method="GET" class="d-none d-lg-block me-lg-3" style="min-width:240px">
                    <div class="input-group input-group-sm">
                        <input type="search" name="q" placeholder="Tìm sản phẩm...." class="form-control rounded-start-pill border-end-0 ps-3 bg-light">
                        <button class="btn btn-light border border-start-0 rounded-end-pill px-3" type="submit" aria-label="Tìm">
                            <i class="bi bi-search"></i>
                        </button>
                        
                    </div>
                </form>
            <!-- PC giỏ hàng, tài khoản  -->
             <ul class="navbar-nav align-items-lg-center gap-2">
                <li class="nav-item d-none d-lg-block">
                    <a href="/gio-hang" class="btn btn-outline-dark btn-sm rounded-pill px-3">
                        <i class="bi bi-bag me-1"></i>(<?= $cartCount ?>)
                    </a>
                </li>
                <?php if($u = current_user()): ?>
                    <li class="nav-item dropdown">
                        <button class="btn btn-dark btn-sm dropdown-toggle rounded-pill px-3" data-bs-toggle="dropdown">
                          <i class="bi bi-person-circle me-1"></i><?= e($u['name']) ?>  
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end ts-dropdown-menu shadow-sm mt-2 small">
                            <?php if($u['role'] === 'admin'): ?>
                                <li><a href="/admin" class="dropdown-item fw-semibold">
                                    <i class="bi bi-sliders me-2"></i>Admin 
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                            <?php endif; ?>
                                <li><a href="/tai-khoan/don-hang" class="dropdown-item">
                                    <i class="bi bi-box-seam me-2"></i>Đơn hàng của bạn
                                </a></li>
                                <li><a href="/yeu-thich" class="dropdown-item">
                                    <i class="bi bi-heart me-2"></i>Sản phẩm yêu thích
                                </a></li>
                                <li><a href="/tai-khoan/dia-chi" class="dropdown-item">
                                    <i class="bi bi-geo-alt me-2"></i>Địa chỉ đã lưu
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="/dang-xuat" method="POST">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="dropdown-item">
                                            <i class="bi bi-box-arrow-right me-2"></i>Đăng xuất
                                        </button>
                                    </form>
                                </li>
                        </ul>
                    </li>
                <?php else: ?>
                   <li class="nav-item d-none d-lg-block">
                    <a href="/dang-nhap" class="btn btn-dark btn-sm rounded-pill px-3">
                        Đăng nhập
                    </a>
                   </li>
                <?php endif; ?>        
             </ul>
            </div>
        </div>
 <!-- Mobile: Thanh tìm kiếm ẩn, chỉ bung ra khi bấm vào kính lúp -->    
     <div class="d-lg-none ts-mobile-search" id="mobileSearchBar">
        <div class="container py-2">
            <form action="/san-pham" method="GET" class="d-flex align-items-center gap-2">
                <div class="input-group ">
                    
                    <input type="search" id="mobileSearchInput" name="q" placeholder="Tìm điện thoại, laptop, phụ kiện..." class="form-control bg-light input-ps">
                    <button type="submit" class="btn btn-dark rounded-end-pill px-3 small">
                        Tìm
                    </button>
                </div>
                <button type="button" id="mobileSearchClose" class="ts-icon-btn flex-shrink-0" aria-label=" Đóng tìm kiếm">
                    <i class="bi bi-x-lg"></i>
                </button>
            </form>
        </div>
     </div>
    </nav>

    <main class="container py-4 flex-grow-1">
         <?php if ($flash = get_flash()): ?>
            <?php 
            $flashIcon = match ($flash['type']){
                'success' => 'bi-check-circle-fill',
                'info' => 'bi-info-circle-fill',
                default => 'bi-exclamation-triangle-fill',
            };        
            ?>
        <div class="alert alert-<?= e($flash['type']) ?> alert-dismissible fade show d-flex align-items-center gap-2 rounded-3 shadow-sm border-0 mb-4" role="alert">
            <i class="bi <?= $flashIcon ?>"></i>
            <div><?= e($flash['message']) ?></div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Đóng"></button>
        </div>
        <?php endif;  ?>
        <?= $content ?>                   
    </main>

    <footer class="footer-ts py-5 mt-5">
        <div class="container">
            <div class="row g-4 small">
                <div class="col-md-5">
                    <div class="fw-bold text-dark fs-6 mb-2">
                        <i class="bi bi-cpu-fill me-1"></i>PhuongStore
                    </div>
                    <p class="mb-2">Hệ thống bán lẻ điện thoại, laptop, máy tính bảng và phụ kiện công nghệ chính hãng. Trải nghiệm mua sắm minh bạch, tối giản.</p>
                    <div><i class="bi bi-shield-check me-1"></i>
                    Bảo hành chính hãng <i class="bi bi-qr-code-scan ms-2 me-1"></i>
                    Hỗ trợ COD và VietQR</div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="fw-bold text-dark mb-2">Khám phá</div>
                    <ul class="list-unstyled d-grid gap-1 mb-0">
                        <li><a href="/san-pham">Tất cả sản phẩm</a></li>
                        <li><a href="/san-pham?category=dien-thoai">Điện thoại</a></li>
                        <li><a href="/san-pham?category=laptop">Laptop</a></li>
                        <li><a href="/so-sanh">So sánh cấu hình</a></li>
                    </ul>
                </div>
                <div class="col-6 col-md-4">
                    <div class="fw-bold text-dark mb-2">Tài khoản và hỗ trợ</div>
                    <ul class="list-unstyled d-grid gap-1 mb-0">
                        <li><a href="/gio-hang">Giỏ hàng của bạn</a></li>
                        <li><a href="/tai-khoan/don-hang">Tra cứu đơn hàng</a></li>
                        <li><a href="/yeu-thich">Sản phẩm yêu thích</a></li>
                        <li><a href="/tai-khoan/dia-chi">Sổ địa chỉ nhận hàng</a></li>
                    </ul>

                </div>
            </div>
            <div class="border-top mt-4 pt-3 text-center small">
                @<?= date('Y') ?>  PhuongStore. 
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const searchToggle = document.getElementById('mobileSearchToggle');
        const searchBar = document.getElementById('mobileSearchBar');
        const searchInput = document.getElementById('mobileSearchInput');
        const searchClose = document.getElementById('mobileSearchClose');
        function toggleMobileSearch(forceClose = false){
            if(!searchBar) return;
            const willOpen = forceClose ? false: !searchBar.classList.contains('is-open');
            searchBar.classList.toggle('is-open',willOpen);
            searchToggle?.setAttribute('aria-expanded', String(willOpen));
            if(willOpen){
                const navEl = document.getElementById('mainNav');
                if(navEl?.classList.contains('show')){
                    bootstrap.Collapse.getOrCreateInstance(navEl).hide();
                }
                setTimeout(() => searchInput?.focus(), 120);
            }

        }
        searchToggle?.addEventListener('click', () => toggleMobileSearch());
        searchClose?.addEventListener('click', () => toggleMobileSearch(true));
    </script>
</body>
</html>