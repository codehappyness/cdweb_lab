<?php
require_once('controllers/base_controller.php');
require_once('models/nguoidung.php');

class ProfileController extends BaseController
{
  function __construct()
  {
    $this->folder = 'auth';
    
    // Yêu cầu đăng nhập
    if (!isset($_SESSION['user'])) {
      header('Location: index.php?controller=auth&action=login');
      exit();
    }
  }

  public function index()
  {
    $user_id = $_SESSION['user']['ma_nd'];
    $user = NguoiDung::getItem($user_id);
    
    // Trả về view: views/auth/profile.php (vì folder là 'auth')
    $this->render('profile', ['user' => $user]);
  }

  public function store()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $user_id = $_SESSION['user']['ma_nd'];
      $ho_ten = trim($_POST['ho_ten'] ?? '');
      $email = trim($_POST['email'] ?? '');
      $mat_khau_moi = trim($_POST['mat_khau'] ?? '');

      $user = NguoiDung::getItem($user_id);
      
      // Giữ nguyên vai trò hiện tại
      $vai_tro = $user->vai_tro;
      
      $mat_khau_update = !empty($mat_khau_moi) ? $mat_khau_moi : null;
      
      NguoiDung::update($user_id, $ho_ten, $email, $vai_tro, $mat_khau_update);
      
      // Cập nhật session hiện tại
      $_SESSION['user']['ho_ten'] = $ho_ten;
      $_SESSION['user']['email'] = $email;

      $_SESSION['flash_message'] = [
        'type' => 'success',
        'message' => 'Cập nhật thông tin tài khoản thành công!'
      ];
      
      header('Location: index.php?controller=profile&action=index');
      exit();
    }
  }
}
?>
