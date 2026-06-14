<?php
require_once('controllers/base_controller.php');
require_once('models/nhacungcap.php');
class NhacungcapController extends BaseController
{
  function __construct()
  {
    $this->folder = 'nhacungcap';
  }
  public function index()
  {
    $nhacungcaps = NhaCungCap::getAll();
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

    $nhaCungCap = NhaCungCap::getItem($id);

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

    $nhaCungCap = new NhaCungCap(0, '', '', '', '');

    if ($nhaCungCap) {
      $this->render('edit', [
        'item' => $nhaCungCap
      ]);
    } else {
      echo "Lỗi: Không tìm thấy nhà cung cấp với ID này!";
    }
  }
  public function edit()
  {
    $id = $_GET['id'] ?? null;

    if (!$id) {
      echo "Lỗi: Không có ID được cung cấp!";
      return;
    }

    $nhaCungCap = NhaCungCap::getItem($id);

    if ($nhaCungCap) {
      $this->render('edit', [
        'item' => $nhaCungCap
      ]);
    } else {
      echo "Lỗi: Không tìm thấy nhà cung cấp với ID này!";
    }
  }
  public function update()
  {
    // 1. Early Return: Chặn ngay từ đầu nếu không phải phương thức POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
      header("Location: index.php?controller=nhacungcap&status=error");
      exit();
    }

    // 2. Lấy và làm sạch dữ liệu
    $id = $_POST['id'] ?? null;
    $ten = trim($_POST['ten'] ?? '');
    $loai_dich_vu = trim($_POST['loai_dich_vu'] ?? '');
    $dia_chi = trim($_POST['dia_chi'] ?? '');
    $so_dien_thoai = trim($_POST['so_dien_thoai'] ?? '');

    // 3. Xử lý logic Thêm hoặc Sửa
    if (empty($id)) {
      // Nếu không có ID -> Gọi hàm Thêm mới
      $ket_qua = NhaCungCap::add($ten, $loai_dich_vu, $dia_chi, $so_dien_thoai);
      $status_success = 'added'; // Nên tách biệt trạng thái thêm để dễ hiển thị thông báo
    } else {
      // Nếu có ID -> Gọi hàm Cập nhật
      $ket_qua = NhaCungCap::update($id, $ten, $loai_dich_vu, $dia_chi, $so_dien_thoai);
      $status_success = 'updated';
    }

    // 4. Chuyển hướng một lần duy nhất ở cuối hàm
    // Nếu $ket_qua là true thì lấy biến success, ngược lại là 'error'
    $status = $ket_qua ? $status_success : 'error';

    header("Location: index.php?controller=nhacungcap&status={$status}");
    exit();
  }
  public function delete()
  {
    $id = $_GET['id'] ?? null;

    if (!$id) {
      echo "Lỗi: Không có ID để xóa!";
      return;
    }

    $ket_qua = NhaCungCap::delete($id);

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
