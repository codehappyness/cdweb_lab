<?php
require_once('models/nguoidung.php');

class AuthController
{
  public function login()
  {
    if (isset($_SESSION['user'])) {
      header('Location: index.php?controller=home&action=index');
      exit();
    }
    
    $error = '';
    $success = '';
    if (isset($_SESSION['error'])) {
      $error = $_SESSION['error'];
      unset($_SESSION['error']);
    }
    if (isset($_SESSION['success'])) {
      $success = $_SESSION['success'];
      unset($_SESSION['success']);
    }
    
    require_once('views/auth/login.php');
  }

  public function loginPost()
  {
    if (isset($_POST['ten_dang_nhap']) && isset($_POST['mat_khau'])) {
      $ten_dang_nhap = $_POST['ten_dang_nhap'];
      $mat_khau = $_POST['mat_khau'];

      $user = NguoiDung::kiemTraDangNhap($ten_dang_nhap, $mat_khau);

      if ($user) {
        $_SESSION['user'] = [
          'ma_nd' => $user->ma_nd,
          'ten_dang_nhap' => $user->ten_dang_nhap,
          'ho_ten' => $user->ho_ten,
          'email' => $user->email,
          'vai_tro' => $user->vai_tro
        ];
        header('Location: index.php?controller=home&action=index');
        exit();
      } else {
        $_SESSION['error'] = 'Tên đăng nhập hoặc mật khẩu không đúng.';
        header('Location: index.php?controller=auth&action=login');
        exit();
      }
    } else {
      header('Location: index.php?controller=auth&action=login');
      exit();
    }
  }

  public function register()
  {
    if (isset($_SESSION['user'])) {
      header('Location: index.php?controller=home&action=index');
      exit();
    }
    
    $error = '';
    $success = '';
    if (isset($_SESSION['error'])) {
      $error = $_SESSION['error'];
      unset($_SESSION['error']);
    }
    if (isset($_SESSION['success'])) {
      $success = $_SESSION['success'];
      unset($_SESSION['success']);
    }
    
    require_once('views/auth/register.php');
  }

  public function registerPost()
  {
    if (isset($_POST['ten_dang_nhap']) && isset($_POST['mat_khau']) && isset($_POST['ho_ten'])) {
      $ten_dang_nhap = trim($_POST['ten_dang_nhap']);
      $mat_khau = $_POST['mat_khau'];
      $ho_ten = trim($_POST['ho_ten']);
      $email = isset($_POST['email']) ? trim($_POST['email']) : '';

      if (NguoiDung::checkTonTai($ten_dang_nhap)) {
        $_SESSION['error'] = 'Tên đăng nhập đã tồn tại. Vui lòng chọn tên khác.';
        header('Location: index.php?controller=auth&action=register');
        exit();
      }

      $isSuccess = NguoiDung::add($ten_dang_nhap, $mat_khau, $ho_ten, $email, 0);

      if ($isSuccess) {
        $_SESSION['success'] = 'Đăng ký tài khoản thành công! Bạn có thể đăng nhập.';
        header('Location: index.php?controller=auth&action=login');
        exit();
      } else {
        $_SESSION['error'] = 'Có lỗi xảy ra trong quá trình đăng ký.';
        header('Location: index.php?controller=auth&action=register');
        exit();
      }
    } else {
      header('Location: index.php?controller=auth&action=register');
      exit();
    }
  }

  public function logout()
  {
    session_destroy();
    header('Location: index.php?controller=auth&action=login');
    exit();
  }
}
