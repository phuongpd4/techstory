<div class="row justify-content-center">
  <div class="col-12 col-md-5">
    <div class="card shadow-sm border-0">
      <div class="card-body p-4">
        <h1 class="h4 fw-bold mb-3 text-center">Đăng nhập</h1>

        <?php if (!empty($error)): ?>
          <div class="alert alert-danger small"><?= e($error) ?></div>
        <?php endif; ?>

        <form method="POST" action="/dang-nhap">
          <?= csrf_field() ?>

          <div class="mb-3">
            <label class="form-label small fw-semibold">Email</label>
            <input type="email" name="email" class="form-control"
                   value="<?= e($email ?? '') ?>" required placeholder="nhap@email.com">
          </div>

          <div class="mb-3">
            <label class="form-label small fw-semibold">Mật khẩu</label>
            <input type="password" name="password" class="form-control" required>
          </div>

          <button type="submit" class="btn btn-primary w-100">Đăng nhập</button>
        </form>

        <div class="text-center small mt-3">
          Chưa có tài khoản? <a href="/dang-ky">Đăng ký ngay</a>
        </div>
      </div>
    </div>
  </div>
</div>