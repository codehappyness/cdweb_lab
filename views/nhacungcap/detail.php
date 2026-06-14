<div class="row justify-content-center">
  <div class="col-md-8">

    <div class="card shadow-sm">
      <div class="card-header bg-primary text-white">
        <h4 class="mb-0">Thông tin chi tiết Nhà cung cấp</h4>
      </div>

      <div class="card-body">
        <?php if (isset($item)): ?>
          <table class="table table-bordered table-striped mb-0">
            <tbody>
              <tr>
                <th style="width: 35%;">Mã (ID)</th>
                <td><?= htmlspecialchars($item->id) ?></td>
              </tr>
              <tr>
                <th>Tên nhà cung cấp</th>
                <td><?= htmlspecialchars($item->ten) ?></td>
              </tr>
              <tr>
                <th>Loại dịch vụ</th>
                <td>
                  <span class="badge bg-info text-dark">
                    <?= htmlspecialchars($item->loai_dich_vu) ?>
                  </span>
                </td>
              </tr>
              <tr>
                <th>Địa chỉ</th>
                <td><?= htmlspecialchars($item->dia_chi) ?></td>
              </tr>
              <tr>
                <th>Số điện thoại</th>
                <td>
                  <a href="tel:<?= htmlspecialchars($item->so_dien_thoai) ?>" class="text-decoration-none">
                    <?= htmlspecialchars($item->so_dien_thoai) ?>
                  </a>
                </td>
              </tr>
            </tbody>
          </table>
        <?php else: ?>
          <div class="alert alert-danger mb-0" role="alert">
            Không có dữ liệu để hiển thị!
          </div>
        <?php endif; ?>
      </div>

      <div class="card-footer text-end bg-white">
        <a href="javascript:history.back()" class="btn btn-secondary">
          Quay lại
        </a>
        <?php if (isset($item)): ?>
          <a href="edit.php?id=<?= $item->id ?>" class="btn btn-warning">
            Chỉnh sửa
          </a>
        <?php endif; ?>
      </div>
    </div>

  </div>
</div>
