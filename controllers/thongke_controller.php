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
    $thang = $_GET['thang'] ?? null;
    
    $labels = [];
    $data_tien = [];
    $chart_type = 'bar';
    $chart_title = 'Biểu đồ tổng chi phí hóa đơn theo tháng';

    if ($thang) {
        $thongke = Hoadon::getThongKeDichVuTheoThang($thang, $nguoi_dung_id);
        $chart_type = 'pie';
        $chart_title = 'Cơ cấu chi phí theo dịch vụ trong tháng ' . date('m/Y', strtotime($thang . '-01'));
        foreach ($thongke as $row) {
            $labels[] = $row['ten_dich_vu'];
            $data_tien[] = $row['tong_tien'];
        }
    } else {
        $thongke = Hoadon::getThongKeTheoThang($nguoi_dung_id);
        foreach ($thongke as $row) {
            $labels[] = $row['thang'];
            $data_tien[] = $row['tong_tien'];
        }
    }

    $chua_thanh_toan = Hoadon::getChuaThanhToanSummary($nguoi_dung_id);
    $canhbaos = Hoadon::getCanhBaoDenHan($nguoi_dung_id);

    $data = array(
        'labels' => json_encode($labels),
        'data_tien' => json_encode($data_tien),
        'chart_type' => $chart_type,
        'chart_title' => $chart_title,
        'thang' => $thang,
        'user_info' => $_SESSION['user'] ?? null,
        'chua_thanh_toan' => $chua_thanh_toan,
        'canhbaos' => $canhbaos
    );
    // Tái sử dụng chung một giao diện với trang chủ
    $this->render('index', $data);
  }
}
?>
