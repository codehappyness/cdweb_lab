<?php
$title = 'Hồ sơ cá nhân';
?>

<div class="row justify-content-center">
  <div class="col-md-6">
    <div class="card shadow mb-4">
      <div class="card-header py-3 bg-primary text-white">
        <h6 class="m-0 font-weight-bold">Chỉnh sửa thông tin cá nhân</h6>
      </div>
      <div class="card-body">
        
        <?php if (isset($_SESSION['flash_message'])): ?>
          <?php
          $flash = $_SESSION['flash_message'];
          $alert_class = ($flash['type'] === 'success') ? 'alert-success' : 'alert-danger';
          ?>
          <div class="alert <?= $alert_class ?> alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($flash['message']) ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <?php unset($_SESSION['flash_message']); ?>
        <?php endif; ?>

        <form action="?controller=profile&action=store" method="POST">
          <div class="form-group mb-3">
            <label>Tên đăng nhập (Không thể thay đổi)</label>
            <input type="text" class="form-control bg-light" value="<?= htmlspecialchars($user->ten_dang_nhap) ?>" readonly>
          </div>

          <div class="form-group mb-3">
            <label>Họ và tên <span class="text-danger">*</span></label>
            <input type="text" name="ho_ten" class="form-control" value="<?= htmlspecialchars($user->ho_ten) ?>" required>
          </div>

          <div class="form-group mb-3">
            <label>Địa chỉ Email</label>
            <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($user->email ?? '') ?>">
          </div>

          <div class="form-group mb-4">
            <label>Mật khẩu mới (Để trống nếu không muốn đổi)</label>
            <input type="password" name="mat_khau" class="form-control" placeholder="Nhập mật khẩu mới...">
          </div>

          <button type="submit" class="btn btn-primary w-100">Cập nhật thông tin</button>
        </form>

      </div>
    </div>
  </div>
</div>
