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
    // Đã bổ sung gán đầy đủ các thuộc tính
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
    // 1. Sửa 'WHER' thành 'WHERE'
    $stmt = $db->prepare('SELECT * FROM nha_cung_cap WHERE id = ?');

    // 2. Truyền tham số $id vào hàm execute
    $stmt->execute([$id]);

    // Lấy ra 1 dòng dữ liệu duy nhất
    $item = $stmt->fetch(PDO::FETCH_ASSOC);

    // 3. Kiểm tra xem có dữ liệu hay không
    if ($item) {
      return new NhaCungCap(
        $item['id'],
        $item['ten'],
        $item['loai_dich_vu'],
        $item['dia_chi'],
        $item['so_dien_thoai']
      );
    }
    // Trả về null nếu không tìm thấy nhà cung cấp nào với ID này
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

    // Câu lệnh SQL INSERT (Bỏ qua cột id vì nó tự động tăng)
    $sql = "INSERT INTO nha_cung_cap (ten, loai_dich_vu, dia_chi, so_dien_thoai) 
            VALUES (?, ?, ?, ?)";

    $stmt = $db->prepare($sql);

    // Thực thi và truyền các tham số tương ứng với 4 dấu ?
    return $stmt->execute([
      $ten,
      $loai_dich_vu,
      $dia_chi,
      $so_dien_thoai
    ]);
  }
}
