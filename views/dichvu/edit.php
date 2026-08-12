<div class="row justify-content-center">
  <div class="col-md-8">

    <div class="card shadow-sm">
      <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h4 class="mb-0">
          <?= (!empty($item->id)) ? 'Chỉnh sửa thông tin Dịch vụ' : 'Thêm mới Dịch vụ' ?>
        </h4>
        <a href="?controller=dichvu&action=index" class="btn btn-light btn-sm">Quay lại</a>
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

          <form action="index.php?controller=dichvu&action=store" method="POST">
            <input type="hidden" name="id" value="<?= old('id', $item->id) ?>">

            <div class="form-group mb-3">
              <label>Tên dịch vụ <span class="text-danger">*</span></label>
              <input type="text" name="ten_dich_vu" class="form-control <?= has_error('ten_dich_vu') ?>" value="<?= old('ten_dich_vu', $item->ten_dich_vu) ?>">
              <?= error('ten_dich_vu') ?>
            </div>

            <div class="form-group mb-3">
              <label>Nhà cung cấp <span class="text-danger">*</span></label>
              <select name="nha_cung_cap_id" class="form-control <?= has_error('nha_cung_cap_id') ?>">
                <option value="">-- Chọn Nhà cung cấp --</option>
                <?php foreach ($nhaCungCaps as $ncc): ?>
                  <option value="<?= $ncc->id ?>" <?= old('nha_cung_cap_id', $item->nha_cung_cap_id) == $ncc->id ? 'selected' : '' ?>>
                    <?= htmlspecialchars($ncc->ten) ?>
                  </option>
                <?php endforeach; ?>
              </select>
              <?= error('nha_cung_cap_id') ?>
            </div>

            <div class="form-group mb-3">
              <label>Mô tả chi tiết</label>
              <textarea name="mo_ta" class="form-control <?= has_error('mo_ta') ?>" rows="4"><?= old('mo_ta', $item->mo_ta) ?></textarea>
              <?= error('mo_ta') ?>
            </div>

            <button type="submit" class="btn btn-primary">Lưu dữ liệu</button>
          </form>

          <?php
          unset($_SESSION['old_input']);
          unset($_SESSION['errors']); 
          ?>

        <?php else: ?>
          <div class="alert alert-danger mb-0" role="alert">
            Không tìm thấy dữ liệu dịch vụ để chỉnh sửa!
          </div>
          <div class="mt-3 text-center">
            <a href="index.php?controller=dichvu" class="btn btn-primary">Quay lại danh sách</a>
          </div>
        <?php endif; ?>
      </div>
    </div>

  </div>
</div>
