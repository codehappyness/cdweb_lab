<div class="card shadow mb-4">
  <div class="card-header py-3 d-flex justify-content-between align-items-center">
    <h6 class="m-0 font-weight-bold text-primary">Danh sách Người dùng</h6>
    <a href="index.php?controller=nguoidung&action=add" class="btn btn-success btn-sm"><i class="fas fa-plus"></i> Thêm người dùng</a>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>ID</th>
            <th>Họ và Tên</th>
            <th>Tên Đăng Nhập</th>
            <th>Email</th>
            <th>Vai trò</th>
            <th>Hành động</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($users as $user): ?>
            <tr>
              <td><?= $user->ma_nd ?></td>
              <td><?= htmlspecialchars($user->ho_ten) ?></td>
              <td><?= htmlspecialchars($user->ten_dang_nhap) ?></td>
              <td><?= htmlspecialchars($user->email) ?></td>
              <td>
                <?php if ($user->vai_tro == 1): ?>
                  <span class="badge badge-danger">Quản trị viên</span>
                <?php else: ?>
                  <span class="badge badge-secondary">Người dùng</span>
                <?php endif; ?>
              </td>
              <td>
                <a href="index.php?controller=nguoidung&action=edit&id=<?= $user->ma_nd ?>" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                <?php if ($_SESSION['user']['ma_nd'] != $user->ma_nd): ?>
                  <a href="index.php?controller=nguoidung&action=delete&id=<?= $user->ma_nd ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa người dùng này?');"><i class="fas fa-trash"></i></a>
                <?php endif; ?>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
