<?php
class NhaCungCap
{
  public $id;
  public $ten;
  public $loai_dich_vu;
  public $dia_chi;
  public $so_dien_thoai;

  public function __construct($id, $ten, $loai_dich_vu, $dia_chi, $so_dien_thoai)
  {
    $this->id = $id;
    $this->ten = $ten;
    $this->loai_dich_vu = $loai_dich_vu;
    $this->dia_chi = $dia_chi;
    $this->so_dien_thoai = $so_dien_thoai;
  }

  static function getAll()
  {
    $list = [];
    $db = DB::getInstance();
    $result = $db->prepare('SELECT * FROM nha_cung_cap');
    $result->setFetchMode(PDO::FETCH_ASSOC);
    $result->execute();
    foreach ($result->fetchAll() as $item) {
      $list[] = new NhaCungCap(
        $item['id'],
        $item['ten'],
        $item['loai_dich_vu'],
        $item['dia_chi'],
        $item['so_dien_thoai']
      );
    }

    return $list;
  }

  public static function getItem($id)
  {
    $db = DB::getInstance();
    $stmt = $db->prepare('SELECT * FROM nha_cung_cap WHERE id = ?');
    $stmt->execute([$id]);
    $item = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($item) {
      return new NhaCungCap(
        $item['id'],
        $item['ten'],
        $item['loai_dich_vu'],
        $item['dia_chi'],
        $item['so_dien_thoai']
      );
    }
    return null;
  }

  public static function update($id, $ten, $loai_dich_vu, $dia_chi, $so_dien_thoai)
  {
    $db = DB::getInstance();
    $sql = "UPDATE nha_cung_cap 
            SET ten = ?, loai_dich_vu = ?, dia_chi = ?, so_dien_thoai = ? 
            WHERE id = ?";

    $stmt = $db->prepare($sql);

    return $stmt->execute([
      $ten,
      $loai_dich_vu,
      $dia_chi,
      $so_dien_thoai,
      $id
    ]);
  }

  public static function delete($id)
  {
    $db = DB::getInstance();
    $sql = "DELETE FROM nha_cung_cap WHERE id = ?";
    $stmt = $db->prepare($sql);
    

    return $stmt->execute([$id]);
  }

  public static function add($ten, $loai_dich_vu, $dia_chi, $so_dien_thoai)
  {
    $db = DB::getInstance();
    $sql = "INSERT INTO nha_cung_cap (ten, loai_dich_vu, dia_chi, so_dien_thoai) 
            VALUES (?, ?, ?, ?)";
    $stmt = $db->prepare($sql);
    return $stmt->execute([
      $ten,
      $loai_dich_vu,
      $dia_chi,
      $so_dien_thoai
    ]);
  }
}
