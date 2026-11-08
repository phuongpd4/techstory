<div class="row justify-content-center">
  <div class="col-12 col-md-6">
    <div class="card shadow-sm border-0">
      <div class="card-body p-4">
        <h1 class="h4 fw-bold mb-3 text-center">Đăng ký tài khoản</h1>

        <?php if (!empty($error)): ?>
          <div class="alert alert-danger small"><?= e($error) ?></div>
        <?php endif; ?>

        <form method="POST" action="/dang-ky">
          <?= csrf_field() ?>

          <div class="mb-3">
            <label class="form-label small fw-semibold">Họ và tên *</label>
            <input type="text" name="name" class="form-control"
                   value="<?= e($old['name'] ?? '') ?>" required>
          </div>

          <div class="mb-3">
            <label class="form-label small fw-semibold">Email *</label>
            <input type="email" name="email" class="form-control"
                   value="<?= e($old['email'] ?? '') ?>" required>
          </div>

          <div class="mb-3">
            <label class="form-label small fw-semibold">Số điện thoại</label>
            <input type="text" name="phone" class="form-control"
                   value="<?= e($old['phone'] ?? '') ?>">
          </div>

          <div class="mb-3">
            <label class="form-label small fw-semibold">Mật khẩu * (tối thiểu 6 ký tự)</label>
            <input type="password" name="password" class="form-control" minlength="6" required>
          </div>

          <button type="submit" class="btn btn-primary w-100">Tạo tài khoản</button>
        </form>

        <div class="text-center small mt-3">
          Đã có tài khoản? <a href="/dang-nhap">Đăng nhập</a>
        </div>
      </div>
    </div>
  </div>
</div>