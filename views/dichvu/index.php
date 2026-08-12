<h1 class="h3 mb-2 text-gray-800">Quản lý Dịch vụ</h1>
<p class="mb-2"></p>
<div class="card shadow mb-4">
  <div class="card-header py-3 d-flex justify-content-between align-items-center">
    <h6 class="m-0 font-weight-bold text-primary">Danh sách</h6>
    <a href="?controller=dichvu&action=add" class="btn btn-success btn-sm">
      + Thêm mới
    </a>
  </div>

  <div class="card-body">
    <div class="table-responsive">
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
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>ID</th>
            <th>Tên dịch vụ</th>
            <th>Nhà cung cấp</th>
            <th>Mô tả</th>
            <th>Hành động</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($list as $item) { ?>
            <tr>
              <td><?php echo $item->id; ?></td>
              <td><?php echo htmlspecialchars($item->ten_dich_vu); ?></td>
              <td><span class="badge bg-info text-white"><?php echo htmlspecialchars($item->ten_nha_cung_cap); ?></span></td>
              <td><?php echo htmlspecialchars($item->mo_ta); ?></td>
              <td>
                <a href="?controller=dichvu&action=edit&id=<?= $item->id ?>" class="btn btn-primary btn-sm">Sửa</a>
                <a href="?controller=dichvu&action=delete&id=<?= $item->id ?>"
                  class="btn btn-danger btn-sm"
                  onclick="return confirm('Bạn có chắc chắn muốn xóa dịch vụ này không? Hành động này không thể hoàn tác!');">
                  Xóa
                </a>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?php
unset($_SESSION['old_input']);
unset($_SESSION['errors']); 
?>
