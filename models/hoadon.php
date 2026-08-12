<?php
class Hoadon
{
  public $id;
  public $nha_cung_cap_id;
  public $dich_vu_id;
  public $nguoi_dung_id;
  public $loai_hoa_don;
  public $ky_cuoc;
  public $so_tien_can_dong;
  public $chi_so_tieu_thu;
  public $ngay_han_chot;
  public $trang_thai;
  public $ghi_chu_nen_tang;
  public $ngay_tao;
  public $ngay_cap_nhat;

  public function __construct($id, $nha_cung_cap_id, $dich_vu_id, $nguoi_dung_id, $loai_hoa_don, $ky_cuoc, $so_tien_can_dong, $chi_so_tieu_thu, $ngay_han_chot, $trang_thai, $ghi_chu_nen_tang, $ngay_tao, $ngay_cap_nhat)
  {
    $this->id = $id;
    $this->nha_cung_cap_id = $nha_cung_cap_id;
    $this->dich_vu_id = $dich_vu_id;
    $this->nguoi_dung_id = $nguoi_dung_id;
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

  static function getAll($tu_ngay = null, $den_ngay = null, $nha_cung_cap_id = null, $nguoi_dung_id = null)
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

    if (!empty($nguoi_dung_id)) {
        $sql .= ' AND nguoi_dung_id = ?';
        $params[] = $nguoi_dung_id;
    }

    $sql .= ' ORDER BY ngay_tao DESC';
    
    $stmt = $db->prepare($sql);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $stmt->execute($params);

    foreach ($stmt->fetchAll() as $item) {
      $list[] = new Hoadon(
        $item['id'],
        $item['nha_cung_cap_id'],
        $item['dich_vu_id'],
        $item['nguoi_dung_id'],
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

  public static function getItem($id, $nguoi_dung_id = null)
  {
    $db = DB::getInstance();
    
    $sql = 'SELECT * FROM hoa_don WHERE id = ?';
    $params = [$id];
    
    if (!empty($nguoi_dung_id)) {
      $sql .= ' AND nguoi_dung_id = ?';
      $params[] = $nguoi_dung_id;
    }

    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    $item = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($item) {
      return new Hoadon(
        $item['id'],
        $item['nha_cung_cap_id'],
        $item['dich_vu_id'],
        $item['nguoi_dung_id'],
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

  public static function update($id, $nha_cung_cap_id, $dich_vu_id, $nguoi_dung_id, $loai_hoa_don, $ky_cuoc, $so_tien_can_dong, $chi_so_tieu_thu, $ngay_han_chot, $trang_thai, $ghi_chu_nen_tang)
  {
    $db = DB::getInstance();
    $sql = "UPDATE hoa_don 
                SET nha_cung_cap_id = ?, dich_vu_id = ?, loai_hoa_don = ?, ky_cuoc = ?, so_tien_can_dong = ?, chi_so_tieu_thu = ?, ngay_han_chot = ?, trang_thai = ?, ghi_chu_nen_tang = ?, ngay_cap_nhat = NOW() 
                WHERE id = ? AND nguoi_dung_id = ?";

    $stmt = $db->prepare($sql);

    return $stmt->execute([
      $nha_cung_cap_id,
      $dich_vu_id,
      $loai_hoa_don,
      $ky_cuoc,
      $so_tien_can_dong,
      $chi_so_tieu_thu,
      $ngay_han_chot,
      $trang_thai,
      $ghi_chu_nen_tang,
      $id,
      $nguoi_dung_id
    ]);
  }

  public static function delete($id, $nguoi_dung_id = null)
  {
    $db = DB::getInstance();
    $sql = "DELETE FROM hoa_don WHERE id = ?";
    $params = [$id];
    
    if (!empty($nguoi_dung_id)) {
      $sql .= " AND nguoi_dung_id = ?";
      $params[] = $nguoi_dung_id;
    }

    $stmt = $db->prepare($sql);
    return $stmt->execute($params);
  }

  public static function add($nha_cung_cap_id, $dich_vu_id, $nguoi_dung_id, $loai_hoa_don, $ky_cuoc, $so_tien_can_dong, $chi_so_tieu_thu, $ngay_han_chot, $trang_thai)
  {
    $db = DB::getInstance();
    $sql = "INSERT INTO hoa_don (nha_cung_cap_id, dich_vu_id, nguoi_dung_id, loai_hoa_don, ky_cuoc, so_tien_can_dong, chi_so_tieu_thu, ngay_han_chot, trang_thai, ngay_tao, ngay_cap_nhat) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())";

    $stmt = $db->prepare($sql);
    return $stmt->execute([
      $nha_cung_cap_id,
      $dich_vu_id,
      $nguoi_dung_id,
      $loai_hoa_don,
      $ky_cuoc,
      $so_tien_can_dong,
      $chi_so_tieu_thu,
      $ngay_han_chot,
      $trang_thai
    ]);
  }
  
  public static function countByNhaCungCapId($id)
  {
    $db = DB::getInstance();
    $sql = "SELECT COUNT(*) FROM hoa_don WHERE nha_cung_cap_id = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$id]);
    return $stmt->fetchColumn();
  }

  public static function countByDichVuId($id)
  {
    $db = DB::getInstance();
    $sql = "SELECT COUNT(*) FROM hoa_don WHERE dich_vu_id = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$id]);
    return $stmt->fetchColumn();
  }

  public static function getCanhBaoDenHan($nguoi_dung_id = null)
  {
    $list = [];
    $db = DB::getInstance();
    $sql = "SELECT * FROM hoa_don 
            WHERE trang_thai = 0 
            AND ngay_han_chot >= NOW() 
            AND ngay_han_chot <= DATE_ADD(NOW(), INTERVAL 7 DAY)";
    $params = [];
    if (!empty($nguoi_dung_id)) {
      $sql .= " AND nguoi_dung_id = ?";
      $params[] = $nguoi_dung_id;
    }
    $sql .= " ORDER BY ngay_han_chot ASC";
    
    $result = $db->prepare($sql);
    $result->execute($params);

    foreach ($result->fetchAll(PDO::FETCH_ASSOC) as $item) {
      $list[] = new Hoadon(
        $item['id'],
        $item['nha_cung_cap_id'],
        $item['dich_vu_id'],
        $item['nguoi_dung_id'],
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

  public static function getChuaThanhToanSummary($nguoi_dung_id = null)
  {
    $db = DB::getInstance();
    $sql = "SELECT COUNT(*) as so_luong, SUM(so_tien_can_dong) as tong_tien FROM hoa_don WHERE trang_thai = 0";
    $params = [];
    if (!empty($nguoi_dung_id)) {
      $sql .= " AND nguoi_dung_id = ?";
      $params[] = $nguoi_dung_id;
    }
    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    $res = $stmt->fetch(PDO::FETCH_ASSOC);
    return [
      'so_luong' => $res['so_luong'] ?? 0,
      'tong_tien' => $res['tong_tien'] ?? 0
    ];
  }

  public static function getThongKeTheoThang($nguoi_dung_id = null)
  {
    $db = DB::getInstance();
    $sql = "SELECT ky_cuoc as thang, 
                   SUM(so_tien_can_dong) as tong_tien 
            FROM hoa_don 
            WHERE 1=1";
    $params = [];
    if (!empty($nguoi_dung_id)) {
      $sql .= " AND nguoi_dung_id = ?";
      $params[] = $nguoi_dung_id;
    }
    $sql .= " GROUP BY ky_cuoc ORDER BY RIGHT(ky_cuoc, 4) ASC, LEFT(ky_cuoc, 2) ASC";
            
    $result = $db->prepare($sql);
    $result->execute($params);
    return $result->fetchAll(PDO::FETCH_ASSOC);
  }

  public static function getThongKeDichVuTheoThang($thang, $nguoi_dung_id = null)
  {
    // $thang từ form là định dạng YYYY-MM. Cần chuyển thành MM/YYYY để khớp với ky_cuoc.
    $ky_cuoc_format = date('m/Y', strtotime($thang . '-01'));

    $db = DB::getInstance();
    $sql = "SELECT d.ten_dich_vu, SUM(h.so_tien_can_dong) as tong_tien 
            FROM hoa_don h
            JOIN dich_vu d ON h.dich_vu_id = d.id
            WHERE h.ky_cuoc = ?";
    $params = [$ky_cuoc_format];
    if (!empty($nguoi_dung_id)) {
      $sql .= " AND h.nguoi_dung_id = ?";
      $params[] = $nguoi_dung_id;
    }
    $sql .= " GROUP BY d.id";
            
    $result = $db->prepare($sql);
    $result->execute($params);
    return $result->fetchAll(PDO::FETCH_ASSOC);
  }
}
