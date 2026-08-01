<?php
class Hoadon
{
  public $id;
  public $nha_cung_cap_id;
  public $loai_hoa_don;
  public $ky_cuoc;
  public $so_tien_can_dong;
  public $chi_so_tieu_thu; // Bổ sung để lưu số kWh điện, số khối nước...
  public $ngay_han_chot;
  public $trang_thai;
  public $ghi_chu_nen_tang;
  public $ngay_tao;
  public $ngay_cap_nhat;

  public function __construct($id, $nha_cung_cap_id, $loai_hoa_don, $ky_cuoc, $so_tien_can_dong, $chi_so_tieu_thu, $ngay_han_chot, $trang_thai, $ghi_chu_nen_tang, $ngay_tao, $ngay_cap_nhat)
  {
    $this->id = $id;
    $this->nha_cung_cap_id = $nha_cung_cap_id;
    $this->loai_hoa_don = $loai_hoa_don;
    $this->ky_cuoc = $ky_cuoc;
    $this->so_tien_can_dong = $so_tien_can_dong;
    $this->chi_so_tieu_thu = $chi_so_tieu_thu;
    $this->ngay_han_chot = $ngay_han_chot;
    $this->trang_thai = $trang_thai;
    $this->ghi_chu_nen_tang = $ghi_chu_nen_tang;
    $this->ngay_tao = $ngay_tao;
    $this->ngay_cap_nhat = $ngay_cap_nhat;
  }

  static function getAll($tu_ngay = null, $den_ngay = null, $nha_cung_cap_id = null)
  {
    $list = [];
    $db = DB::getInstance();
    
    $sql = 'SELECT * FROM hoa_don WHERE 1=1';
    $params = [];

    if (!empty($tu_ngay)) {
        $sql .= ' AND ngay_tao >= ?';
        $params[] = $tu_ngay . ' 00:00:00';
    }
    
    if (!empty($den_ngay)) {
        $sql .= ' AND ngay_tao <= ?';
        $params[] = $den_ngay . ' 23:59:59';
    }
    
    if (!empty($nha_cung_cap_id)) {
        $sql .= ' AND nha_cung_cap_id = ?';
        $params[] = $nha_cung_cap_id;
    }

    $sql .= ' ORDER BY ngay_tao DESC';
    
    $stmt = $db->prepare($sql);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $stmt->execute($params);

    foreach ($stmt->fetchAll() as $item) {
      $list[] = new Hoadon(
        $item['id'],
        $item['nha_cung_cap_id'],
        $item['loai_hoa_don'],
        $item['ky_cuoc'],
        $item['so_tien_can_dong'],
        $item['chi_so_tieu_thu'],
        $item['ngay_han_chot'],
        $item['trang_thai'],
        $item['ghi_chu_nen_tang'],
        $item['ngay_tao'],
        $item['ngay_cap_nhat']
      );
    }

    return $list;
  }

  public static function getItem($id)
  {
    $db = DB::getInstance();
    $stmt = $db->prepare('SELECT * FROM hoa_don WHERE id = ?');
    $stmt->execute([$id]);
    $item = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($item) {
      return new Hoadon(
        $item['id'],
        $item['nha_cung_cap_id'],
        $item['loai_hoa_don'],
        $item['ky_cuoc'],
        $item['so_tien_can_dong'],
        $item['chi_so_tieu_thu'],
        $item['ngay_han_chot'],
        $item['trang_thai'],
        $item['ghi_chu_nen_tang'],
        $item['ngay_tao'],
        $item['ngay_cap_nhat']
      );
    }
    return null;
  }

  // Hàm cập nhật (bao gồm cập nhật thanh toán và ghi chú giao dịch)
  public static function update($id, $nha_cung_cap_id, $loai_hoa_don, $ky_cuoc, $so_tien_can_dong, $chi_so_tieu_thu, $ngay_han_chot, $trang_thai, $ghi_chu_nen_tang)
  {
    $db = DB::getInstance();
    $sql = "UPDATE hoa_don 
                SET nha_cung_cap_id = ?, loai_hoa_don = ?, ky_cuoc = ?, so_tien_can_dong = ?, chi_so_tieu_thu = ?, ngay_han_chot = ?, trang_thai = ?, ghi_chu_nen_tang = ?, ngay_cap_nhat = NOW() 
                WHERE id = ?";

    $stmt = $db->prepare($sql);

    return $stmt->execute([
      $nha_cung_cap_id,
      $loai_hoa_don,
      $ky_cuoc,
      $so_tien_can_dong,
      $chi_so_tieu_thu,
      $ngay_han_chot,
      $trang_thai,
      $ghi_chu_nen_tang,
      $id
    ]);
  }

  public static function delete($id)
  {
    $db = DB::getInstance();
    $sql = "DELETE FROM hoa_don WHERE id = ?";
    $stmt = $db->prepare($sql);

    return $stmt->execute([$id]);
  }

  // Hàm thêm hóa đơn mới (tự động lấy ngày hiện tại cho ngay_tao và ngay_cap_nhat)
  public static function add($nha_cung_cap_id, $loai_hoa_don, $ky_cuoc, $so_tien_can_dong, $chi_so_tieu_thu, $ngay_han_chot, $trang_thai)
  {
    $db = DB::getInstance();
    $sql = "INSERT INTO hoa_don (nha_cung_cap_id, loai_hoa_don, ky_cuoc, so_tien_can_dong, chi_so_tieu_thu, ngay_han_chot, trang_thai, ngay_tao, ngay_cap_nhat) 
                VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), NOW())";

    $stmt = $db->prepare($sql);
    return $stmt->execute([
      $nha_cung_cap_id,
      $loai_hoa_don,
      $ky_cuoc,
      $so_tien_can_dong,
      $chi_so_tieu_thu,
      $ngay_han_chot,
      $trang_thai
    ]);
  }
  /**
   * Đếm tổng số hóa đơn dựa theo ID nhà cung cấp
   */
  public static function countByNhaCungCapId($id)
  {
    $db = DB::getInstance();
    $sql = "SELECT COUNT(*) FROM hoa_don WHERE nha_cung_cap_id = ?";
    $stmt = $db->prepare($sql);

    $stmt->execute([$id]);

    // fetchColumn() trả về giá trị của cột đầu tiên (chính là kết quả của COUNT)
    return $stmt->fetchColumn();
  }

  // Lấy các hóa đơn sắp đến hạn (còn <= 7 ngày) và chưa thanh toán
  public static function getCanhBaoDenHan()
  {
    $list = [];
    $db = DB::getInstance();
    $sql = "SELECT * FROM hoa_don 
            WHERE trang_thai = 0 
            AND ngay_han_chot >= NOW() 
            AND ngay_han_chot <= DATE_ADD(NOW(), INTERVAL 7 DAY)
            ORDER BY ngay_han_chot ASC";
    $result = $db->prepare($sql);
    $result->execute();

    foreach ($result->fetchAll(PDO::FETCH_ASSOC) as $item) {
      $list[] = new Hoadon(
        $item['id'],
        $item['nha_cung_cap_id'],
        $item['loai_hoa_don'],
        $item['ky_cuoc'],
        $item['so_tien_can_dong'],
        $item['chi_so_tieu_thu'],
        $item['ngay_han_chot'],
        $item['trang_thai'],
        $item['ghi_chu_nen_tang'],
        $item['ngay_tao'],
        $item['ngay_cap_nhat']
      );
    }
    return $list;
  }

  // Thống kê theo tháng
  public static function getThongKeTheoThang()
  {
    $db = DB::getInstance();
    $sql = "SELECT DATE_FORMAT(ngay_tao, '%m/%Y') as thang, 
                   SUM(so_tien_can_dong) as tong_tien 
            FROM hoa_don 
            GROUP BY thang
            ORDER BY MIN(ngay_tao) ASC";
    $result = $db->prepare($sql);
    $result->execute();
    return $result->fetchAll(PDO::FETCH_ASSOC);
  }
}
