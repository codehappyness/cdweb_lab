<div class="row justify-content-center">
  <div class="col-md-8">

    <div class="card shadow-sm">
      <div class="card-header bg-warning text-dark">
        <h4 class="mb-0">
          <?= (!empty($item->id)) ? 'Chỉnh sửa thông tin Nhà cung cấp' : 'Thêm mới Nhà cung cấp' ?>
        </h4>
      </div>

      <div class="card-body">
        <?php if (isset($item)): ?>
          <!-- Form gửi dữ liệu qua phương thức POST -->
          <form action="?controller=nhacungcap&action=update" method="POST">

            <!-- BẮT BUỘC: Trường ẩn chứa ID để server biết đang sửa bản ghi nào -->
            <input type="hidden" name="id" value="<?= htmlspecialchars($item->id) ?>">

            <div class="mb-3">
              <label for="ten" class="form-label fw-bold">Tên nhà cung cấp <span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="ten" name="ten"
                value="<?= htmlspecialchars($item->ten) ?>" required>
            </div>

            <div class="mb-3">
              <label for="loai_dich_vu" class="form-label fw-bold">Loại dịch vụ</label>
              <input type="text" class="form-control" id="loai_dich_vu" name="loai_dich_vu"
                value="<?= htmlspecialchars($item->loai_dich_vu) ?>">
            </div>

            <div class="mb-3">
              <label for="dia_chi" class="form-label fw-bold">Địa chỉ</label>
              <textarea class="form-control" id="dia_chi" name="dia_chi" rows="3"><?= htmlspecialchars($item->dia_chi) ?></textarea>
            </div>

            <div class="mb-3">
              <label for="so_dien_thoai" class="form-label fw-bold">Số điện thoại</label>
              <input type="tel" class="form-control" id="so_dien_thoai" name="so_dien_thoai"
                value="<?= htmlspecialchars($item->so_dien_thoai) ?>">
            </div>

            <hr>

            <div class="d-flex justify-content-end mx-2">
              <!-- Nút hủy quay lại trang trước -->
              <a href="javascript:history.back()" class="btn btn-secondary">Hủy bỏ</a>
              <!-- Nút submit lưu dữ liệu -->
              <button type="submit" class="btn btn-success ms-2">Lưu thay đổi</button>
            </div>

          </form>
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
