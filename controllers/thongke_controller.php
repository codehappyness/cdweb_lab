<?php
require_once('controllers/base_controller.php');
require_once('models/hoadon.php');

class ThongkeController extends BaseController
{
  function __construct()
  {
    $this->folder = 'thongke';
  }

  public function index()
  {
    $nguoi_dung_id = $_SESSION['user']['ma_nd'] ?? null;
    $thongkeThang = Hoadon::getThongKeTheoThang($nguoi_dung_id);
    
    // Chuẩn bị data cho Chart.js
    $labels = [];
    $data_tien = [];
    foreach ($thongkeThang as $row) {
        $labels[] = $row['thang'];
        $data_tien[] = $row['tong_tien'];
    }

    $data = array(
        'labels' => json_encode($labels),
        'data_tien' => json_encode($data_tien)
    );
    $this->render('index', $data);
  }
}
?>
