<h1 class="h3 mb-2 text-gray-800">Quản lý hóa đơn</h1>
<p class="mb-2"></p>

<?php if (isset($canhbaos) && count($canhbaos) > 0): ?>
<div class="alert alert-danger shadow-sm">
  <strong>Cảnh báo:</strong> Có <?= count($canhbaos) ?> hóa đơn sắp đến hạn thanh toán!
  <ul class="mb-0 mt-1">
    <?php foreach ($canhbaos as $cb): ?>
      <li>Hóa đơn kỳ <?= htmlspecialchars($cb->ky_cuoc) ?> - Hạn: <?= date('d/m/Y', strtotime($cb->ngay_han_chot)) ?> - Số tiền: <?= number_format($cb->so_tien_can_dong) ?> VND</li>
    <?php endforeach; ?>
  </ul>
</div>
<?php endif; ?>

<div class="card shadow mb-4">
  <div class="card-header py-3 d-flex justify-content-between align-items-center">
    <h6 class="m-0 font-weight-bold text-primary">Danh sách hóa đơn</h6>
    <a href="?controller=hoadon&action=add" class="btn btn-success btn-sm">
      + Thêm mới
    </a>
  </div>

  <div class="card-body">
    <!-- Bộ lọc -->
    <div class="mb-4 p-3 bg-light rounded border">
      <form action="" method="GET" class="form-inline">
        <input type="hidden" name="controller" value="hoadon">
        <input type="hidden" name="action" value="index">
        
        <label class="mr-2 font-weight-bold">Từ ngày:</label>
        <input type="date" name="tu_ngay" class="form-control form-control-sm mr-4" value="<?= htmlspecialchars($tu_ngay ?? '') ?>">
        
        <label class="mr-2 font-weight-bold">Đến ngày:</label>
        <input type="date" name="den_ngay" class="form-control form-control-sm mr-4" value="<?= htmlspecialchars($den_ngay ?? '') ?>">
        
        <label class="mr-2 font-weight-bold">Nhà cung cấp:</label>
        <select name="nha_cung_cap_id" class="form-control form-control-sm mr-4">
          <option value="">-- Tất cả --</option>
          <?php foreach ($nhaCungCaps as $ncc): ?>
            <option value="<?= $ncc->id ?>" <?= (isset($nha_cung_cap_id) && $nha_cung_cap_id == $ncc->id) ? 'selected' : '' ?>><?= htmlspecialchars($ncc->ten) ?></option>
          <?php endforeach; ?>
        </select>
        
        <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-search"></i> Lọc</button>
        <a href="?controller=hoadon&action=index" class="btn btn-secondary btn-sm ml-2">Xóa lọc</a>
      </form>
    </div>

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
            <th>Nhà cung cấp</th>
            <th>Dịch vụ</th>
            <th>Kỳ cước</th>
            <th class="text-right">Số tiền</th>
            <th>Hạn chót</th>
            <th>Trạng thái</th>
            <th>Hành động</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($list)): ?>
            <?php foreach ($list as $item): ?>
              <tr>
                <td><?= $item->id ?></td>
                <td>
                  <?php 
                    $ncc = NhaCungCap::getItem($item->nha_cung_cap_id);
                    echo $ncc ? htmlspecialchars($ncc->ten) : 'Không xác định';
                  ?>
                </td>
                <td>
                  <?php 
                    $dv = DichVu::getItem($item->dich_vu_id);
                    echo $dv ? htmlspecialchars($dv->ten_dich_vu) : 'Không xác định';
                  ?>
                </td>
                <td><?= htmlspecialchars($item->ky_cuoc) ?></td>
                <td class="text-right font-weight-bold text-primary"><?= number_format($item->so_tien_can_dong) ?> VND</td>
                <td><?= date('d/m/Y', strtotime($item->ngay_han_chot)) ?></td>
                <td>
                  <?php if ($item->trang_thai == 1): ?>
                    <span class="badge badge-success">Đã thanh toán</span>
                  <?php else: ?>
                    <span class="badge badge-warning">Chưa thanh toán</span>
                  <?php endif; ?>
                </td>
                <td>
                  <?php if ($item->trang_thai == 0): ?>
                    <a href="?controller=hoadon&action=pay&id=<?= $item->id ?>" class="btn btn-success btn-sm">Thanh toán</a>
                  <?php endif; ?>
                  <a href="?controller=hoadon&action=edit&id=<?= $item->id ?>" class="btn btn-primary btn-sm">Sửa</a>
                  <a href="?controller=hoadon&action=delete&id=<?= $item->id ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa?');">Xóa</a>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="8" class="text-center">Chưa có dữ liệu</td>
            </tr>
          <?php endif; ?>
        </tbody>
        <?php
          $tongTien = 0;
          if (!empty($list)) {
            foreach ($list as $item) {
              $tongTien += $item->so_tien_can_dong;
            }
          }
        ?>
        <tfoot>
          <tr class="bg-light">
            <th colspan="4" class="text-right font-weight-bold">Tổng cộng:</th>
            <th class="text-right font-weight-bold text-danger"><?= number_format($tongTien) ?> VND</th>
            <th colspan="3"></th>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>
</div>

<?php
unset($_SESSION['old_input']);
unset($_SESSION['errors']);
?>
