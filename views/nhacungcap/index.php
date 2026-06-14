<h1 class="h3 mb-2 text-gray-800">Quản lý nhà cung cấp dịch vụ</h1>
<p class="mb-2"></p>
<div class="card shadow mb-4">
  <div class="card-header py-3 d-flex justify-content-between align-items-center">
    <h6 class="m-0 font-weight-bold text-primary">Danh sách</h6>

    <a href="?controller=nhacungcap&action=add" class="btn btn-success btn-sm">
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
            <th>Loại dịch vụ</th>
            <th>Tên nhà cung cấp</th>
            <th>Địa chỉ</th>
            <th>Số điện thoại</th>
            <th>Hành động</th>
          </tr>
        </thead>
        <tbody>
          <?php
          // Vòng lặp lấy dữ liệu từ mảng $list
          foreach ($list as $item) {
          ?>
            <tr>
              <td><?php echo $item->id; ?></td>
              <td><?php echo $item->loai_dich_vu; ?></td>
              <td><?php echo $item->ten; ?></td>
              <td><?php echo $item->dia_chi; ?></td>
              <td><?php echo $item->so_dien_thoai; ?></td>
              <td>
                <a href="?controller=nhacungcap&action=detail&id=<?= $item->id ?>" class="btn btn-info btn-sm text-white">Xem</a>
                <a href="?controller=nhacungcap&action=edit&id=<?= $item->id ?>" class="btn btn-primary btn-sm">Sửa</a>
                <a href="?controller=nhacungcap&action=delete&id=<?= $item->id ?>"
                  class="btn btn-danger btn-sm"
                  onclick="return confirm('Bạn có chắc chắn muốn xóa nhà cung cấp này không? Hành động này không thể hoàn tác!');">
                  Xóa
                </a>
              </td>
            </tr>
          <?php
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?php
unset($_SESSION['old_input']);
unset($_SESSION['errors']); // Thêm dòng này để xóa mảng lỗi sau khi hiển thị xong
?>
