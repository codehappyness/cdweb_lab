<?php
class NguoiDung
{
  public $ma_nd;
  public $ten_dang_nhap;
  public $ho_ten;
  public $email;
  public $vai_tro;
  public $lan_dang_nhap_cuoi;

  public function __construct($ma_nd, $ten_dang_nhap, $ho_ten, $email, $vai_tro = 0, $lan_dang_nhap_cuoi = null)
  {
    $this->ma_nd = $ma_nd;
    $this->ten_dang_nhap = $ten_dang_nhap;
    $this->ho_ten = $ho_ten;
    $this->email = $email;
    $this->vai_tro = $vai_tro;
    $this->lan_dang_nhap_cuoi = $lan_dang_nhap_cuoi;
  }

  public static function kiemTraDangNhap($ten_dang_nhap, $mat_khau)
  {
    $db = DB::getInstance();
    $stmt = $db->prepare('SELECT * FROM nguoi_dung WHERE ten_dang_nhap = ? AND mat_khau = ?');
    $stmt->execute([$ten_dang_nhap, $mat_khau]);
    $item = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($item) {
      $nguoiDung = new NguoiDung(
        $item['ma_nd'],
        $item['ten_dang_nhap'],
        $item['ho_ten'],
        $item['email'],
        $item['vai_tro'],
        $item['lan_dang_nhap_cuoi']
      );

      // Cập nhật lại thời gian đăng nhập mới nhất
      $stmtUpdate = $db->prepare('UPDATE nguoi_dung SET lan_dang_nhap_cuoi = NOW() WHERE ma_nd = ?');
      $stmtUpdate->execute([$item['ma_nd']]);

      return $nguoiDung;
    }
    return null;
  }

  public static function checkTonTai($ten_dang_nhap)
  {
    $db = DB::getInstance();
    $stmt = $db->prepare('SELECT * FROM nguoi_dung WHERE ten_dang_nhap = ?');
    $stmt->execute([$ten_dang_nhap]);
    return $stmt->fetch(PDO::FETCH_ASSOC) ? true : false;
  }

  public static function add($ten_dang_nhap, $mat_khau, $ho_ten, $email, $vai_tro = 0)
  {
    $db = DB::getInstance();
    $sql = "INSERT INTO nguoi_dung (ten_dang_nhap, mat_khau, ho_ten, email, vai_tro) VALUES (?, ?, ?, ?, ?)";
    $stmt = $db->prepare($sql);
    return $stmt->execute([$ten_dang_nhap, $mat_khau, $ho_ten, $email, $vai_tro]);
  }

  public static function getAll()
  {
    $list = [];
    $db = DB::getInstance();
    $result = $db->prepare('SELECT * FROM nguoi_dung');
    $result->setFetchMode(PDO::FETCH_ASSOC);
    $result->execute();
    foreach ($result->fetchAll() as $item) {
      $list[] = new NguoiDung(
        $item['ma_nd'],
        $item['ten_dang_nhap'],
        $item['ho_ten'],
        $item['email'],
        $item['vai_tro']
      );
    }
    return $list;
  }

  public static function getItem($id)
  {
    $db = DB::getInstance();
    $stmt = $db->prepare('SELECT * FROM nguoi_dung WHERE ma_nd = ?');
    $stmt->execute([$id]);
    $item = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($item) {
      return new NguoiDung(
        $item['ma_nd'],
        $item['ten_dang_nhap'],
        $item['ho_ten'],
        $item['email'],
        $item['vai_tro']
      );
    }
    return null;
  }

  public static function update($id, $ho_ten, $email, $vai_tro, $mat_khau = null)
  {
    $db = DB::getInstance();
    if ($mat_khau) {
      $sql = "UPDATE nguoi_dung SET ho_ten = ?, email = ?, vai_tro = ?, mat_khau = ? WHERE ma_nd = ?";
      $stmt = $db->prepare($sql);
      return $stmt->execute([$ho_ten, $email, $vai_tro, $mat_khau, $id]);
    } else {
      $sql = "UPDATE nguoi_dung SET ho_ten = ?, email = ?, vai_tro = ? WHERE ma_nd = ?";
      $stmt = $db->prepare($sql);
      return $stmt->execute([$ho_ten, $email, $vai_tro, $id]);
    }
  }

  public static function delete($id)
  {
    $db = DB::getInstance();
    $sql = "DELETE FROM nguoi_dung WHERE ma_nd = ?";
    $stmt = $db->prepare($sql);
    return $stmt->execute([$id]);
  }
}
