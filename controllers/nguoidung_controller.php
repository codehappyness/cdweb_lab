<?php
require_once('controllers/base_controller.php');
require_once('models/nguoidung.php');

class NguoiDungController extends BaseController
{
  function __construct()
  {
    $this->folder = 'nguoidung';
    // Protect routes: only admin can access this controller
    if (!isset($_SESSION['user']) || $_SESSION['user']['vai_tro'] != 1) {
      header('Location: index.php?controller=home&action=index');
      exit();
    }
  }

  public function index()
  {
    $users = NguoiDung::getAll();
    $data = array('users' => $users);
    $this->render('index', $data);
  }

  public function add()
  {
    $error = '';
    if (isset($_SESSION['error'])) {
      $error = $_SESSION['error'];
      unset($_SESSION['error']);
    }
    $data = array('error' => $error);
    $this->render('add', $data);
  }

  public function store()
  {
    if (isset($_POST['ten_dang_nhap'])) {
      $ten_dang_nhap = trim($_POST['ten_dang_nhap']);
      $mat_khau = $_POST['mat_khau'];
      $ho_ten = trim($_POST['ho_ten']);
      $email = isset($_POST['email']) ? trim($_POST['email']) : '';
      $vai_tro = isset($_POST['vai_tro']) ? $_POST['vai_tro'] : 0;

      if (NguoiDung::checkTonTai($ten_dang_nhap)) {
        $_SESSION['error'] = 'Tên đăng nhập đã tồn tại!';
        header('Location: index.php?controller=nguoidung&action=add');
        exit();
      }

      NguoiDung::add($ten_dang_nhap, $mat_khau, $ho_ten, $email, $vai_tro);
      header('Location: index.php?controller=nguoidung&action=index');
    }
  }

  public function edit()
  {
    if (isset($_GET['id'])) {
      $id = $_GET['id'];
      $user = NguoiDung::getItem($id);
      if ($user) {
        $data = array('user' => $user);
        $this->render('edit', $data);
      } else {
        header('Location: index.php?controller=nguoidung&action=index');
      }
    } else {
      header('Location: index.php?controller=nguoidung&action=index');
    }
  }

  public function update()
  {
    if (isset($_POST['ma_nd'])) {
      $id = $_POST['ma_nd'];
      $ho_ten = $_POST['ho_ten'];
      $email = $_POST['email'];
      $vai_tro = $_POST['vai_tro'];
      $mat_khau = !empty($_POST['mat_khau']) ? $_POST['mat_khau'] : null;

      NguoiDung::update($id, $ho_ten, $email, $vai_tro, $mat_khau);
      header('Location: index.php?controller=nguoidung&action=index');
    }
  }

  public function delete()
  {
    if (isset($_GET['id'])) {
      $id = $_GET['id'];
      // Prevent admin from deleting themselves
      if ($_SESSION['user']['ma_nd'] != $id) {
        NguoiDung::delete($id);
      }
    }
    header('Location: index.php?controller=nguoidung&action=index');
  }
}
