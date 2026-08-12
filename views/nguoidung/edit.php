<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Sửa thông tin Người dùng</h6>
  </div>
  <div class="card-body">
    <form method="POST" action="index.php?controller=nguoidung&action=update">
      <input type="hidden" name="ma_nd" value="<?= $user->ma_nd ?>">
      
      <div class="form-group">
        <label>Tên đăng nhập (Không thể đổi)</label>
        <input type="text" class="form-control" value="<?= htmlspecialchars($user->ten_dang_nhap) ?>" disabled>
      </div>

      <div class="form-group">
        <label>Họ và Tên</label>
        <input type="text" class="form-control" name="ho_ten" value="<?= htmlspecialchars($user->ho_ten) ?>" required>
      </div>

      <div class="form-group">
        <label>Email</label>
        <input type="email" class="form-control" name="email" value="<?= htmlspecialchars($user->email) ?>">
      </div>

      <div class="form-group">
        <label>Mật khẩu (Để trống nếu không đổi)</label>
        <input type="password" class="form-control" name="mat_khau" placeholder="Mật khẩu mới...">
      </div>

      <div class="form-group">
        <label>Vai trò</label>
        <select class="form-control" name="vai_tro">
          <option value="0" <?= $user->vai_tro == 0 ? 'selected' : '' ?>>Người dùng thường</option>
          <option value="1" <?= $user->vai_tro == 1 ? 'selected' : '' ?>>Quản trị viên</option>
        </select>
      </div>

      <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
      <a href="index.php?controller=nguoidung&action=index" class="btn btn-secondary">Hủy</a>
    </form>
  </div>
</div>
