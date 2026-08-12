<?php
require_once('controllers/base_controller.php');
require_once('models/nhacungcap.php');
require_once('models/hoadon.php');

class NhacungcapController extends BaseController
{
  function __construct()
  {
    $this->folder = 'nhacungcap';
  }
  public function index()
  {
    $user_id = isset($_SESSION['user']['ma_nd']) ? $_SESSION['user']['ma_nd'] : null;
    $nhacungcaps = NhaCungCap::getAll($user_id);
    $data = array('list' => $nhacungcaps);
    $this->render('index', $data);
  }

  public function detail()
  {
    $id = $_GET['id'] ?? null;

    if (!$id) {
      echo "Lỗi: Không có ID được cung cấp!";
      return;
    }

    $user_id = isset($_SESSION['user']['ma_nd']) ? $_SESSION['user']['ma_nd'] : null;
    $nhaCungCap = NhaCungCap::getItem($id, $user_id);

    if ($nhaCungCap) {
      $this->render('detail', [
        'item' => $nhaCungCap
      ]);
    } else {
      echo "Lỗi: Không tìm thấy nhà cung cấp với ID này!";
    }
  }

  public function add()
  {
    $nhaCungCap = new NhaCungCap(0, '', '', '');

    $this->render('edit', [
      'item' => $nhaCungCap
    ]);
  }

  public function edit()
  {
    $id = $_GET['id'] ?? null;

    if (!$id) {
      back_with('error', 'Mã không có giá trị');
      return;
    }

    $user_id = isset($_SESSION['user']['ma_nd']) ? $_SESSION['user']['ma_nd'] : null;
    $nhaCungCap = NhaCungCap::getItem($id, $user_id);

    if ($nhaCungCap) {
      $this->render('edit', [
        'item' => $nhaCungCap
      ]);
    } else {
      $url_danh_sach = route('nhacungcap', 'index');
      redirect_with($url_danh_sach, 'error', 'Lỗi: Không tìm thấy nhà cung cấp với ID này!');
    }
  }

  public function store()
  {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
      back_with('error', 'Phương thức yêu cầu không hợp lệ!');
    }

    $id = $_POST['id'] ?? null;
    $ten = trim($_POST['ten'] ?? '');
    $dia_chi = trim($_POST['dia_chi'] ?? '');
    $so_dien_thoai = trim($_POST['so_dien_thoai'] ?? '');
    $nguoi_dung_id = isset($_SESSION['user']['ma_nd']) ? $_SESSION['user']['ma_nd'] : 0;

    $errors = [];

    if (empty($ten)) {
      $errors['ten'] = 'Tên nhà cung cấp không được để trống.';
    } elseif (strlen($ten) < 3) {
      $errors['ten'] = 'Tên nhà cung cấp phải có ít nhất 3 ký tự.';
    }

    if (empty($so_dien_thoai)) {
      $errors['so_dien_thoai'] = 'Vui lòng nhập số điện thoại.';
    } elseif (!is_numeric($so_dien_thoai)) {
      $errors['so_dien_thoai'] = 'Số điện thoại chỉ được chứa chữ số.';
    }

    if (!empty($errors)) {
      back_with_errors($errors, 'Có lỗi xảy ra, vui lòng kiểm tra các trường màu đỏ!');
    }

    if (empty($id)) {
      $ket_qua = NhaCungCap::add($ten, $dia_chi, $so_dien_thoai, $nguoi_dung_id);
      $status_success = 'Thêm mới nhà cung cấp thành công!';
    } else {
      $nha_cung_cap_ton_tai = NhaCungCap::getItem($id, $nguoi_dung_id);
      if (!$nha_cung_cap_ton_tai) {
        back_with('error', 'Không tìm thấy nhà cung cấp này!');
      }
      $ket_qua = NhaCungCap::update($id, $ten, $dia_chi, $so_dien_thoai);
      $status_success = 'Cập nhật thành công!';
    }

    if ($ket_qua) {
      $url_danh_sach = route('nhacungcap', 'index');
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
    $nhacungcap = NhaCungCap::getItem($id, $user_id);
    if(!$nhacungcap)
    {
      $url_danh_sach = route('nhacungcap', 'index');
      redirect_with($url_danh_sach, 'error', 'Không tìm thấy nhà cung cấp cần xóa');
      return;
    }

    if (NhaCungCap::hasDichVuOrHoaDon($id, $user_id)) {
      $url_danh_sach = route('nhacungcap', 'index');
      redirect_with($url_danh_sach, 'error', 'Không thể xóa nhà cung cấp này vì đã có dịch vụ hoặc hóa đơn liên kết!');
      return;
    }

    $ket_qua = NhaCungCap::delete($id, $user_id);

    if ($ket_qua) {
      header("Location: index.php?controller=nhacungcap&msg=deleted");
      exit();
    } else {
      echo "Lỗi: Không thể xóa nhà cung cấp này khỏi cơ sở dữ liệu!";
    }
  }

  public function error()
  {
    $this->render('error');
  }
}
