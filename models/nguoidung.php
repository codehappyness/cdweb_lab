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
    $db->beginTransaction();
    try {
      // 1. Lấy danh sách file chứng từ để xóa vật lý trên server
      $stmt = $db->prepare("SELECT duong_dan_file FROM chung_tu_dien_tu WHERE hoa_don_id IN (SELECT id FROM hoa_don WHERE nguoi_dung_id = ?)");
      $stmt->execute([$id]);
      $files = $stmt->fetchAll(PDO::FETCH_ASSOC);
      foreach ($files as $file) {
        if (!empty($file['duong_dan_file']) && file_exists($file['duong_dan_file'])) {
          unlink($file['duong_dan_file']);
        }
      }

      // 2. Xóa chứng từ điện tử trong Database
      $db->prepare("DELETE FROM chung_tu_dien_tu WHERE hoa_don_id IN (SELECT id FROM hoa_don WHERE nguoi_dung_id = ?)")->execute([$id]);

      // 3. Xóa các hóa đơn
      $db->prepare("DELETE FROM hoa_don WHERE nguoi_dung_id = ?")->execute([$id]);

      // 4. Xóa các dịch vụ
      $db->prepare("DELETE FROM dich_vu WHERE nguoi_dung_id = ?")->execute([$id]);

      // 5. Xóa các nhà cung cấp
      $db->prepare("DELETE FROM nha_cung_cap WHERE nguoi_dung_id = ?")->execute([$id]);

      // 6. Xóa tài khoản người dùng
      $sql = "DELETE FROM nguoi_dung WHERE ma_nd = ?";
      $stmt = $db->prepare($sql);
      $result = $stmt->execute([$id]);

      $db->commit();
      return $result;
    } catch (Exception $e) {
      $db->rollBack();
      return false;
    }
  }
}
