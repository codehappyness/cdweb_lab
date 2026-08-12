<?php
$title = 'Trang chủ - Quản lý Chi tiêu';
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
  <h1 class="h2">Bảng điều khiển (Dashboard)</h1>
  <div class="btn-toolbar mb-2 mb-md-0">
    <form action="" method="GET" class="d-flex align-items-center">
      <input type="hidden" name="controller" value="<?= htmlspecialchars($_GET['controller'] ?? 'home') ?>">
      <input type="hidden" name="action" value="index">
      <label class="me-2 mb-0 mr-2 font-weight-bold">Chọn tháng:</label>
      <input type="month" name="thang" class="form-control form-control-sm me-2 mr-2" value="<?= htmlspecialchars($thang ?? '') ?>">
      <button type="submit" class="btn btn-sm btn-outline-primary">Xem</button>
      <?php if (!empty($thang)): ?>
        <a href="?controller=<?= htmlspecialchars($_GET['controller'] ?? 'home') ?>&action=index" class="btn btn-sm btn-outline-secondary ml-2">Xóa lọc</a>
      <?php endif; ?>
    </form>
  </div>
</div>

<!-- Cảnh báo hóa đơn quá hạn -->
<?php if (!empty($canhbaos)): ?>
<div class="alert alert-danger shadow-sm mb-4">
  <h6 class="font-weight-bold mb-2"><i class="fas fa-exclamation-triangle"></i> Cảnh báo: Có <?= count($canhbaos) ?> hóa đơn sắp hoặc đã đến hạn thanh toán!</h6>
  <ul class="mb-0">
    <?php foreach ($canhbaos as $cb): ?>
      <li>Hóa đơn kỳ <?= htmlspecialchars($cb->ky_cuoc) ?> - Hạn: <strong class="text-danger"><?= date('d/m/Y', strtotime($cb->ngay_han_chot)) ?></strong> - Số tiền: <strong><?= number_format($cb->so_tien_can_dong) ?> VND</strong></li>
    <?php endforeach; ?>
  </ul>
</div>
<?php endif; ?>


<div class="row">
  <div class="col-12">
    <div class="card shadow mb-4">
      <div class="card-header py-3 bg-primary text-white">
        <h6 class="m-0 font-weight-bold"><?= htmlspecialchars($chart_title ?? 'Biểu đồ') ?></h6>
      </div>
      <div class="card-body">
        <div class="chart-container" style="position: relative; height: <?= ($chart_type == 'pie') ? '400px' : 'auto' ?>; width: 100%; display: flex; justify-content: center;">
            <canvas id="chiTieuChart" <?= ($chart_type == 'pie') ? 'width="400" height="400"' : 'width="400" height="150"' ?>></canvas>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  document.addEventListener("DOMContentLoaded", function() {
    var ctx = document.getElementById('chiTieuChart').getContext('2d');
    var labels = <?= $labels ?>;
    var dataTien = <?= $data_tien ?>;

    var chartType = '<?= $chart_type ?? 'bar' ?>';

    // Tạo mảng màu ngẫu nhiên cho biểu đồ tròn
    var backgroundColors = [];
    var borderColors = [];
    if (chartType === 'pie') {
        for (let i = 0; i < labels.length; i++) {
            const r = Math.floor(Math.random() * 200);
            const g = Math.floor(Math.random() * 200);
            const b = Math.floor(Math.random() * 200);
            backgroundColors.push(`rgba(${r}, ${g}, ${b}, 0.6)`);
            borderColors.push(`rgba(${r}, ${g}, ${b}, 1)`);
        }
    } else {
        backgroundColors = 'rgba(54, 162, 235, 0.6)';
        borderColors = 'rgba(54, 162, 235, 1)';
    }

    var chart = new Chart(ctx, {
      type: chartType,
      data: {
        labels: labels,
        datasets: [{
          label: 'Tổng tiền (VND)',
          data: dataTien,
          backgroundColor: backgroundColors,
          borderColor: borderColors,
          borderWidth: 1,
          borderRadius: (chartType === 'bar') ? 4 : 0
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            position: 'top',
          },
          tooltip: {
            callbacks: {
              label: function(context) {
                let label = context.dataset.label || '';
                if (label) {
                  label += ': ';
                }
                if (context.parsed.y !== null) {
                  label += new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(context.parsed.y);
                }
                return label;
              }
            }
          }
        },
        scales: (chartType === 'bar') ? {
          y: {
            beginAtZero: true,
            ticks: {
              callback: function(value, index, values) {
                return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(value);
              }
            }
          }
        } : {}
      }
    });
  });
</script>
