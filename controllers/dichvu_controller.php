<?php
require_once('controllers/base_controller.php');
require_once('models/dichvu.php');
require_once('models/nhacungcap.php');

class DichvuController extends BaseController
{
  function __construct()
  {
    $this->folder = 'dichvu';
  }
  
  public function index()
  {
    $user_id = isset($_SESSION['user']['ma_nd']) ? $_SESSION['user']['ma_nd'] : null;
    $dichvus = DichVu::getAll($user_id);
    $data = array('list' => $dichvus);
    $this->render('index', $data);
  }

  public function add()
  {
    $user_id = isset($_SESSION['user']['ma_nd']) ? $_SESSION['user']['ma_nd'] : null;
    $dichVu = new DichVu(0, '', '', 0);
    $nhaCungCaps = NhaCungCap::getAll($user_id);

    $this->render('edit', [
      'item' => $dichVu,
      'nhaCungCaps' => $nhaCungCaps
    ]);
  }

  public function edit()
  {
    $id = $_GET['id'] ?? null;
    $user_id = isset($_SESSION['user']['ma_nd']) ? $_SESSION['user']['ma_nd'] : null;

    if (!$id) {
      back_with('error', 'Mã không có giá trị');
      return;
    }

    $dichVu = DichVu::getItem($id, $user_id);

    if ($dichVu) {
      $nhaCungCaps = NhaCungCap::getAll($user_id);
      $this->render('edit', [
        'item' => $dichVu,
        'nhaCungCaps' => $nhaCungCaps
      ]);
    } else {
      $url_danh_sach = route('dichvu', 'index');
      redirect_with($url_danh_sach, 'error', 'Lỗi: Không tìm thấy dịch vụ với ID này!');
    }
  }

  public function store()
  {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
      back_with('error', 'Phương thức yêu cầu không hợp lệ!');
    }

    $id = $_POST['id'] ?? null;
    $ten_dich_vu = trim($_POST['ten_dich_vu'] ?? '');
    $mo_ta = trim($_POST['mo_ta'] ?? '');
    $nha_cung_cap_id = trim($_POST['nha_cung_cap_id'] ?? 0);
    $nguoi_dung_id = isset($_SESSION['user']['ma_nd']) ? $_SESSION['user']['ma_nd'] : 0;

    $errors = [];

    if (empty($ten_dich_vu)) {
      $errors['ten_dich_vu'] = 'Tên dịch vụ không được để trống.';
    }

    if (empty($nha_cung_cap_id)) {
      $errors['nha_cung_cap_id'] = 'Vui lòng chọn nhà cung cấp.';
    }

    if (!empty($errors)) {
      back_with_errors($errors, 'Có lỗi xảy ra, vui lòng kiểm tra các trường màu đỏ!');
    }

    if (empty($id)) {
      $ket_qua = DichVu::add($ten_dich_vu, $mo_ta, $nha_cung_cap_id, $nguoi_dung_id);
      $status_success = 'Thêm mới dịch vụ thành công!';
    } else {
      $dich_vu_ton_tai = DichVu::getItem($id, $nguoi_dung_id);
      if (!$dich_vu_ton_tai) {
        back_with('error', 'Không tìm thấy dịch vụ này!');
      }
      $ket_qua = DichVu::update($id, $ten_dich_vu, $mo_ta, $nha_cung_cap_id);
      $status_success = 'Cập nhật thành công!';
    }

    if ($ket_qua) {
      $url_danh_sach = route('dichvu', 'index');
      redirect_with($url_danh_sach, 'success', $status_success);
    } else {
      back_with('error', 'Lỗi hệ thống, không thể lưu dữ liệu!', true);
    }
  }

  public function delete()
  {
    $id = $_GET['id'] ?? null;

    if (!$id) {
      echo "Lỗi: Không có ID để xóa!";
      return;
    }

    $user_id = isset($_SESSION['user']['ma_nd']) ? $_SESSION['user']['ma_nd'] : null;
    $dichvu = DichVu::getItem($id, $user_id);
    if(!$dichvu)
    {
      $url_danh_sach = route('dichvu', 'index');
      redirect_with($url_danh_sach, 'error', 'Không tìm thấy dịch vụ cần xóa');
      return;
    }

    // Check if invoices use this service (we need to update hoadon model later to count by dich_vu_id)
    // For now we will allow delete or just skip constraint checking if not implemented
    
    $ket_qua = DichVu::delete($id, $user_id);

    if ($ket_qua) {
      header("Location: index.php?controller=dichvu&msg=deleted");
      exit();
    } else {
      echo "Lỗi: Không thể xóa dịch vụ này khỏi cơ sở dữ liệu!";
    }
  }

  public function error()
  {
    $this->render('error');
  }
}
