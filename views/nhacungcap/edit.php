<div class="row justify-content-center">
  <div class="col-md-8">

    <div class="card shadow-sm">
      <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h4 class="mb-0">
          <?= (!empty($item->id)) ? 'Chỉnh sửa thông tin Nhà cung cấp' : 'Thêm mới Nhà cung cấp' ?>
        </h4>
        <a href="?controller=nhacungcap&action=index" class="btn btn-light btn-sm">Quay lại</a>
      </div>

      <div class="card-body">
        <?php if (isset($item)): ?>
          <?php if (isset($_SESSION['flash_message'])): ?>
            <?php
            $flash = $_SESSION['flash_message'];
            $alert_class = ($flash['type'] === 'success') ? 'alert-success' : 'alert-danger';
            ?>
            <div class="alert <?= $alert_class ?>">
              <?= htmlspecialchars($flash['message']) ?>
            </div>
            <?php unset($_SESSION['flash_message']); ?>
          <?php endif; ?>

          <form action="index.php?controller=nhacungcap&action=store" method="POST">
            <input type="hidden" name="id" value="<?= old('id', $item->id) ?>">

            <div class="form-group mb-3">
              <label>Tên nhà cung cấp <span class="text-danger">*</span></label>
              <input type="text" name="ten" class="form-control <?= has_error('ten') ?>" value="<?= old('ten', $item->ten) ?>">
              <?= error('ten') ?>
            </div>



            <div class="form-group mb-3">
              <label>Địa chỉ</label>
              <input type="text" name="dia_chi" class="form-control <?= has_error('dia_chi') ?>" value="<?= old('dia_chi', $item->dia_chi) ?>">
              <?= error('dia_chi') ?>
            </div>

            <div class="form-group mb-3">
              <label>Số điện thoại <span class="text-danger">*</span></label>
              <input type="text" name="so_dien_thoai" class="form-control <?= has_error('so_dien_thoai') ?>" value="<?= old('so_dien_thoai', $item->so_dien_thoai) ?>">
              <?= error('so_dien_thoai') ?>
            </div>

            <button type="submit" class="btn btn-primary">Lưu dữ liệu</button>
          </form>

          <?php
          unset($_SESSION['old_input']);
          unset($_SESSION['errors']); // Thêm dòng này để xóa mảng lỗi sau khi hiển thị xong
          ?>

        <?php else: ?>
          <div class="alert alert-danger mb-0" role="alert">
            Không tìm thấy dữ liệu nhà cung cấp để chỉnh sửa!
          </div>
          <div class="mt-3 text-center">
            <a href="index.php" class="btn btn-primary">Quay lại danh sách</a>
          </div>
        <?php endif; ?>
      </div>
    </div>

  </div>
</div>
