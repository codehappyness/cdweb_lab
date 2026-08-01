<div class="row justify-content-center">
  <div class="col-md-8">
    <div class="card shadow-sm mb-4">
      <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Xác nhận Thanh toán Hóa đơn</h4>
        <a href="?controller=hoadon&action=index" class="btn btn-light btn-sm text-success">Quay lại</a>
      </div>

      <div class="card-body">
        <form action="?controller=hoadon&action=store_pay" method="POST" enctype="multipart/form-data">
          <input type="hidden" name="id" value="<?= $item->id ?>">
          
          <div class="alert alert-info">
            <strong>Thông tin hóa đơn:</strong>
            <ul class="mb-0 mt-1">
              <li>Kỳ cước: <?= htmlspecialchars($item->ky_cuoc) ?></li>
              <li>Số tiền cần đóng: <b class="text-danger"><?= number_format($item->so_tien_can_dong) ?> VND</b></li>
              <li>Hạn thanh toán: <?= date('d/m/Y', strtotime($item->ngay_han_chot)) ?></li>
            </ul>
          </div>

          <div class="form-group mb-3">
            <label>Nền tảng giao dịch <span class="text-danger">*</span></label>
            <select name="ghi_chu_nen_tang" class="form-control" required>
              <option value="">-- Chọn nền tảng thanh toán --</option>
              <optgroup label="Ví điện tử">
                <option value="Momo">Ví Momo</option>
                <option value="ZaloPay">ZaloPay</option>
                <option value="ShopeePay">ShopeePay</option>
                <option value="VNPay">VNPay</option>
                <option value="Viettel Money">Viettel Money</option>
              </optgroup>
              <optgroup label="Ứng dụng Ngân hàng">
                <option value="Vietcombank Digibank">Vietcombank (VCB Digibank)</option>
                <option value="Techcombank Mobile">Techcombank Mobile</option>
                <option value="BIDV SmartBanking">BIDV SmartBanking</option>
                <option value="VPBank NEO">VPBank NEO</option>
                <option value="Agribank E-Mobile">Agribank E-Mobile</option>
                <option value="VietinBank iPay">VietinBank iPay</option>
                <option value="MBBank">MBBank</option>
              </optgroup>
              <optgroup label="Khác">
                <option value="Tiền mặt">Tiền mặt / Thu hộ tại nhà</option>
                <option value="Khác">Nền tảng khác</option>
              </optgroup>
            </select>
          </div>

          <div class="form-group mb-3">
            <label>Loại chứng từ</label>
            <input type="text" name="loai_chung_tu" class="form-control" value="Ảnh chụp màn hình chuyển khoản" required>
          </div>

          <div class="form-group mb-3">
            <label>Tải lên chứng từ (Ảnh biên lai / Chụp màn hình) <span class="text-danger">*</span></label>
            <input type="file" name="file_chung_tu" class="form-control-file" accept="image/*" required>
          </div>

          <button type="submit" class="btn btn-success mt-3"><i class="fas fa-check"></i> Hoàn tất thanh toán</button>
        </form>
      </div>
    </div>
  </div>
</div>
