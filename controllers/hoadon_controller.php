<?php
require_once('controllers/base_controller.php');
require_once('models/hoadon.php');
require_once('models/nhacungcap.php');
require_once('models/dichvu.php');
require_once('models/chungtu.php');

class HoadonController extends BaseController
{
  function __construct()
  {
    $this->folder = 'hoadon';
  }

  public function index()
  {
    $tu_ngay = $_GET['tu_ngay'] ?? null;
    $den_ngay = $_GET['den_ngay'] ?? null;
    $nha_cung_cap_id = $_GET['nha_cung_cap_id'] ?? null;

    $nguoi_dung_id = $_SESSION['user']['ma_nd'] ?? null;

    $hoadons = Hoadon::getAll($tu_ngay, $den_ngay, $nha_cung_cap_id, $nguoi_dung_id);
    $canhbaos = Hoadon::getCanhBaoDenHan($nguoi_dung_id);
    $nhaCungCaps = NhaCungCap::getAll($nguoi_dung_id);

    $data = array(
      'list' => $hoadons, 
      'canhbaos' => $canhbaos,
      'nhaCungCaps' => $nhaCungCaps,
      'tu_ngay' => $tu_ngay,
      'den_ngay' => $den_ngay,
      'nha_cung_cap_id' => $nha_cung_cap_id
    );
    $this->render('index', $data);
  }

  public function add()
  {
    $nguoi_dung_id = $_SESSION['user']['ma_nd'] ?? null;
    $nhaCungCaps = NhaCungCap::getAll($nguoi_dung_id);
    $dichVus = DichVu::getAll($nguoi_dung_id);
    $hoaDon = new Hoadon(0, 0, 0, 0, 0, '', 0, '', '', 0, '', '', '');
    $this->render('edit', [
      'item' => $hoaDon,
      'nhaCungCaps' => $nhaCungCaps,
      'dichVus' => $dichVus
    ]);
  }

  public function edit()
  {
    $id = $_GET['id'] ?? null;
    if (!$id) {
      back_with('error', 'Mã không có giá trị');
      return;
    }
    $nguoi_dung_id = $_SESSION['user']['ma_nd'] ?? null;
    $hoaDon = Hoadon::getItem($id, $nguoi_dung_id);
    if ($hoaDon) {
      $nhaCungCaps = NhaCungCap::getAll($nguoi_dung_id);
      $dichVus = DichVu::getAll($nguoi_dung_id);
      $this->render('edit', [
        'item' => $hoaDon,
        'nhaCungCaps' => $nhaCungCaps,
        'dichVus' => $dichVus
      ]);
    } else {
      $url_danh_sach = route('hoadon', 'index');
      redirect_with($url_danh_sach, 'error', 'Lỗi: Không tìm thấy hóa đơn này!');
    }
  }

  public function store()
  {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
      back_with('error', 'Phương thức yêu cầu không hợp lệ!');
    }

    $id = $_POST['id'] ?? null;
    $nha_cung_cap_id = $_POST['nha_cung_cap_id'] ?? 0;
    $dich_vu_id = $_POST['dich_vu_id'] ?? 0;
    $loai_hoa_don = $_POST['loai_hoa_don'] ?? 0;
    $ky_cuoc = $_POST['ky_cuoc'] ?? '';
    $so_tien_can_dong = $_POST['so_tien_can_dong'] ?? 0;
    $chi_so_tieu_thu = $_POST['chi_so_tieu_thu'] ?? '';
    $ngay_han_chot = $_POST['ngay_han_chot'] ?? '';
    $trang_thai = $_POST['trang_thai'] ?? 0;
    $ghi_chu_nen_tang = $_POST['ghi_chu_nen_tang'] ?? '';

    $nguoi_dung_id = $_SESSION['user']['ma_nd'] ?? null;

    if (empty($id)) {
      $ket_qua = Hoadon::add($nha_cung_cap_id, $dich_vu_id, $nguoi_dung_id, $loai_hoa_don, $ky_cuoc, $so_tien_can_dong, $chi_so_tieu_thu, $ngay_han_chot, $trang_thai);
      $status_success = 'Thêm mới hóa đơn thành công!';
    } else {
      $hoa_don_ton_tai = Hoadon::getItem($id, $nguoi_dung_id);
      if (!$hoa_don_ton_tai) {
        back_with('error', 'Không tìm thấy hóa đơn này!');
      }
      $ket_qua = Hoadon::update($id, $nha_cung_cap_id, $dich_vu_id, $nguoi_dung_id, $loai_hoa_don, $ky_cuoc, $so_tien_can_dong, $chi_so_tieu_thu, $ngay_han_chot, $trang_thai, $ghi_chu_nen_tang);
      $status_success = 'Cập nhật thành công!';
    }

    if ($ket_qua) {
      $url_danh_sach = route('hoadon', 'index');
      redirect_with($url_danh_sach, 'success', $status_success);
    } else {
      back_with('error', 'Lỗi hệ thống, không thể lưu dữ liệu!', true);
    }
  }

  public function pay()
  {
    $id = $_GET['id'] ?? null;
    if (!$id) {
      back_with('error', 'Mã không có giá trị');
      return;
    }
    $nguoi_dung_id = $_SESSION['user']['ma_nd'] ?? null;
    $hoaDon = Hoadon::getItem($id, $nguoi_dung_id);
    if ($hoaDon) {
      $this->render('pay', [
        'item' => $hoaDon
      ]);
    } else {
      $url_danh_sach = route('hoadon', 'index');
      redirect_with($url_danh_sach, 'error', 'Lỗi: Không tìm thấy hóa đơn này!');
    }
  }

  public function store_pay()
  {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
      back_with('error', 'Phương thức yêu cầu không hợp lệ!');
    }

    $id = $_POST['id'] ?? null;
    $ghi_chu_nen_tang = $_POST['ghi_chu_nen_tang'] ?? '';
    $loai_chung_tu = $_POST['loai_chung_tu'] ?? 'Hóa đơn';

    $nguoi_dung_id = $_SESSION['user']['ma_nd'] ?? null;
    $hoaDon = Hoadon::getItem($id, $nguoi_dung_id);
    if (!$hoaDon) {
      back_with('error', 'Không tìm thấy hóa đơn này!');
    }

    // Cập nhật trạng thái và ghi chú giao dịch
    Hoadon::update(
        $hoaDon->id,
        $hoaDon->nha_cung_cap_id,
        $hoaDon->dich_vu_id,
        $hoaDon->nguoi_dung_id,
        $hoaDon->loai_hoa_don,
        $hoaDon->ky_cuoc,
        $hoaDon->so_tien_can_dong,
        $hoaDon->chi_so_tieu_thu,
        $hoaDon->ngay_han_chot,
        1, // Đã thanh toán
        $ghi_chu_nen_tang
    );

    // Xử lý upload ảnh
    $duong_dan_anh = '';
    if (isset($_FILES['file_chung_tu']) && $_FILES['file_chung_tu']['error'] == 0) {
      $upload_dir = 'assets/uploads/';
      if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
      }
      $filename = time() . '_' . basename($_FILES['file_chung_tu']['name']);
      $target_file = $upload_dir . $filename;
      
      if (move_uploaded_file($_FILES['file_chung_tu']['tmp_name'], $target_file)) {
        $duong_dan_anh = $target_file;
        ChungTu::add($id, $loai_chung_tu, $duong_dan_anh);
      }
    }

    $url_danh_sach = route('hoadon', 'index');
    redirect_with($url_danh_sach, 'success', 'Thanh toán và lưu chứng từ thành công!');
  }

  public function delete()
  {
    $id = $_GET['id'] ?? null;
    if (!$id) {
      echo "Lỗi: Không có ID để xóa!";
      return;
    }
    $nguoi_dung_id = $_SESSION['user']['ma_nd'] ?? null;
    $ket_qua = Hoadon::delete($id, $nguoi_dung_id);
    if ($ket_qua) {
      header("Location: index.php?controller=hoadon&msg=deleted");
      exit();
    } else {
      echo "Lỗi: Không thể xóa!";
    }
  }
}
?>
