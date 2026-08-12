# BỘ BIỂU ĐỒ UML HỆ THỐNG QUẢN LÝ CHI TIÊU VÀ TIỆN ÍCH CÁ NHÂN

Dựa trên hệ thống thực tế đã được xây dựng, dưới đây là bộ biểu đồ UML chuẩn hóa.

## 1. Biểu đồ Use Case (Use Case Diagram)
Mô tả các chức năng mà các tác nhân (Actor) có thể thực hiện trên hệ thống. 

```mermaid
usecaseDiagram
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
    
    %% Mở rộng và bao gộp
    UC7 ..> UC6 : <<extend>>
    UC4 ..> UC2 : <<include>>
    UC5 ..> UC2 : <<include>>
    UC6 ..> UC2 : <<include>>
    UC8 ..> UC2 : <<include>>
```

---

## 2. Biểu đồ Lớp / Thực thể (Class / ER Diagram)
Mô tả cấu trúc dữ liệu vật lý và các mối quan hệ (Primary Key / Foreign Key) giữa các bảng trong MySQL. Hệ thống thiết kế theo hướng Multi-tenant (mọi dữ liệu đều gắn với `nguoi_dung_id`).

```mermaid
erDiagram
    NGUOI_DUNG {
        bigint id PK
        varchar ten_dang_nhap
        varchar mat_khau
        varchar ho_ten
        varchar email
        tinyint vai_tro "0: User, 1: Admin"
        datetime lan_dang_nhap_cuoi
    }

    NHA_CUNG_CAP {
        bigint id PK
        varchar ten
        varchar dia_chi
        varchar so_dien_thoai
        bigint nguoi_dung_id FK
    }

    DICH_VU {
        bigint id PK
        varchar ten_dich_vu
        text mo_ta
        bigint nha_cung_cap_id FK
        bigint nguoi_dung_id FK
    }

    HOA_DON {
        bigint id PK
        tinyint loai_hoa_don
        varchar ky_cuoc "MM/YYYY"
        float so_tien_can_dong
        varchar chi_so_tieu_thu
        datetime ngay_han_chot
        varchar trang_thai "0: Chưa thanh toán, 1: Đã thanh toán"
        bigint dich_vu_id FK
        bigint nha_cung_cap_id FK
        bigint nguoi_dung_id FK
    }

    CHUNG_TU_DIEN_TU {
        bigint id PK
        varchar loai_chung_tu
        varchar duong_dan_file
        datetime ngay_tai_len
        bigint hoa_don_id FK "Unique"
    }

    %% Mối quan hệ
    NGUOI_DUNG ||--o{ NHA_CUNG_CAP : "Quản lý"
    NGUOI_DUNG ||--o{ DICH_VU : "Quản lý"
    NGUOI_DUNG ||--o{ HOA_DON : "Sở hữu"

    NHA_CUNG_CAP ||--o{ DICH_VU : "Cung cấp"
    NHA_CUNG_CAP ||--o{ HOA_DON : "Thuộc về"
    
    DICH_VU ||--o{ HOA_DON : "Phát sinh"
    HOA_DON ||--o| CHUNG_TU_DIEN_TU : "Có (tối đa 1)"
```

---

## 3. Biểu đồ Hoạt động (Activity Diagram)

### 3.1. Luồng cập nhật trạng thái Hóa đơn & Upload Chứng từ
Mô phỏng chi tiết hành động khi người dùng thực hiện thanh toán một hóa đơn định kỳ.

```mermaid
flowchart TD
    Start((Bắt đầu)) --> A[Người dùng chọn Hóa đơn chưa thanh toán]
    A --> B[Nhấn nút 'Cập nhật Thanh toán']
    B --> C{Xác nhận số tiền?}
    C -- Không --> A
    C -- Có --> D[Hệ thống chuyển trạng thái Hóa đơn thành 'Đã thanh toán']
    D --> E{Người dùng có Upload biên lai không?}
    E -- Không --> End((Kết thúc))
    E -- Có --> F[Người dùng chọn File hình ảnh/PDF]
    F --> G[Hệ thống kiểm tra định dạng và dung lượng]
    G --> H{Hợp lệ?}
    H -- Không --> I[Báo lỗi File không hợp lệ] --> F
    H -- Có --> J[Lưu File vào thư mục `resource/assets/uploads/`]
    J --> K[Ghi thông tin đường dẫn vào bảng `chung_tu_dien_tu`]
    K --> End
```

### 3.2. Luồng xem Thống kê & Biểu đồ (Dashboard)
Mô phỏng logic xử lý khi người dùng vào trang chủ hoặc tiến hành lọc tháng.

```mermaid
flowchart TD
    Start((Mở Dashboard)) --> A[Controller lấy thông tin User đang đăng nhập]
    A --> B[Truy vấn tổng số Hóa đơn chưa thanh toán & Tổng tiền]
    B --> C[Lấy danh sách các Hóa đơn sắp/đã quá hạn chót]
    C --> D{Người dùng có chọn Tháng lọc không?}
    
    D -- Không chọn --> E[Lấy tổng tiền các hóa đơn gom nhóm theo Kỳ cước]
    E --> F[Vẽ Biểu đồ Cột - Bar Chart so sánh chi phí theo tháng]
    F --> H
    
    D -- Chọn 1 tháng cụ thể --> G[Lấy tổng tiền các hóa đơn trong tháng đó, gom nhóm theo Dịch vụ]
    G --> G1[Vẽ Biểu đồ Tròn - Pie Chart thể hiện cơ cấu chi phí]
    G1 --> H
    
    H[Render giao diện Trang chủ hoàn chỉnh] --> End((Kết thúc hiển thị))
```
