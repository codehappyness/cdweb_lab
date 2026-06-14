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
  public function storej()
  {

    // Nếu muốn hiện thị lại trang danh sách sản phẩm
    // $this->index();
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
      header("Location: index.php?controller=nhacungcap&status=error");
      exit();
    }

    $id = $_POST['id'] ?? null;
    $ten = trim($_POST['ten'] ?? '');
    $loai_dich_vu = trim($_POST['loai_dich_vu'] ?? '');
    $dia_chi = trim($_POST['dia_chi'] ?? '');
    $so_dien_thoai = trim($_POST['so_dien_thoai'] ?? '');

    if (empty($id)) {
      $ket_qua = NhaCungCap::add($ten, $loai_dich_vu, $dia_chi, $so_dien_thoai);
      $status_success = 'added';
    } else {
      $status_success = 'updated';
      $nha_cung_cap_ton_tai = NhaCungCap::getItem($id); // Thay bằng tên hàm lấy chi tiết trong Model của bạn

      if (!$nha_cung_cap_ton_tai) {
        // Nếu không tìm thấy nhà cung cấp trong DB -> Điều hướng về kèm lỗi
        header("Location: index.php?controller=nhacungcap&status=not_found");
        exit();
      }

      // Nếu tồn tại thì mới tiến hành update
      $ket_qua = NhaCungCap::update($id, $ten, $loai_dich_vu, $dia_chi, $so_dien_thoai);
      $status_success = 'updated';
    }

    $status = $ket_qua ? $status_success : 'error';

    header("Location: index.php?controller=nhacungcap&status={$status}");
    exit();
  }
  public function store()
  {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
      back_with('error', 'Phương thức yêu cầu không hợp lệ!');
    }

    $id = $_POST['id'] ?? null;
    $ten = trim($_POST['ten'] ?? '');
    $loai_dich_vu = trim($_POST['loai_dich_vu'] ?? '');
    $dia_chi = trim($_POST['dia_chi'] ?? '');
    $so_dien_thoai = trim($_POST['so_dien_thoai'] ?? '');

    // 1. KHỞI TẠO MẢNG LỖI
    $errors = [];

    // 2. KIỂM TRA TỪNG TRƯỜNG (VALIDATION)
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

    // 3. NẾU CÓ LỖI -> QUAY LẠI VÀ BÁO LỖI
    if (!empty($errors)) {
      // Dùng hàm mới viết, nó sẽ tự động gửi mảng $errors và giữ lại old input
      back_with_errors($errors, 'Có lỗi xảy ra, vui lòng kiểm tra các trường màu đỏ!');
    }

    // 4. NẾU KHÔNG CÓ LỖI -> TIẾP TỤC LƯU DATABASE
    if (empty($id)) {
      $ket_qua = NhaCungCap::add($ten, $loai_dich_vu, $dia_chi, $so_dien_thoai);
      $status_success = 'Thêm mới nhà cung cấp thành công!';
      $type = 'success';
    } else {
      $nha_cung_cap_ton_tai = NhaCungCap::getItem($id);
      if (!$nha_cung_cap_ton_tai) {
        back_with('error', 'Không tìm thấy nhà cung cấp này!');
      }
      $ket_qua = NhaCungCap::update($id, $ten, $loai_dich_vu, $dia_chi, $so_dien_thoai);
      $status_success = 'Cập nhật thành công!';
      $type = 'success';
    }

    // if ($ket_qua) {
    //   back_with($type, $status_success);
    // } else {
    //   back_with('error', 'Có lỗi khi lưu vào cơ sở dữ liệu!', true);
    // }
    // XỬ LÝ CHUYỂN HƯỚNG CUỐI CÙNG
    if ($ket_qua) {
      // THÀNH CÔNG: Chuyển hướng về trang danh sách (Giống redirect()->route('nhacungcap.index')->with(...))
      $url_danh_sach = route('nhacungcap', 'index');
      redirect_with($url_danh_sach, 'success', $status_success);
    } else {
      // THẤT BẠI KHI LƯU DB: Quay lại form
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
