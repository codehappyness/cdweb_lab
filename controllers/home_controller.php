<?php
require_once('controllers/base_controller.php');
require_once('models/hoadon.php');
class HomeController extends BaseController
{
  function __construct()
  {
    $this->folder = 'home';
  }
  public function hienthitrangchu()
  {
    $this->render('trangchu');
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
        // Nếu chọn tháng, hiển thị biểu đồ tròn (Pie chart) chi tiết từng dịch vụ trong tháng đó
        $thongke = Hoadon::getThongKeDichVuTheoThang($thang, $nguoi_dung_id);
        $chart_type = 'pie';
        $chart_title = 'Cơ cấu chi phí theo dịch vụ trong tháng ' . date('m/Y', strtotime($thang . '-01'));
        foreach ($thongke as $row) {
            $labels[] = $row['ten_dich_vu'];
            $data_tien[] = $row['tong_tien'];
        }
    } else {
        // Mặc định hiển thị biểu đồ cột theo các tháng
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
    $this->render('index', $data);
  }
  public function error()
  {
    $this->render('error');
  }
}
