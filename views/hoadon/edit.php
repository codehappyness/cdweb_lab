<div class="row justify-content-center">
  <div class="col-md-8">
    <div class="card shadow-sm mb-4">
      <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h4 class="mb-0">
          <?= (!empty($item->id)) ? 'Chỉnh sửa Hóa đơn' : 'Thêm mới Hóa đơn' ?>
        </h4>
        <a href="?controller=hoadon&action=index" class="btn btn-light btn-sm">Quay lại</a>
      </div>

      <div class="card-body">
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

        <form action="?controller=hoadon&action=store" method="POST">
          <input type="hidden" name="id" value="<?= $item->id ?>">
          
          <div class="form-group mb-3">
            <label>Nhà cung cấp <span class="text-danger">*</span></label>
            <select name="nha_cung_cap_id" class="form-control" required>
              <option value="">-- Chọn nhà cung cấp --</option>
              <?php foreach ($nhaCungCaps as $ncc): ?>
                <option value="<?= $ncc->id ?>" <?= ($item->nha_cung_cap_id == $ncc->id) ? 'selected' : '' ?>>
                  <?= htmlspecialchars($ncc->ten) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="form-group mb-3">
            <label>Dịch vụ <span class="text-danger">*</span></label>
            <select name="dich_vu_id" class="form-control" required>
              <option value="">-- Chọn dịch vụ --</option>
              <?php foreach ($dichVus as $dv): ?>
                <option value="<?= $dv->id ?>" data-ncc-id="<?= $dv->nha_cung_cap_id ?>" <?= ($item->dich_vu_id == $dv->id) ? 'selected' : '' ?>>
                  <?= htmlspecialchars($dv->ten_dich_vu) ?> (<?= htmlspecialchars($dv->ten_nha_cung_cap) ?>)
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="form-group mb-3">
            <label>Kỳ cước (VD: 05/2024) <span class="text-danger">*</span></label>
            <input type="text" name="ky_cuoc" class="form-control" value="<?= htmlspecialchars($item->ky_cuoc) ?>" required>
          </div>

          <div class="form-group mb-3">
            <label>Số tiền cần đóng <span class="text-danger">*</span></label>
            <input type="number" name="so_tien_can_dong" class="form-control" value="<?= htmlspecialchars($item->so_tien_can_dong) ?>" required>
          </div>

          <div class="form-group mb-3">
            <label>Chỉ số tiêu thụ (VD: 150 kWh, 20 m3)</label>
            <input type="text" name="chi_so_tieu_thu" class="form-control" value="<?= htmlspecialchars($item->chi_so_tieu_thu) ?>">
          </div>

          <div class="form-group mb-3">
            <label>Ngày hạn chót <span class="text-danger">*</span></label>
            <input type="date" name="ngay_han_chot" class="form-control" value="<?= ($item->ngay_han_chot) ? date('Y-m-d', strtotime($item->ngay_han_chot)) : '' ?>" required>
          </div>

          <div class="form-group mb-3">
            <label>Trạng thái</label>
            <select name="trang_thai" class="form-control">
              <option value="0" <?= ($item->trang_thai == 0) ? 'selected' : '' ?>>Chưa thanh toán</option>
              <option value="1" <?= ($item->trang_thai == 1) ? 'selected' : '' ?>>Đã thanh toán</option>
            </select>
          </div>

          <button type="submit" class="btn btn-primary mt-3">Lưu dữ liệu</button>
        </form>

        <?php
        unset($_SESSION['old_input']);
        unset($_SESSION['errors']);
        ?>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const nhaCungCapSelect = document.querySelector('select[name="nha_cung_cap_id"]');
    const dichVuSelect = document.querySelector('select[name="dich_vu_id"]');
    
    // Store original options
    const allDichVuOptions = Array.from(dichVuSelect.options).filter(opt => opt.value !== "");
    
    function filterDichVu() {
        const selectedNccId = nhaCungCapSelect.value;
        const currentDichVuId = dichVuSelect.value;
        
        // Reset dich vu options
        dichVuSelect.innerHTML = '<option value="">-- Chọn dịch vụ --</option>';
        
        let hasSelected = false;
        
        allDichVuOptions.forEach(opt => {
            if (opt.getAttribute('data-ncc-id') === selectedNccId) {
                const newOpt = opt.cloneNode(true);
                dichVuSelect.appendChild(newOpt);
                if (newOpt.value === currentDichVuId) {
                    newOpt.selected = true;
                    hasSelected = true;
                }
            }
        });
        
        if (!hasSelected) {
            dichVuSelect.value = "";
        }
    }

    nhaCungCapSelect.addEventListener('change', filterDichVu);
    // Trigger on load to filter initial state
    filterDichVu();
});
</script>
