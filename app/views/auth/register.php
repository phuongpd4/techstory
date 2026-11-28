<div class="auth-shell">
  <div class="row g-0">
<!-- cột trái: bảng thương hiệu ẩn trên mobile -->
  <div class="col-lg-5 d-none d-lg-flex auth-brand-panel">
    <div>
      <div class="fw-bold fs-5 mb-4">
        <i class="bi bi-cpu-fill me-2"></i>PhuongStore
      </div>
      <h2 class="h3 fw-bold mb-3" style="line-height: 1.3;">
        Tạo tài khoản PhuongStore trong 30 giây
      </h2>
      <p class="small mb-4" style="color: #a1a1aa">
        Mở khóa trải nghiệm mua sắm nhanh chóng và nhận ưu đãi dành riêng cho thành viên 
      </p>
      <div class="d-grid gap-3">
        <div class="auth-perk">
          <span class="auth-perk-icon">
            <i class="bi bi-ticket-perforated"></i>
          </span>
          <div>
            <div class="fw-semibold small">
              Mã giảm giá thành viên
            </div>
            <div style="font-size: 0.78rem; color: #a1a1aa;">
              Áp dụng voucher trực tiếp ngay tại trang giỏ hàng
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="small pt-4 mt-4" style="color: #71717a; border-top: 1px solid rgba(255,255,255,0.08);">
      © <?= date('Y') ?> TechStore
    </div>
  </div>

<!-- Cột phải: form đăng ký -->
 <div class="col-12 col-lg-7 auth-form-panel">
  <div class="auth-switcher">
    <a href="/dang-nhap">Đăng nhập</a>
    <a href="/dang-ky" class="active">Đăng ký</a>
  </div>
  <h1 class="h4 fw-bold mb-1" style="text-align:center;">Đăng ký thành viên</h1>
  <p class="text-muted small mb-4">Điền thông tin bên dưới để tạo tài khoản mới</p>
  <?php if(!empty($error)): ?>
    <div class="alert alert-danger d-flex align-items-center gap-2 small rounded-3 py-2 px-3">
      <i class="bi bi-exclamation-circle-fill flex-shrink-0"></i>
      <div>
        <?= e($error) ?>
      </div>
    </div>
    <?php endif; ?>
    <form method="POST" id="registerForm" action="/dang-ky">
      <?= csrf_field() ?>
      <div class="row g-3 mb-3">
        <div class="col-12 col-sm-6">
          <label for="regName" class="form-label small fw-semibold">
            Họ và tên *
          </label>
          <input type="text" id="regName" name="name" class="form-control auth-input" value="<?= e($old['name'] ?? '') ?>"
          autocomplete="name" required placeholder="Lê Văn A">
        </div> 
        <div class="col-12 col-sm-6">
          <label for="regPhone" class="form-label small fw-semibold">
            Số điện thoại
          </label>
          <input type="tel" id="regPhone" name="phone" class="form-control auth-input" value="<?= e($old['phone'] ?? '') ?>"
          autocomplete="tel" placeholder="09xxxxxxx" required>
        </div>
      </div>
      <div class="mb-3">
        <label for="regEmail" class="form-label small fw-semibold">
          Email *
        </label>
        <input type="email" id="regEmail" name="email" class="form-control auth-input"
        value="<?= e($old['email'] ?? '') ?>" autocomplete="email" required placeholder="ban@gmail.com">
      </div>
      <div class="mb-3">
        <label for="regPassword" class="form-label small fw-semibold">Mật khẩu *</label>
        <div class="auth-pass-wrap">
          <input type="password" id="regPassword" name="password" class="form-control auth-input"
          minlength="6" autocomplete="new-password" required placeholder="Tối thiểu 6 ký tự">
          <button type="button" class="auth-pass-toggle" data-toggle-password="regPassword"
          aria-label="Hiện hoặc ẩn mật khẩu">
            <i class="bi bi-eye"></i>
        </button>
        </div>
        <div class="pw-meter" id="pwMeter" data-level="0">
          <span></span><span></span><span></span>
        </div>
        <div class="small text-muted mt-1" id="pwText">
          Tối thiểu 6 ký tự gồm có chữ hoa, số và ký tự đặc biệt để tăng bảo mật
        </div>
      </div>
      <div class="mb-4">
        <label for="regPasswordConfirm" class="form-label small fw-semibold">
          Nhập lại mật khẩu *
        </label>
        <div class="auth-pass-wrap">
          <input type="password" id="regPasswordConfirm" name="password_confirm" class="form-control auth-input"
          minlength="6" autocomplete="new-password" required placeholder="Nhập lại mật khẩu giống ở trên">
          <button type="button" class="auth-pass-toggle" data-toggle-password="regPasswordConfirm"
          aria-label="Hiện hoặc ẩn mật khẩu nhập lại">
          <i class="bi bi-eye"></i>
          </button>
        </div>
        <div id="pwMatchText" class="small mt-1"></div>
      </div>
      <button type="submit" class="btn btn-primary w-100" style="height: 46px;">  
        Tạo tài khoản <i class="bi bi-arrow-right ms-1"></i>
      </button>
    </form>
    <div class="text-center small text-muted mt-4">
      Đã có tài khoản? <a href="/dang-nhap" class="fw-semibold text-dark text-decoration-none">
        Đăng nhập ngay
      </a>
    </div>
   </div>
  </div>
</div>

<script>
  document.querySelectorAll('[data-toggle-password]').forEach(btn=>{
        btn.addEventListener('click',() => {
            const input = document.getElementById(btn.dataset.togglePassword);
            const icon = btn.querySelector('i');
            const isHidden = input.type === 'password';
            input.type = isHidden ? 'text' : 'password';
            icon.className = isHidden ? 'bi bi-eye-slash' : 'bi bi-eye';
        });
    });
  // Đo độ mạnh mật khẩu và mật khẩu ngay khi gõ phím
  const pwInput = document.getElementById('regPassword');
  const pwConfirm = document.getElementById('regPasswordConfirm');
  const pwMeter = document.getElementById('pwMeter');
  const pwText = document.getElementById('pwText');
  const pwMatchText = document.getElementById('pwMatchText');

  function checkStrength(){
    const v = pwInput.value;
    if(!v){
      pwMeter.dataset.level = '0';
      pwText.className = 'small text-muted mt-1';
      pwText.textContent = 'Tối thiểu 6 ký tự (nên kết hợp chữ hoa và số)';
      return;
    }
    if(v.length<6){
      pwMeter.dataset.level = '1';
      pwText.className = 'small text-danger mt-1';
      pwText.textContent = 'Mật khẩu quá ngắn, cần ít nhất 6 ký tự';
      return;
    }
    let score = 1;
    if(v.length >= 8 && (/[A-Z]/.test(v) || /[0-9]/.test(v)))
      score = 2;
    if (v.length >= 10 && /[A-Z]/.test(v) && /[0-9]/.test(v))
      score = 3;
    pwMeter.dataset.level = String(score);
    const labels = {
      1: ['Mật khẩu cơ bản', 'text-danger'],
      2: ['Mật khẩu trung bình', 'text-warning'],
      3: ['Mật khẩu mạnh', 'text-success']
    };
    pwText.className = 'small mt-1 ' + labels[score][1];
    pwText.textContent = labels[score][0];
  }
  function checkMatch(){
    if(!pwConfirm.value){
      pwMatchText.innerHTML = '';
      return true;
    }
    if(pwInput.value === pwConfirm.value){
      pwMatchText.className = 'small text-success mt-1';
      pwMatchText.innerHTML = '<i class = "bi bi-check-circle-fill me-1"></i>Mật khẩu khớp';
      return true;
    }else{
      pwMatchText.className = 'small text-danger mt-1';
      pwMatchText.innerHTML = '<i class="bi bi-x-circle-fill me-1"></i>Mật khẩu nhập lại chưa khớp';
      return false;
    }
  }
  pwInput.addEventListener('input', ()=>{
    checkStrength(); checkMatch();
  });
  pwConfirm.addEventListener('input', checkMatch);
  document.getElementById('registerForm').addEventListener('submit',(e)=>{
    if (pwInput.value !== pwConfirm.value){
      e.preventDefault();
      checkMatch();
      pwConfirm.focus();
    }
  });
</script>