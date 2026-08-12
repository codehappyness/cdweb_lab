<?php
class DichVu
{
  public $id;
  public $ten_dich_vu;
  public $mo_ta;
  public $nha_cung_cap_id;
  public $nguoi_dung_id;

  // Add virtual property to hold provider name for display
  public $ten_nha_cung_cap;

  public function __construct($id, $ten_dich_vu, $mo_ta, $nha_cung_cap_id, $nguoi_dung_id = 0, $ten_nha_cung_cap = '')
  {
    $this->id = $id;
    $this->ten_dich_vu = $ten_dich_vu;
    $this->mo_ta = $mo_ta;
    $this->nha_cung_cap_id = $nha_cung_cap_id;
    $this->nguoi_dung_id = $nguoi_dung_id;
    $this->ten_nha_cung_cap = $ten_nha_cung_cap;
  }

  static function getAll($user_id = null)
  {
    $list = [];
    $db = DB::getInstance();
    
    $query = 'SELECT d.*, n.ten AS ten_nha_cung_cap 
              FROM dich_vu d 
              LEFT JOIN nha_cung_cap n ON d.nha_cung_cap_id = n.id';
              
    if ($user_id !== null) {
      $query .= ' WHERE d.nguoi_dung_id = ?';
      $result = $db->prepare($query);
      $result->execute([$user_id]);
    } else {
      $result = $db->prepare($query);
      $result->execute();
    }
    
    $result->setFetchMode(PDO::FETCH_ASSOC);
    foreach ($result->fetchAll() as $item) {
      $list[] = new DichVu(
        $item['id'],
        $item['ten_dich_vu'],
        $item['mo_ta'],
        $item['nha_cung_cap_id'],
        $item['nguoi_dung_id'],
        $item['ten_nha_cung_cap']
      );
    }
    return $list;
  }
  
  static function getByNhaCungCapId($nha_cung_cap_id)
  {
    $list = [];
    $db = DB::getInstance();
    $result = $db->prepare('SELECT * FROM dich_vu WHERE nha_cung_cap_id = ?');
    $result->execute([$nha_cung_cap_id]);
    $result->setFetchMode(PDO::FETCH_ASSOC);
    foreach ($result->fetchAll() as $item) {
      $list[] = new DichVu(
        $item['id'],
        $item['ten_dich_vu'],
        $item['mo_ta'],
        $item['nha_cung_cap_id'],
        $item['nguoi_dung_id']
      );
    }
    return $list;
  }

  public static function getItem($id, $user_id = null)
  {
    $db = DB::getInstance();
    $sql = 'SELECT d.*, n.ten AS ten_nha_cung_cap FROM dich_vu d LEFT JOIN nha_cung_cap n ON d.nha_cung_cap_id = n.id WHERE d.id = ?';
    $params = [$id];
    
    if ($user_id !== null) {
      $sql .= ' AND d.nguoi_dung_id = ?';
      $params[] = $user_id;
    }

    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    $item = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($item) {
      return new DichVu(
        $item['id'],
        $item['ten_dich_vu'],
        $item['mo_ta'],
        $item['nha_cung_cap_id'],
        $item['nguoi_dung_id'],
        $item['ten_nha_cung_cap']
      );
    }
    return null;
  }

  public static function update($id, $ten_dich_vu, $mo_ta, $nha_cung_cap_id)
  {
    $db = DB::getInstance();
    $sql = "UPDATE dich_vu 
            SET ten_dich_vu = ?, mo_ta = ?, nha_cung_cap_id = ? 
            WHERE id = ?";
    $stmt = $db->prepare($sql);
    return $stmt->execute([$ten_dich_vu, $mo_ta, $nha_cung_cap_id, $id]);
  }

  public static function delete($id, $user_id = null)
  {
    $db = DB::getInstance();
    $sql = "DELETE FROM dich_vu WHERE id = ?";
    $params = [$id];

    if ($user_id !== null) {
      $sql .= " AND nguoi_dung_id = ?";
      $params[] = $user_id;
    }

    $stmt = $db->prepare($sql);
    return $stmt->execute($params);
  }

  public static function add($ten_dich_vu, $mo_ta, $nha_cung_cap_id, $nguoi_dung_id = 0)
  {
    $db = DB::getInstance();
    $sql = "INSERT INTO dich_vu (ten_dich_vu, mo_ta, nha_cung_cap_id, nguoi_dung_id) 
            VALUES (?, ?, ?, ?)";
    $stmt = $db->prepare($sql);
    return $stmt->execute([$ten_dich_vu, $mo_ta, $nha_cung_cap_id, $nguoi_dung_id]);
  }
}
