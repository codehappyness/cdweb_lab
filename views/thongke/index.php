<?php
$title = 'Thống kê Chi tiêu';
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
  <h1 class="h2">Thống kê Chi tiêu</h1>
</div>

<div class="row">
  <div class="col-md-8 offset-md-2">
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Biểu đồ tổng chi phí hóa đơn theo tháng</h6>
      </div>
      <div class="card-body">
        <canvas id="chiTieuChart" width="400" height="200"></canvas>
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

    var chart = new Chart(ctx, {
      type: 'bar', // Có thể đổi thành 'line' nếu muốn
      data: {
        labels: labels,
        datasets: [{
          label: 'Tổng tiền (VND)',
          data: dataTien,
          backgroundColor: 'rgba(54, 162, 235, 0.5)',
          borderColor: 'rgba(54, 162, 235, 1)',
          borderWidth: 1
        }]
      },
      options: {
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });
  });
</script>
