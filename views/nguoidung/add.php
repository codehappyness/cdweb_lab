<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Thêm Người dùng mới</h6>
  </div>
  <div class="card-body">
    <?php if (!empty($error)): ?>
      <div class="alert alert-danger text-center">
        <?= htmlspecialchars($error) ?>
      </div>
    <?php endif; ?>
    <form method="POST" action="index.php?controller=nguoidung&action=store">
      <div class="form-group">
        <label>Họ và Tên <span class="text-danger">*</span></label>
        <input type="text" class="form-control" name="ho_ten" required>
      </div>

      <div class="form-group">
        <label>Tên đăng nhập <span class="text-danger">*</span></label>
        <input type="text" class="form-control" name="ten_dang_nhap" required>
      </div>

      <div class="form-group">
        <label>Mật khẩu <span class="text-danger">*</span></label>
        <input type="password" class="form-control" name="mat_khau" required>
      </div>

      <div class="form-group">
        <label>Email</label>
        <input type="email" class="form-control" name="email">
      </div>

      <div class="form-group">
        <label>Vai trò</label>
        <select class="form-control" name="vai_tro">
          <option value="0">Người dùng thường</option>
          <option value="1">Quản trị viên</option>
        </select>
      </div>

      <button type="submit" class="btn btn-success">Thêm mới</button>
      <a href="index.php?controller=nguoidung&action=index" class="btn btn-secondary">Hủy</a>
    </form>
  </div>
</div>
