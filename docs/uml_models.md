# BỘ BIỂU ĐỒ UML HỆ THỐNG QUẢN LÝ CHI TIÊU VÀ TIỆN ÍCH CÁ NHÂN

Dựa trên hệ thống thực tế đã được xây dựng, dưới đây là bộ biểu đồ UML chuẩn hóa.

## 1. Biểu đồ Use Case (Use Case Diagram)
Mô tả các chức năng mà các tác nhân (Actor) có thể thực hiện trên hệ thống. 

```plantuml
@startuml
left to right direction
actor "Người dùng (User)" as User
actor "Quản trị viên (Admin)" as Admin

package "Hệ thống Quản lý Chi tiêu" {
  usecase "Đăng ký tài khoản" as UC1
  usecase "Đăng nhập" as UC2
  usecase "Quản lý Hồ sơ cá nhân" as UC3
  usecase "Quản lý Nhà cung cấp" as UC4
  usecase "Quản lý Dịch vụ" as UC5
  usecase "Quản lý Hóa đơn" as UC6
  usecase "Thanh toán & Tải chứng từ" as UC7
  usecase "Xem Thống kê & Báo cáo" as UC8
  usecase "Quản lý Tài khoản Hệ thống" as UC9
}

User --> UC1
User --> UC2
User --> UC3
User --> UC4
User --> UC5
User --> UC6
User --> UC7
User --> UC8

Admin --> UC2
Admin --> UC3
Admin --> UC9

UC7 .> UC6 : <<extend>>
UC4 .> UC2 : <<include>>
UC5 .> UC2 : <<include>>
UC6 .> UC2 : <<include>>
UC8 .> UC2 : <<include>>
@enduml
```

---

## 2. Biểu đồ Lớp / Thực thể (Class / ER Diagram)
Mô tả cấu trúc dữ liệu vật lý và các mối quan hệ (Primary Key / Foreign Key) giữa các bảng trong MySQL. Hệ thống thiết kế theo hướng Multi-tenant (mọi dữ liệu đều gắn với `nguoi_dung_id`).

```plantuml
@startuml
entity "NGUOI_DUNG" as NGUOI_DUNG {
  *id : bigint <<PK>>
  --
  ten_dang_nhap : varchar
  mat_khau : varchar
  ho_ten : varchar
  email : varchar
  vai_tro : tinyint
  lan_dang_nhap_cuoi : datetime
}

entity "NHA_CUNG_CAP" as NHA_CUNG_CAP {
  *id : bigint <<PK>>
  --
  ten : varchar
  dia_chi : varchar
  so_dien_thoai : varchar
  nguoi_dung_id : bigint <<FK>>
}

entity "DICH_VU" as DICH_VU {
  *id : bigint <<PK>>
  --
  ten_dich_vu : varchar
  mo_ta : text
  nha_cung_cap_id : bigint <<FK>>
  nguoi_dung_id : bigint <<FK>>
}

entity "HOA_DON" as HOA_DON {
  *id : bigint <<PK>>
  --
  loai_hoa_don : tinyint
  ky_cuoc : varchar
  so_tien_can_dong : float
  chi_so_tieu_thu : varchar
  ngay_han_chot : datetime
  trang_thai : varchar
  dich_vu_id : bigint <<FK>>
  nha_cung_cap_id : bigint <<FK>>
  nguoi_dung_id : bigint <<FK>>
}

entity "CHUNG_TU_DIEN_TU" as CHUNG_TU_DIEN_TU {
  *id : bigint <<PK>>
  --
  loai_chung_tu : varchar
  duong_dan_file : varchar
  ngay_tai_len : datetime
  hoa_don_id : bigint <<FK>> <<Unique>>
}

NGUOI_DUNG ||--o{ NHA_CUNG_CAP : "Quản lý"
NGUOI_DUNG ||--o{ DICH_VU : "Quản lý"
NGUOI_DUNG ||--o{ HOA_DON : "Sở hữu"

NHA_CUNG_CAP ||--o{ DICH_VU : "Cung cấp"
NHA_CUNG_CAP ||--o{ HOA_DON : "Thuộc về"

DICH_VU ||--o{ HOA_DON : "Phát sinh"
HOA_DON ||--o| CHUNG_TU_DIEN_TU : "Có (tối đa 1)"
@enduml
```

---

## 3. Biểu đồ Hoạt động (Activity Diagram)

### 3.1. Luồng cập nhật trạng thái Hóa đơn & Upload Chứng từ
Mô phỏng chi tiết hành động khi người dùng thực hiện thanh toán một hóa đơn định kỳ.

```plantuml
@startuml
start
:Người dùng chọn Hóa đơn chưa thanh toán;
:Nhấn nút 'Cập nhật Thanh toán';
if (Xác nhận số tiền?) then (Không)
  stop
else (Có)
  :Hệ thống chuyển trạng thái Hóa đơn thành 'Đã thanh toán';
  if (Người dùng có Upload biên lai không?) then (Không)
    stop
  else (Có)
    repeat
      :Người dùng chọn File hình ảnh/PDF;
      :Hệ thống kiểm tra định dạng và dung lượng;
      if (Hợp lệ?) then (Không)
        :Báo lỗi File không hợp lệ;
      else (Có)
        :Lưu File vào thư mục resource/assets/uploads/;
        :Ghi thông tin đường dẫn vào bảng chung_tu_dien_tu;
        stop
      endif
    repeat while (File không hợp lệ?)
  endif
endif
@enduml
```

### 3.2. Luồng xem Thống kê & Biểu đồ (Dashboard)
Mô phỏng logic xử lý khi người dùng vào trang chủ hoặc tiến hành lọc tháng.

```plantuml
@startuml
start
:Mở Dashboard;
:Controller lấy thông tin User đang đăng nhập;
:Truy vấn tổng số Hóa đơn chưa thanh toán & Tổng tiền;
:Lấy danh sách các Hóa đơn sắp/đã quá hạn chót;
if (Người dùng có chọn Tháng lọc không?) then (Không chọn)
  :Lấy tổng tiền các hóa đơn gom nhóm theo Kỳ cước;
  :Vẽ Biểu đồ Cột - Bar Chart so sánh chi phí theo tháng;
else (Chọn 1 tháng cụ thể)
  :Lấy tổng tiền các hóa đơn trong tháng đó, gom nhóm theo Dịch vụ;
  :Vẽ Biểu đồ Tròn - Pie Chart thể hiện cơ cấu chi phí;
endif
:Render giao diện Trang chủ hoàn chỉnh;
stop
@enduml
```
