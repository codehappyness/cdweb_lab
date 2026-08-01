<?php
class ChungTu
{
  public $id;
  public $hoa_don_id;
  public $loai_chung_tu;
  public $ngay_tai_len;
  public $duong_dan_anh;

  public function __construct($id, $hoa_don_id, $loai_chung_tu, $ngay_tai_len, $duong_dan_anh)
  {
    $this->id = $id;
    $this->hoa_don_id = $hoa_don_id;
    $this->loai_chung_tu = $loai_chung_tu;
    $this->ngay_tai_len = $ngay_tai_len;
    $this->duong_dan_anh = $duong_dan_anh;
  }

  public static function getByHoaDonId($hoa_don_id)
  {
    $db = DB::getInstance();
    $stmt = $db->prepare('SELECT * FROM chung_tu_dien_tu WHERE hoa_don_id = ?');
    $stmt->execute([$hoa_don_id]);
    $item = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($item) {
      return new ChungTu(
        $item['id'],
        $item['hoa_don_id'],
        $item['loai_chung_tu'],
        $item['ngay_tai_len'],
        $item['duong_dan_anh']
      );
    }
    return null;
  }

  public static function add($hoa_don_id, $loai_chung_tu, $duong_dan_anh)
  {
    $db = DB::getInstance();
    $sql = "INSERT INTO chung_tu_dien_tu (hoa_don_id, loai_chung_tu, ngay_tai_len, duong_dan_anh) 
            VALUES (?, ?, NOW(), ?)
            ON DUPLICATE KEY UPDATE loai_chung_tu = VALUES(loai_chung_tu), ngay_tai_len = VALUES(ngay_tai_len), duong_dan_anh = VALUES(duong_dan_anh)";
    $stmt = $db->prepare($sql);
    return $stmt->execute([$hoa_don_id, $loai_chung_tu, $duong_dan_anh]);
  }
}
?>
