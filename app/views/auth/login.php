<div class="auth-shell">
  <div class="row g-0">
<!-- Cột trái: bảng thương hiệu ẩn trên mobile -->
  <div class="col-lg-5 d-none d-lg-flex auth-brand-panel">
    <div>
      <div class="fw-bold fs-5 mb-4">
        <i class="bi bi-cpu-fill me-2"></i>PhuongStore
      </div>
      <h2 class="h3 fw-bold mb-3" style="line-height: 1.3;">
        Chào mừng trở lại cửa hàng công nghệ
      </h2>
      <p class="small mb-4" style="color: #a1a1aa;">
        Theo dõi đơn hàng, quản lý danh sách yêu thích và thanh toán nhanh gọn chỉ trong vài giây
      </p>
      <div class="d-grid gap-3">
        <div class="auth-perk">
          <span class="auth-perk-icon">
            <i class="bi bi-shield-check"></i>
          </span>
          <div>
            <div class="fw-semibold small">
              Sản phẩm chính hãng 100%
            </div>
            <div style="font-size: 0.78rem; color: #a1a1aa">
              Bảo hành minh bạch, hỗ trợ đổi trả rõ ràng
            </div>
          </div>
        </div>
        <div class="auth-perk">
              <span class="auth-perk-icon">
                <i class="bi bi-box-seam"></i>
              </span>
              <div>
                <div class="fw-semibold small">
                  Quản lý đơn hàng tập trung
                </div>
                <div style="font-size: 0.78rem; color: #a1a1aa">
                  Tra cứu trạng thái giao hàng mọi lúc mọi nơi
                </div>
              </div>
        </div>
        <div class="auth-perk">
          <span class="auth-perk-icon">
            <i class="bi bi-qr-code-scan"></i>
          </span>
          <div>
            <div class="fw-semibold small">
              Thanh toán linh hoạt
            </div>
            <div style="font-size: 0.78rem; color: #a1a1aa">
              Hỗ trợ COD tận nơi và chuyển khoản ngân hàng
            </div>
          </div>
        </div>
      </div>
      <div class="small pt-4 mt-4" style="color: #71717a;border-top: 1px solid rgba(255,255,255,0.08);">
          © <?= date('Y') ?> PhuongStore 
      </div>
    </div>
  </div>
  <!-- Cột phải: Form đăng nhập -->
   <div class="col-12 col-lg-7 auth-form-panel">
    <div class="auth-switcher">
      <a href="/dang-nhap" class="active">Đăng nhập</a>
      <a href="/dang-ky">Đăng ký</a>
    </div>
    <h1 class="h4 fw-bold mb-1" style="text-align: center;">
      Đăng nhập tài khoản
    </h1>
    <p class="text-muted small mb-4">
      Nhập email và mật khẩu để tiếp tục mua sắm
    </p>
    <?php if(!empty($error)): ?>
      <div class="alert alert-danger d-flex align-items-center gap-2 small rounded-3 py-2 px-3">
        <i class="bi bi-exclamation-circle-fill flex-shrink-0"></i>
        <div><?= e($error) ?></div>
      </div>
      <?php endif; ?>
      <form method="POST" action="/dang-nhap">
          <?= csrf_field() ?>
          <div class="mb-3">
            <label for="loginEmail" class="form-label small fw-semibold">
              Email
            </label>
            <input type="email" id="loginEmail" name="email" class="form-control auth-input" value="<?= e($email ?? '') ?>"
            autocomplete="email" required placeholder="ban@email.com">
          </div>
          <div class="mb-4">
            <label for="loginPassword" class="form-label small fw-semibold">
              Mật khẩu
            </label>
            <div class="auth-pass-wrap">
              <input type="password" id="loginPassword" name="password" class="form-control auth-input"
              autocomplete="current-password" required placeholder="Nhập mật khẩu của bạn">
              <button type="button" class="auth-pass-toggle" data-toggle-password="loginPassword" aria-label="Hiện hoặc ẩn mật khẩu">
                <i class="bi bi-eye"></i>
              </button>
            </div>
          </div>
          <button type="submit" class="btn btn-primary w-100" style="height: 46px;">
            Đăng nhập <i class="bi bi-arrow-right ms-1"></i>
          </button>
      </form>
      <div class="text-center small text-muted mt-4">
        Chưa có tài khoản? <a href="/dang-ky" class="fw-semibold text-dark text-decoration-none">
          Tạo tài khoản mới</a>
      </div>
   </div>
  </div>
</div>
<script>
  document.querySelectorAll('[data-toggle-password]').forEach(btn=>{
    btn.addEventListener('click',() =>{
      const input = document.getElementById(btn.dataset.togglePassword);
      const icon = btn.querySelector('i');
      const isHidden = input.type === 'password';
      input.type = isHidden ? 'text' : 'password';
      icon.className = isHidden ? 'bi bi-eye-slash' : 'bi bi-eye';
    });
  });
</script>