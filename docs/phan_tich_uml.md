# Phân tích UML: Hệ thống Quản lý Chi tiêu và Tiện ích cá nhân

Tài liệu này chứa các phân tích thiết kế hệ thống dựa trên yêu cầu tính năng cốt lõi và kiến trúc PHP MVC.

## 1. Biểu đồ Use Case (Mô hình tính năng)
Thể hiện tương tác của người dùng với các tính năng của hệ thống.

```plantuml
@startuml
left to right direction
skinparam packageStyle rectangle

actor "Người dùng" as user

rectangle "Hệ thống Quản lý Chi tiêu và Tiện ích" {
  usecase "1. Quản lý danh mục dịch vụ" as UC1
  usecase "2. Nhập liệu và theo dõi hóa đơn" as UC2
  usecase "3. Hiển thị cảnh báo đến hạn" as UC3
  usecase "4. Lưu trữ đối chiếu giao dịch" as UC4
  usecase "5. Xem thống kê và biểu đồ trực quan" as UC5
  usecase "6. Quản lý chứng từ điện tử" as UC6
  usecase "7. Bộ lọc và tìm kiếm lịch sử" as UC7
}

user --> UC1
user --> UC2
user --> UC3
user --> UC4
user --> UC5
user --> UC6
user --> UC7

' Các phụ thuộc logic
UC4 .up.> UC2 : <<extend>> \n(Ghi nhận GD cho HĐ)
UC6 .up.> UC4 : <<include>> \n(Đính kèm ảnh khi giao dịch)
@enduml
```

## 2. Biểu đồ ERD (Thực thể Liên kết - Cơ sở dữ liệu)
Được thiết kế chuẩn hóa để lưu trữ toàn bộ các thông tin từ nhà cung cấp, hóa đơn, thông số tiêu thụ cho đến đối chiếu giao dịch.

```plantuml
@startuml
hide circle
skinparam linetype ortho

entity "DanhMucDichVu" as DanhMucDichVu {
  * MaDichVu : VARCHAR(10) <<PK>>
  --
  * TenDichVu : NVARCHAR(100) (VD: EVN, Viettel)
  * LoaiDichVu : NVARCHAR(50) (VD: Điện, Nước, Internet)
  * NhaCungCap : NVARCHAR(100)
  GhiChu : NVARCHAR(255)
}

entity "HoaDon" as HoaDon {
  * MaHoaDon : VARCHAR(20) <<PK>>
  --
  * MaDichVu : VARCHAR(10) <<FK>>
  * KyCuoc : VARCHAR(10) (VD: 05/2024)
  * SoTienCanDong : FLOAT
  ChiSoTieuThu : FLOAT (VD: kWh, Khối nước)
  * HanThanhToan : DATE
  * TrangThai : INT (0: Chưa thanh toán, 1: Đã thanh toán)
  GhiChu : NVARCHAR(255)
}

entity "GiaoDich" as GiaoDich {
  * MaGiaoDich : VARCHAR(20) <<PK>>
  --
  * MaHoaDon : VARCHAR(20) <<FK>>
  * NgayThanhToan : DATE
  * SoTienThanhToan : FLOAT
  * NenTangGiaoDich : NVARCHAR(100) (VD: VCB Digibank, Momo)
  GhiChu : NVARCHAR(255)
}

entity "ChungTuDienTu" as ChungTuDienTu {
  * MaChungTu : VARCHAR(20) <<PK>>
  --
  * MaGiaoDich : VARCHAR(20) <<FK>>
  * DuongDanAnh : VARCHAR(255) (Link file biên lai/ảnh chụp)
  * LoaiChungTu : NVARCHAR(50)
  NgayTaiLen : DATE
}

DanhMucDichVu ||--o{ HoaDon : "Có các hóa đơn"
HoaDon ||--o| GiaoDich : "Được thanh toán qua"
GiaoDich ||--o{ ChungTuDienTu : "Đính kèm"

@enduml
```

## 3. Biểu đồ Hoạt động (Activity Diagram) - Quy trình quản lý 1 hóa đơn
Mô tả luồng người dùng xử lý nghiệp vụ kể từ lúc nhận thông báo đóng tiền đến lúc hoàn tất giao dịch và lưu trữ chứng từ.

```plantuml
@startuml
skinparam conditionStyle inside

start
:Nhận thông báo cước từ Nhà cung cấp;
:Đăng nhập hệ thống;
:Nhập dữ liệu hóa đơn mới\n(Kỳ cước, số tiền, chỉ số tiêu thụ, hạn cuối);

if (Thanh toán ngay?) then (Có)
  :Chuyển tiền qua nền tảng giao dịch (VCB, VPBank...);
else (Không)
  :Lưu hóa đơn (Trạng thái: Chưa thanh toán);
  repeat
    :Hệ thống theo dõi thời gian;
    if (Sắp đến Hạn thanh toán?) then (Có)
      :Hiển thị Cảnh báo đến hạn;
    else (Không)
    endif
  repeat while (Người dùng chưa thanh toán)
  :Tiến hành thanh toán qua nền tảng;
endif

:Ghi nhận đối chiếu giao dịch\n(Nhập số tiền đã thanh toán, chọn Nền tảng);
:Upload đính kèm hình ảnh biên lai / chụp màn hình (Chứng từ);
:Hệ thống cập nhật Trạng thái hóa đơn = Đã thanh toán;
:Lưu trữ dữ liệu phục vụ thống kê & tìm kiếm;
stop
@enduml
```

## 4. Biểu đồ Kiến trúc MVC (Class Diagram)
Áp dụng cấu trúc thư mục từ file giáo trình (`controllers`, `models`, `views`, `connection.php`). Biểu đồ này giúp hình dung luồng code phía backend.

```plantuml
@startuml
package "Views" {
  class "danhsachdichvu.php"
  class "nhaphoadon.php"
  class "canhbao.php"
  class "thongke.php"
}

package "Controllers" {
  class "DichVuController" {
    + index()
    + themDichVu()
  }
  class "HoaDonController" {
    + index()
    + nhapLieu()
    + capNhatGiaoDich()
    + canhBaoHanCho()
  }
  class "ThongKeController" {
    + xemBaoCao()
    + locDuLieu()
  }
}

package "Models" {
  class "DichVu" {
    + db: Connection
    + getAll()
  }
  class "HoaDon" {
    + db: Connection
    + getHoaDonChuaThanhToan()
    + saveHoaDon()
    + updateTrangThai()
  }
  class "GiaoDichChungTu" {
    + db: Connection
    + saveGiaoDich()
    + uploadAnh()
  }
}

class "DB (connection.php)" as DB {
  + static getInstance(): PDO
}

Controllers ..> Models : "Lấy & Lưu dữ liệu"
Controllers ..> Views : "Truyền data & Render giao diện"
Models --> DB : "Thực thi SQL"
@enduml
```
