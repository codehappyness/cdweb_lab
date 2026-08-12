<?php
class NhaCungCap
{
  public $id;
  public $ten;
  public $dia_chi;
  public $so_dien_thoai;
  public $nguoi_dung_id;

  public function __construct($id, $ten, $dia_chi, $so_dien_thoai, $nguoi_dung_id = 0)
  {
    $this->id = $id;
    $this->ten = $ten;
    $this->dia_chi = $dia_chi;
    $this->so_dien_thoai = $so_dien_thoai;
    $this->nguoi_dung_id = $nguoi_dung_id;
  }

  static function getAll($user_id = null)
  {
    $list = [];
    $db = DB::getInstance();
    
    if ($user_id !== null) {
      $result = $db->prepare('SELECT * FROM nha_cung_cap WHERE nguoi_dung_id = ?');
      $result->execute([$user_id]);
    } else {
      $result = $db->prepare('SELECT * FROM nha_cung_cap');
      $result->execute();
    }
    
    $result->setFetchMode(PDO::FETCH_ASSOC);
    foreach ($result->fetchAll() as $item) {
      $list[] = new NhaCungCap(
        $item['id'],
        $item['ten'],
        $item['dia_chi'],
        $item['so_dien_thoai'],
        $item['nguoi_dung_id']
      );
    }
    return $list;
  }

  public static function getItem($id, $user_id = null)
  {
    $db = DB::getInstance();
    $sql = 'SELECT * FROM nha_cung_cap WHERE id = ?';
    $params = [$id];
    
    if ($user_id !== null) {
      $sql .= ' AND nguoi_dung_id = ?';
      $params[] = $user_id;
    }
    
    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    $item = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($item) {
      return new NhaCungCap(
        $item['id'],
        $item['ten'],
        $item['dia_chi'],
        $item['so_dien_thoai'],
        $item['nguoi_dung_id']
      );
    }
    return null;
  }

  public static function update($id, $ten, $dia_chi, $so_dien_thoai)
  {
    $db = DB::getInstance();
    $sql = "UPDATE nha_cung_cap 
            SET ten = ?, dia_chi = ?, so_dien_thoai = ? 
            WHERE id = ?";

    $stmt = $db->prepare($sql);
    return $stmt->execute([$ten, $dia_chi, $so_dien_thoai, $id]);
  }

  public static function delete($id, $user_id = null)
  {
    $db = DB::getInstance();
    $sql = "DELETE FROM nha_cung_cap WHERE id = ?";
    $params = [$id];
    
    if ($user_id !== null) {
      $sql .= " AND nguoi_dung_id = ?";
      $params[] = $user_id;
    }
    
    $stmt = $db->prepare($sql);
    return $stmt->execute($params);
  }

  public static function add($ten, $dia_chi, $so_dien_thoai, $nguoi_dung_id = 0)
  {
    $db = DB::getInstance();
    $sql = "INSERT INTO nha_cung_cap (ten, dia_chi, so_dien_thoai, nguoi_dung_id) 
            VALUES (?, ?, ?, ?)";
    $stmt = $db->prepare($sql);
    return $stmt->execute([$ten, $dia_chi, $so_dien_thoai, $nguoi_dung_id]);
  }

  public static function hasDichVuOrHoaDon($id, $user_id)
  {
    $db = DB::getInstance();
    // Check DichVu
    $req = $db->prepare('SELECT COUNT(*) as count FROM dich_vu WHERE nha_cung_cap_id = :id AND nguoi_dung_id = :user_id');
    $req->execute(array('id' => $id, 'user_id' => $user_id));
    $resDV = $req->fetch();
    if ($resDV['count'] > 0) return true;

    // Check HoaDon
    $req2 = $db->prepare('SELECT COUNT(*) as count FROM hoa_don WHERE nha_cung_cap_id = :id AND nguoi_dung_id = :user_id');
    $req2->execute(array('id' => $id, 'user_id' => $user_id));
    $resHD = $req2->fetch();
    if ($resHD['count'] > 0) return true;

    return false;
  }
}
